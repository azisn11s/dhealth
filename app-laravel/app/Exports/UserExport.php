<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    function __construct(array $payload = [])
    {
        #
    }

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        $query = User::query()->orderBy('created_at', 'desc')
            ->select([
                DB::raw('ROW_NUMBER() OVER(ORDER BY created_at DESC) AS Row'),
                'name',
                'email',
                'created_at',
                'email_verified_at',
            ]);

        return $query;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Fullname',
            'email',
            'Registered At',
            'Email Verified At',
        ];
    }
}
