<?php

use App\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesTableSeeder extends Seeder
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
                Feature::query()->updateOrCreate(
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
                'slug'=> 'user',
                'name'=> 'User',
                'description'=> 'Manage user in a company',
                'is_active'=> true,
                'actions'=> [
                    'view', 'create', 'edit', 'delete'
                ]
            ],
        ]);
    }
}
