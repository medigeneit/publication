<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $permissionPrefix = [
            'Admin',
            'Roles',
            'Category',
            'Price Category',
            'Author',
            'Publisher',
            'Contributor Type',
            'Cost Variable',
            'Press',
            'Raw Product',
            'Request',
            'Responce',
        ];

        $commonPart = [
            'List',
            'Create',
            'Edit',
            'Download'
        ];

        $permissions = DB::table('permissions')->pluck('name')->toArray() ?? [];

        foreach ($permissionPrefix as $prefix) {
            foreach ($commonPart as $part) {
                if (!in_array("{$prefix} {$part}", $permissions)) {
                    $data[] = [
                        'name' => "{$prefix} {$part}",
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        

        DB::table('permissions')->insert($data);
    }
}
