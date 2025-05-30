<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomField;
use App\Models\LeadSource;
use App\Models\PipelineStage;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    //     User::factory(10)->create();

    //         User::factory()->create([
    //             'name' => 'Test Admin',
    //             'email' => 'admin@example.com',
    //         ]);
    //         User::factory()->create([
    //         'name' => 'Test Admin',
    //         'email' => 'admin@admin.com',
    //     ]);

    //     Customer::factory()
    //         ->count(10)
    //         ->create();

    //     $leadSources = [
    //         'FB',
    //         'Online AD',
    //         'Twitter',
    //         'LinkedIn',
    //         'Webinar',
    //         'Trade Show',
    //         'Referral',
    //     ];

    //     foreach ($leadSources as $leadSource) {
    //         LeadSource::create(['name' => $leadSource]);
    //     }

    //     $tags = [
    //         'Priority',
    //         'VIP'
    //     ];

    //     foreach ($tags as $tag) {
    //         Tag::create(['name' => $tag]);
    //     }

    //     $pipelineStages = [
    //         [
    //             'name' => 'Lead',
    //             'position' => 1,
    //             'is_default' => true,
    //         ],
    //         [
    //             'name' => 'Contact Made',
    //             'position' => 2,
    //         ],
    //         [
    //             'name' => 'Proposal Made',
    //             'position' => 3,
    //         ],
    //         [
    //             'name' => 'Proposal Rejected',
    //             'position' => 4,
    //         ],
    //         [
    //             'name' => 'Customer',
    //             'position' => 5,
    //         ]
    //     ];

    //     foreach ($pipelineStages as $stage) {
    //         PipelineStage::create($stage);
    //     }

    //     $defaultPipelineStage = PipelineStage::where('is_default', true)->first()->id;
    //     Customer::factory()->count(10)->create([
    //         'pipeline_stage_id' => $defaultPipelineStage,
    //     ]);

    //     $customFields = [
    //         'Birth Date',
    //         'Company',
    //         'Job Title',
    //         'Family Members',
    //     ];

    //     foreach ($customFields as $customField) {
    //         CustomField::create(['name' => $customField]);
    //     }
    //   $roles = [
    //     'Admin',
    //     'Employee'
    // ];

    // foreach ($roles as $role) {
    //     Role::create(['name' => $role]);
    // }

    // User::factory()->create([
    //     'name' => 'Test Admin',
    //     'email' => 'admin@admin.com',
    //     'role_id' => Role::where('name', 'Admin')->first()->id,
    // ]);

    // // We will seed 10 employees
    // User::factory()->count(10)->create([
    //     'role_id' => Role::where('name', 'Employee')->first()->id,
    // ]);


       $products = [
        ['name' => 'Work Permit', 'price' => 12.99],
    ];

    foreach ($products as $product) {
        Product::create($product);
    }

    }

}
