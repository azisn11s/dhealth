<?php

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Warehouse::query()->updateOrCreate([
            'code'=> 'WRH-001A'
        ], [
            'name'=> 'Gudang Satu',
            'code'=> 'WRH-001A',
            'description'=> 'Gudang pertama PT Mahisa Media', 
            'address' => 'Jl. Jati Utama 2A, Margaasih, Bandung'
        ]);
    }
}
