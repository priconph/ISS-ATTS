<?php

namespace App\Http\Controllers;

use App\RaijinUser;
use App\Tablet;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ScanningController extends Controller
{
    public function scanning_check_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $tabled_details = Tablet::where('serial_number', $request->scan_data)
        ->where('is_deleted', 0)
        ->where('is_checked', 0)
        ->get();

        if(count($tabled_details) > 1){
            return response()->json(['result' => 0, 'message' => 'Duplicate Record / Serial Number']);
        }
        if(count($tabled_details) == 0){
            $tabled_details = Tablet::where('asset_tag', $request->scan_data)
            ->where('is_deleted', 0)
            ->where('is_checked', 0)
            ->get();

            if(count($tabled_details) > 1){
                return response()->json(['result' => 0, 'message' => 'Duplicate Record / Asset Tag']);
            }
            else if(count($tabled_details) == 0){
                return response()->json(['result' => 2, 'message' => 'Error Scan Again']);
            }
            else{
                Tablet::where('id', $tabled_details[0]['id'])
                ->update([
                    'is_checked' => 1
                ]);
    
                return response()->json(['result' => 1]);
            }
        }
        else{
            Tablet::where('id', $tabled_details[0]['id'])
            ->update([
                'is_checked' => 1
            ]);

            return response()->json(['result' => 1]);
        }
        // return count($tabled_details);

    }
}
