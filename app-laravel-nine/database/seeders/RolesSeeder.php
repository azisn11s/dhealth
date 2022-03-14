<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {

            $this->collection()->each(function ($item) {
                Role::updateOrCreate(
                    \Illuminate\Support\Arr::only($item, ['slug']),
                    $item
                );
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function collection(): \Illuminate\Support\Collection
    {
        return collect([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => [
                    'view-post' => true,
                ]
            ],
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'permissions' => [
                    'view-post' => true,
                ]
            ]
        ]);
    }
}
