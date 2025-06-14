<x-filament-panels::page>
    <x-filament::card wire:ignore.self>
        <div>
            <div class="w-full h-full flex space-x-4 rtl:space-x-reverse overflow-x-auto">
                @foreach($statuses as $status)
                    <div class="h-full flex-1">
                        <div class="bg-primary-200 rounded px-2 flex flex-col h-full" id="{{ $status['id'] }}">
                            <div class="flex items-center justify-between text-base font-semibold text-primary-800 border-b border-primary-300 pb-2 px-3 pt-3">
                                {{ $status['title'] }}
                                      <span
                                class="text-xs font-medium text-primary-600 bg-primary-50 rounded-full px-2 py-0.5"
                            >
                                {{ count($status['records']) }}
                            </span>
                            </div>
                            {{-- <div
                                    id="{{ $status['kanbanRecordsId'] }}"
                                    data-status-id="{{ $status['id'] }}"
                                    class="space-y-2 p-2 flex-1 overflow-y-auto">

                                @foreach($status['records'] as $record)
                                    <div
                                            id="{{ $record['id'] }}"
                                            class="shadow bg-white dark:bg-gray-800 p-2 rounded border">

                                        <p>
                                            {{ $record['title'] }}
                                        </p>

                                    </div>
                                @endforeach
                            </div> --}}
                                        <div
                            class="flex-1 space-y-3 overflow-y-auto px-3 py-2"
                            id="{{ $status['kanbanRecordsId'] }}"
                            data-status-id="{{ $status['id'] }}"
                        >
                            @foreach ($status['records'] as $record)
                                <div
                                    id="{{ $record['id'] }}"
                                    class="bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition cursor-move"
                                >
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-100">
                                        {{ $record['title'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        </div>
                    </div>
                @endforeach
            </div>


            <div wire:ignore>
                <script>
                    window.onload = () => {
                        @foreach($statuses as $status)
                        {{-- Space here is needed to fix the Livewire issue where it adds comment block breaking JS scripts--}}
                        Sortable.create(document.getElementById('{{ $status['kanbanRecordsId'] }}'), {
                            group: '{{ $status['group'] }}',
                            animation: 0,
                            ghostClass: 'bg-warning-600',

                            setData: function (dataTransfer, dragEl) {
                                dataTransfer.setData('id', dragEl.id);
                            },

                            onEnd: function (evt) {
                                const sameContainer = evt.from === evt.to;
                                const orderChanged = evt.oldIndex !== evt.newIndex;

                                if (sameContainer && !orderChanged) {
                                    return;
                                }

                                const recordId = evt.item.id;
                                const toStatusId = evt.to.dataset.statusId;

                                @this.
                                dispatch('statusChangeEvent', {
                                    id: recordId,
                                    pipeline_stage_id: toStatusId
                                });
                            },
                        });
                        @endforeach
                    }
                </script>

            </div>
        </div>
    </x-filament::card>
</x-filament-panels::page>
