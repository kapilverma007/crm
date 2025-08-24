<?php

namespace App\Filament\Resources;

use App\Filament\Imports\CustomerImporter;
use App\Filament\Resources\ContractResource\Pages\CreateContract;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\PipelineStage;
use App\Models\Role;
use App\Models\User;
use App\Models\Task;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Get;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Actions\Action;
use App\Filament\Resources\QuoteResource\Pages\CreateQuote;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Support\Facades\Auth;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // This is where we define what fields we want to have in our form
        return $form
            ->schema([
                Forms\Components\Section::make('Employee Information')
                    ->schema([
                        Forms\Components\Select::make('employee_id')
                            ->options(User::where('role_id', Role::where('name', 'Employee')->first()->id)->pluck('name', 'id'))
                    ])
                    ->hidden(!auth()->user()->isAdmin()),
                Forms\Components\Section::make('Customer Details')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->maxLength(255)->required(),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255)->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)->required(),
                        Forms\Components\TextInput::make('phone_number')
                            ->maxLength(255)->required(),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535),
                        // Forms\Components\TextInput::make('contract_amount')
                    ])
                    ->columns(),
                         Forms\Components\Section::make('Customer Contract Fields')
                    ->relationship('customerContractField')
                    ->schema([

                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('service')
                            ->maxLength(255),
                         Forms\Components\TextInput::make('city')->label('Country')
                            ->maxLength(255),
                                Forms\Components\TextInput::make('total_contract_amount')
                             ->numeric(),
                              Forms\Components\TextInput::make('registration')
                             ->numeric(),
                                    Forms\Components\TextInput::make('on_receiving_job_offer_letter_amount')
                             ->numeric(),
                                    Forms\Components\TextInput::make('on_receiving_work_permit_amount')
                             ->numeric(),
                                 Forms\Components\TextInput::make('on_receiving_embassy_appointment_amount')
                             ->numeric(),
                              Forms\Components\TextInput::make('after_visa_amount')
                             ->numeric()
                    ])
                    ->columns(),
                Forms\Components\Section::make('Lead Details')
                    ->schema([
                        Forms\Components\Select::make('lead_source_id')
                            ->relationship('leadSource', 'name'),
                        Forms\Components\Select::make('tags')
                            ->relationship('tags', 'name'),
                        Forms\Components\Select::make('pipeline_stage_id')
                            ->relationship('pipelineStage', 'name', function ($query) {
                                $query->orderBy('position', 'asc');
                            })
                            ->default(PipelineStage::where('is_default', true)->first()?->id)
                    ])
                    ->columns(3),
                Forms\Components\Section::make('Documents')
                    // This will make the section visible only on the edit page
                    ->visibleOn('edit')
                    ->schema([
                        Forms\Components\Repeater::make('documents')
                            ->relationship('documents')
                            ->hiddenLabel()
                            ->reorderable(false)
                            ->addActionLabel('Add Document')
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->required(),
                                Forms\Components\Textarea::make('comments'),
                            ])
                            ->columns()
                    ]),
                Forms\Components\Section::make('Contracts')
                    // This will make the section visible only on the edit page
                    ->visibleOn('edit')
                    ->schema([
                        Forms\Components\Repeater::make('contracts')
                            ->relationship('contracts')
                            ->hiddenLabel()
                            ->reorderable(false)
                            ->addActionLabel('Add Contract')
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->required(),
                                Forms\Components\Textarea::make('comments'),
                            ])
                            ->columns()
                    ]),
                // Forms\Components\Section::make('Additional fields')
                //     ->schema([
                //         Forms\Components\Repeater::make('fields')
                //             ->hiddenLabel()
                //             ->relationship('customFields')
                //             ->schema([
                //                 Forms\Components\Select::make('custom_field_id')
                //                     ->label('Field Type')
                //                     ->options(CustomField::pluck('name', 'id')->toArray())
                //                     // We will disable already selected fields
                //                     ->disableOptionWhen(function ($value, $state, Get $get) {
                //                         return collect($get('../*.custom_field_id'))
                //                             ->reject(fn($id) => $id === $state)
                //                             ->filter()
                //                             ->contains($value);
                //                     })
                //                     ->required()
                //                     // Adds search bar to select
                //                     ->searchable()
                //                     // Live is required to make sure that the options are updated
                //                     ->live(),
                //                 Forms\Components\TextInput::make('value')
                //                     ->required()
                //             ])
                //             ->addActionLabel('Add another Field')
                //             ->columns(),
                //     ]),

            ]);


    }

    public static function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextEntry::make('full_name'),
                        TextEntry::make('city'),
                        TextEntry::make('contract_amount')->hidden(fn($record) => blank($record->contract_amount))
                    ])
                    ->columns(),
            Section::make('Contract Information')
                ->hidden(fn($record) => !$record->customerContractField) // Only show if contract exists
                ->schema(components: [
                    TextEntry::make('customerContractField.address')->label('Address'),
                    TextEntry::make('customerContractField.city')->label('City'),
                    TextEntry::make('customerContractField.total_contract_amount')->label('Total Contract Amount'),
                    TextEntry::make('customerContractField.on_receiving_job_offer_letter_amount')->label('Job Offer Letter Amount'),
                    TextEntry::make('customerContractField.on_receiving_work_permit_amount')->label('Work Permit Amount'),
                    TextEntry::make('customerContractField.on_receiving_embassy_appointment_amount')->label('Embassy Appointment Amount'),
                    TextEntry::make('customerContractField.after_visa_amount')->label('After Visa Amount'),
                ])
                ->columns(),
                Section::make('Additional Details')
                    ->schema([
                        TextEntry::make('description'),
                    ]),
                Section::make('Lead and Stage Information')
                    ->schema([
                        TextEntry::make('leadSource.name'),
                        TextEntry::make('pipelineStage.name'),
                    ])
                    ->columns(),
                Section::make('Additional fields')
                    ->hidden(fn($record) => $record->customFields->isEmpty())
                    ->schema(
                        // We are looping within our relationship, then creating a TextEntry for each Custom Field
                        fn($record) => $record->customFields->map(function ($customField) {
                            return TextEntry::make($customField->customField->name)
                                ->label($customField->customField->name)
                                ->default($customField->value);
                        })->toArray()
                    )
                    ->columns(),
                Section::make('Documents')
                    // This will hide the section if there are no documents
                    ->hidden(fn($record) => $record->documents->isEmpty())
                    ->schema([
                        RepeatableEntry::make('documents')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('file_path')
                                    ->label('Document')
                                    // This will rename the column to "Download Document" (otherwise, it's just the file name)
                                    ->formatStateUsing(fn() => "Download Document")
                                    // URL to be used for the download (link), and the second parameter is for the new tab
                                    ->url(fn($record) => Storage::url($record->file_path), true)
                                    // This will make the link look like a "badge" (blue)
                                    ->badge()
                                    ->color(Color::Blue),
                                TextEntry::make('comments'),
                            ])
                            ->columns()
                    ]),
                Section::make('Contract')
                    ->hidden(fn($record) => !$record->contracts) // Only show if contract exists
                    ->schema([
                        TextEntry::make('contracts.file_path')
                            ->label('Contract')
                            ->formatStateUsing(fn() => 'Download Contract')
                            ->url(fn($record) => Storage::url($record->contracts->file_path), true)
                            ->badge()
                            ->color(Color::Blue),
                        TextEntry::make('contracts.comments')
                            ->label('Comments'),
                    ]),
                Section::make('Pipeline Stage History and Notes')
                    ->schema([
                        ViewEntry::make('pipelineStageLogs')
                            ->label('')
                            ->view('infolists.components.pipeline-stage-history-list')
                    ])
                    ->collapsible(),
                Tabs::make('Tasks')
                    ->tabs([
                        Tabs\Tab::make('Completed')
                            ->badge(fn($record) => $record->completedTasks->count())
                            ->schema([
                                RepeatableEntry::make('completedTasks')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('description')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('employee.name')
                                            ->hidden(fn($state) => is_null($state)),
                                        TextEntry::make('due_date')
                                            ->hidden(fn($state) => is_null($state))
                                            ->date(),
                                    ])
                                    ->columns()
                            ]),
                        Tabs\Tab::make('Incomplete')
                            ->badge(fn($record) => $record->incompleteTasks->count())
                            ->schema([
                                RepeatableEntry::make('incompleteTasks')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('description')
                                            ->html()
                                            ->columnSpanFull(),
                                        TextEntry::make('employee.name')
                                            ->hidden(fn($state) => is_null($state)),
                                        TextEntry::make('due_date')
                                            ->hidden(fn($state) => is_null($state))
                                            ->date(),
                                        TextEntry::make('is_completed')
                                            ->formatStateUsing(function ($state) {
                                                return $state ? 'Yes' : 'No';
                                            })
                                            ->suffixAction(
                                                Action::make('complete')
                                                    ->button()
                                                    ->requiresConfirmation()
                                                    ->modalHeading('Mark task as completed?')
                                                    ->modalDescription('Are you sure you want to mark this task as completed?')
                                                    ->action(function (Task $record) {
                                                        $record->is_completed = true;
                                                        $record->save();

                                                        Notification::make()
                                                            ->title('Task marked as completed')
                                                            ->success()
                                                            ->send();
                                                    })
                                            ),
                                    ])
                                    ->columns(3)
                            ])
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        // This is where we define our table columns, filters, actions, and any other table-related things
        return $table
            ->modifyQueryUsing(function ($query) {
                // Here we are eager loading our tags to prevent N+1 issue
                return $query->with('tags');
            })
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->hidden(!auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('full_name')
                    ->formatStateUsing(function ($record) {
                        $tagsList = view('customer.tagsList', ['tags' => $record->tags])->render();

                        return $record->full_name .  ' ' . $tagsList;
                    })
                    ->html()
                    ->searchable(['full_name']),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('leadSource.name'),
                Tables\Columns\TextColumn::make('pipelineStage.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(CustomerImporter::class)
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->hidden(fn($record) => $record->trashed()),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),

                    Tables\Actions\Action::make('Move to Stage')
                        ->hidden(fn($record) => $record->trashed())
                        ->icon('heroicon-m-pencil-square')
                        ->form([
                            Forms\Components\Select::make('pipeline_stage_id')
                                ->label('Status')
                                ->options(PipelineStage::pluck('name', 'id')->toArray())
                                ->default(function (Customer $record) {
                                    $currentPosition = $record->pipelineStage->position;
                                    return PipelineStage::where('position', '>', $currentPosition)->first()?->id;
                                }),
                            Forms\Components\Textarea::make('notes')
                                ->label('Notes')
                        ])
                        ->action(function (Customer $customer, array $data): void {
                            $customer->pipeline_stage_id = $data['pipeline_stage_id'];
                            $customer->save();

                            $customer->pipelineStageLogs()->create([
                                'pipeline_stage_id' => $data['pipeline_stage_id'],
                                'notes' => $data['notes'],
                                'user_id' => auth()->id()
                            ]);


                            Notification::make()
                                ->title('Customer Pipeline Updated')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('Add Task')
                        ->icon('heroicon-s-clipboard-document')
                        ->form([
                            Forms\Components\RichEditor::make('description')
                                ->required(),
                            auth()->user()->isAdmin()
                                ?  Forms\Components\Select::make('user_id')
                                ->label('Employee')
                                ->preload()
                                ->searchable()
                                ->relationship('employee', 'name')
                                :  Forms\Components\Hidden::make('user_id')
                                ->default(auth()->id()),
                            // non-admin cannot change
                            Forms\Components\DatePicker::make('due_date')
                                ->native(false),

                        ])

                        ->action(function (Customer $customer, array $data) {
                            $customer->tasks()->create($data);

                            Notification::make()
                                ->title('Task created successfully')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('Create Invoice')
                        ->icon('heroicon-m-book-open')
                        ->url(function ($record) {
                            return CreateQuote::getUrl(['customer_id' => $record->id]);
                        })->visible(function ($record) {
                              $user = Auth::user();

        // Only show if:
        // - user is not role 2
        // - and contract exists for that customer
        return $user->role_id != 2 && Contract::where('customer_id', $record->id)->exists();
                            // return Contract::where('customer_id', $record->id)->exists();
                        }),
                    Tables\Actions\Action::make('Download Contract')
                        ->icon('heroicon-m-book-open')
                        ->url(fn($record) => Storage::url($record->contracts?->file_path), true)
                        ->visible(function ($record) {
                            return Contract::where('customer_id', $record->id)->exists();
                        }),
                    Tables\Actions\Action::make('Create Contract')
                        ->icon('heroicon-m-book-open')
                        ->action(function ($record) {
                    $contract = $record->customerContractField;

                    $address = $contract?->address;
                    $service = $contract?->service;
                    $city = $contract?->city;

                    // $Registration = $contract?->registration;
                    // $On_Receiving_job_Offer_Letter_Amount = $contract?->on_receiving_job_offer_letter_amount;
                    // $On_Receiving_Work_Permit_Amount = $contract?->on_receiving_work_permit_amount;
                    // $On_Receiving_Embassy_Appointment = $contract?->on_receiving_embassy_appointment_amount;
                    // $After_Visa_Amount = $contract?->after_visa_amount;
                    // $Contract_Amount = $contract?->total_contract_amount;
          function addSAR($amount) {
    return $amount !== null ? $amount . ' SAR' : null;
}

$Registration = addSAR($contract?->registration);
$On_Receiving_job_Offer_Letter_Amount = addSAR($contract?->on_receiving_job_offer_letter_amount);
$On_Receiving_Work_Permit_Amount = addSAR($contract?->on_receiving_work_permit_amount);
$On_Receiving_Embassy_Appointment = addSAR($contract?->on_receiving_embassy_appointment_amount);
$After_Visa_Amount = addSAR($contract?->after_visa_amount);
$Contract_Amount = addSAR($contract?->total_contract_amount);
                            $date = now()->format('d-m-Y');
                            // Call the same logic as generate()
                            $user = $record;
                            $timestamp = now()->format('Ymd_His');
                            $fileBaseName = 'contract_user_' .  \Illuminate\Support\Str::slug($user->full_name) . '_' . $user->id . '_' . $timestamp;
                            $docxFileName = $fileBaseName . '.docx';
                            $pdfFileName = $fileBaseName . '.pdf';
                            $res = Contract::updateOrCreate(
                                ['customer_id' => $user->id],
                                [
                                    'file_path' => 'contracts/' . $pdfFileName, // Save PDF file path
                                    'employee_id' => auth()->id(),
                                ]
                            );
                            $contract_no = "FC" . $res->id;
                            \Illuminate\Support\Facades\Storage::makeDirectory('public/contracts');

                            $template = new   \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/template/contract.docx'));
                            $template->setValue('full_name', $user->full_name);
                            $template->setValue('email', $user->email);
                            $template->setValue('phone_number', $user->phone_number);
                            $template->setValue('Address', $address);
                            $city = preg_replace('/\s+/', ' ', trim($city));
                            $template->setValue('city', $city);
                            $service = preg_replace('/\s+/', ' ', trim($service));
                            $template->setValue('service', $service);
                            $template->setValue('Registration', $Registration);
                            $template->setValue('On_Receiving_job_Offer_Letter_Amount', $On_Receiving_job_Offer_Letter_Amount);
                            $template->setValue('On_Receiving_Work_Permit_Amount', $On_Receiving_Work_Permit_Amount);
                            $template->setValue('On_Receiving_Embassy_Appointment', $On_Receiving_Embassy_Appointment);
                            $template->setValue('After_Visa_Amount', $After_Visa_Amount);
                            $template->setValue('Contract_Amount', $Contract_Amount);
                            $template->setValue('date', $date);
                            $template->setValue('contract_no', $contract_no);

                            $outputDocxPath = storage_path("app/public/contracts/{$docxFileName}");
                            $template->saveAs($outputDocxPath); // Save the .docx file

                            // Convert to PDF
                            $pdfPath = storage_path('app/public/contracts');
                            $pdfFileName = basename($outputDocxPath, '.docx') . '.pdf';
                            $pdfFullPath = $pdfPath . '/' . $pdfFileName;

                            putenv("HOME=/var/www");

                            $libreoffice = '/usr/bin/libreoffice'; // Or use '/usr/bin/soffice'
                            $command = "$libreoffice --headless --convert-to pdf --outdir " . escapeshellarg($pdfPath) . " " . escapeshellarg($outputDocxPath);

                            // Log and execute command
                            \Log::info("Running command: " . $command);
                            exec($command, $output, $resultCode);
                            \Log::info('LibreOffice Output: ' . implode("\n", $output));
                            \Log::info('LibreOffice Exit Code: ' . $resultCode);

                            //Check if PDF is generated
                            if ($resultCode === 0 && file_exists($pdfFullPath)) {
                                // Delete the DOCX file after conversion
                                if (file_exists($outputDocxPath)) {
                                    unlink($outputDocxPath);
                                    \Log::info("Deleted DOCX file: " . $outputDocxPath);
                                }

                            } else {
                                \Log::error("PDF NOT GENERATED at " . $pdfFullPath);
                            }

                          //  Optional: flash notification or log
                            Notification::make()
                                ->title('Contract created successfully')
                                ->success()
                                ->send();
                        })->visible(function ($record) {
                            return !Contract::where('customer_id', $record->id)->exists();
                        }),

                ])
            ])->recordUrl(function ($record) {
                if ($record->trashed()) {
                    return null;
                }

                // return Pages\EditCustomer::getUrl([$record->id]);
                return Pages\ViewCustomer::getUrl([$record->id]);
            })
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->hidden(function (Pages\ListCustomers $livewire) {
                        return $livewire->activeTab == 'archived';
                    }),
                Tables\Actions\RestoreBulkAction::make()
                    ->hidden(function (Pages\ListCustomers $livewire) {
                        return $livewire->activeTab != 'archived';
                    }),
            ])->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'view' => Pages\ViewCustomer::route('/{record}'),
        ];
    }
}
