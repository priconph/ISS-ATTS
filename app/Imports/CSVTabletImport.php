<?php

namespace App\Imports;

// use App\User;
use App\Tablet;
use Maatwebsite\Excel\Concerns\ToModel;
// use Auth;

class CSVTabletImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tablet([
            'tablet_status'     => $row[9],
            'asset_tag'         => $row[1],
            'serial_no'         => $row[2],
            'brand'             => $row[3],
            'model'             => $row[4],
            'capacity'          => $row[5],
            'department'        => $row[6],
            'section'           => $row[7],
            'ass_user'          => $row[8],
            'dispo'             => $row[9],
            'date_dispo'        => $row[10],
            'date_purch'        => $row[11],
            'remarks_1'         => $row[12],
            'remarks_2'         => $row[13]
            
        ]);
    }
}
