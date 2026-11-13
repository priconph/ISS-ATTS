<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Tablet;
use App\Exports\ExportTabletRecords;


class ExportTabletController extends Controller
{
    public function export_tablet_data(Request $request, $month,$year){

        $tablet_details_deployed = Tablet::where('disposition',1)
        ->get();

        $tablet_details = Tablet::where('disposition',2)
        ->orWhere('disposition',3)
        ->orWhere('disposition',4)
        ->orWhere('disposition',5)
        ->get();

        // return $year;

        if($month == '01'){
            $buwan = 'JANUARY';
        }

        if($month == '02'){
            $buwan = 'FEBRUARY';
        }

        if($month == '03'){
            $buwan = 'MARCH';
        }

        if($month == '04'){
            $buwan = 'APRIL';
        }

        if($month == '05'){
            $buwan = 'MAY';
        }

        if($month == '06'){
            $buwan = 'JUNE';
        }

        if($month == '07'){
            $buwan = 'JULY';
        }

        if($month == '08'){
            $buwan = 'AUGUST';
        }

        if($month == '09'){
            $buwan = 'SEPTEMBER';
        }

        if($month == '10'){
            $buwan = 'OCTOBER';
        }

        if($month == '11'){
            $buwan = 'NOVEMBER';
        }

        if($month == '12'){
            $buwan = 'DECEMBER';
        }

        $date = date('Ymd',strtotime(NOW()));

        return Excel::download(new ExportTabletRecords(
            $date,
            $tablet_details_deployed,
            $tablet_details,
            $month,
            $year

        ), 'ISS Tablet Records - '.$buwan.' '.$year.'.xlsx');
    }
}
