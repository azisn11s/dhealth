<?php

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
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
                Department::query()->updateOrCreate(
                    \Illuminate\Support\Arr::only($item, ['code']),
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
                'code'=> '00001',
                'name'=> 'Purchasing',
                'description'=> 'Purchasing',
            ],[
                'code'=> '00002',
                'name'=> 'Research & Development',
                'description'=> 'Research & Development',
            ],[
                'code'=> '00003',
                'name'=> 'Marketing',
                'description'=> 'Marketing',
            ],[
                'code'=> '00004',
                'name'=> 'Human Resources',
                'description'=> 'Human Resources',
            ],[
                'code'=> '00005',
                'name'=> 'Calendar',
                'description'=> 'Calendar',
            ],
        ]);
    }
}
