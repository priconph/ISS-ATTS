<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\RaijinUser;
use App\Tablet;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\CSVTabletImport;

class ImportController extends Controller
{
    //
    public function import_tablet(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $collections = Excel::toCollection(new CSVTabletImport, request()->file('import_tablet_file'));
        $dispo_and_stat = '';

        Tablet::where('is_deleted', 0)
        ->update([
            'is_deleted' => 1,
            'updated_at' => NOW()
        ]);
        for($excel_row_start = 2; $excel_row_start < count($collections[0]); $excel_row_start++){
            switch( strtoupper($collections[0][$excel_row_start][9]) ){
                case 'DEPLOYED':
                    $dispo_and_stat = 1;
                    break;
                case 'DISPOSED':
                    $dispo_and_stat = 2;
                    break;
                case 'FOR DISPOSAL':
                    $dispo_and_stat = 3;
                    break;
                case 'DECOMISSIONED':
                    $dispo_and_stat = 4;
                    break;
                case 'MISSING':
                    $dispo_and_stat = 5;
                    break;
                default:
                    $dispo_and_stat = null;
                    break;
            }

            if($collections[0][$excel_row_start][1] == null && $collections[0][$excel_row_start][3] == null && $collections[0][$excel_row_start][4] == null){
                break;
            }

            if($collections[0][$excel_row_start][10] == null || $collections[0][$excel_row_start][10] == "-"){
                $date_dispo_to_db = null;

            }
            else{
                if(is_numeric($collections[0][$excel_row_start][10])){
                    $excel_date_dispo = $collections[0][$excel_row_start][10]; //here is that value 41621 or 41631
                    $unix_date_dispo = ($excel_date_dispo - 25569) * 86400;
                    $excel_date_dispo1 = 25569 + ($unix_date_dispo / 86400);
                    $unix_date_dispo1 = ($excel_date_dispo1 - 25569) * 86400;
                    $date_dispo_to_db = gmdate("Y-m-d", $unix_date_dispo1);
                }
                else{
                    $date_dispo_to_db = $collections[0][$excel_row_start][10];
                }
            }

            if($collections[0][$excel_row_start][11] == null || $collections[0][$excel_row_start][11] == "-"){
                $date_purchase_to_db = null;
            }
            else{
                if(is_numeric($collections[0][$excel_row_start][11])){
                    $excel_date_purchase = $collections[0][$excel_row_start][11]; //here is that value 41621 or 41631
                    $unix_date_purchase = ($excel_date_purchase - 25569) * 86400;
                    $excel_date_purchase1 = 25569 + ($unix_date_purchase / 86400);
                    $unix_date_purchase1 = ($excel_date_purchase1 - 25569) * 86400;

                    $date_purchase_to_db = gmdate("Y-m-d", $unix_date_purchase1);
                }
                else{
                    $date_purchase_to_db = $collections[0][$excel_row_start][11];
                }
            }
            // $test[] = $collections[0][$excel_row_start][10] ;
            $array_tablet_data_to_insert = [
                'tablet_status'     => $dispo_and_stat,
                'asset_tag' => $collections[0][$excel_row_start][1],
                'serial_number' => $collections[0][$excel_row_start][2],
                'brand' => $collections[0][$excel_row_start][3],
                'model' => $collections[0][$excel_row_start][4],
                'capacity' => $collections[0][$excel_row_start][5],
                'department' => $collections[0][$excel_row_start][6],
                'section' => $collections[0][$excel_row_start][7],
                'assigned_user' => $collections[0][$excel_row_start][8],
                'disposition' => $dispo_and_stat,
                'date_of_disposal' =>  $date_dispo_to_db,
                'date_of_purchase' =>  $date_purchase_to_db,
                'remarks_1' => $collections[0][$excel_row_start][12],
                'remarks_2' => $collections[0][$excel_row_start][13],
                'created_by' => $_SESSION["rapidx_user_id"],
                'created_at'    => NOW()
            ];

            Tablet::insert(
                $array_tablet_data_to_insert
            );
        }
        return response()->json(['result' => 1]);

    }
}
