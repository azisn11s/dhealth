<?php

use App\Models\RequestStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusSeeder extends Seeder
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
                RequestStatus::query()->updateOrCreate(
                    \Illuminate\Support\Arr::only($item, ['status']),
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
                'status'=> 'request',
                'caption'=> 'Request',
                'description'=> 'Starting Request Item',
            ],[
                'status'=> 'onproses',
                'caption'=> 'Onprocess',
                'description'=> 'Processing request item',
            ],[
                'status'=> 'succeed',
                'caption'=> 'Succeed',
                'description'=> 'Request item has been achieved successfully',
            ],
        ]);
    }
}
