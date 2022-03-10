<?php

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTableSeeder extends Seeder
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
                Unit::query()->updateOrCreate(
                    \Illuminate\Support\Arr::only($item, ['label']),
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
                'name'=> 'Kilogram',
                'label'=> 'Kg',
            ],[
                'name'=> 'Pieces',
                'label'=> 'pcs',
            ],[
                'name'=> 'Pack',
                'label'=> 'pack',
            ],
        ]);
    }
}
