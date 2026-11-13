<?php

namespace App\Http\Controllers;

use App\RaijinUser;
use App\SysDevAndChangeRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use DataTables;
use Mail;

class SDCRStatusController extends Controller
{
    public function add_sdcr(Request $request){
        date_default_timezone_set('Asia/Manila');
        if(!isset($_SESSION)){
            session_start();
        }

        $data = $request->all();
        if(!isset($request->id_for_edit)){
            $rules = [
                'control_number'                => 'required',
                'project_name'                  => 'required',
                'requestor'                     => 'required',
                'section_department_requestor'  => 'required',
                'request_type'                  => 'required',
                'timeline_start_date'           => 'required',
                'timeline_due_date'             => 'required',
                // 'completion_date'               => 'required', /* edited by Nessa 04252022 */
                'project_status'                => 'required',
                'programmer'                    => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
            if($validator->passes()){
                $insert_details = [
                    'control_number'                =>  $request->control_number,
                    'project_name'                  =>  $request->project_name,
                    'requestor'                     =>  $request->requestor,
                    'section_department_requestor'  =>  $request->section_department_requestor,
                    'request_type'                  =>  $request->request_type,
                    'timeline_start_date'           =>  $request->timeline_start_date,
                    'timeline_due_date'             =>  $request->timeline_due_date ,
                    'testing_start_date'            =>  $request->testing_start_date,
                    'testing_end_date'              =>  $request->testing_end_date,
                    'completion_date'               =>  $request->completion_date,
                    'project_status'                =>  $request->project_status,
                    'programmer'                    =>  $request->programmer,
                    'remarks'                       =>  $request->remarks,
                    'created_by'                    =>  $_SESSION["rapidx_user_id"],
                    'created_at'                    =>  date('Y-m-d H:i:s')
                ];

                if(isset($request->file)){
                    $original_file = $request->file('file')->getClientOriginalName();
                    $insert_details['file'] = $original_file;
                    $insert_details['uploaded_date'] = date('Y-m-d H:i:s');

                    Storage::putFileAs('public/files', $request->file,  $original_file);
                }

                SysDevAndChangeRequestStatus::insert(
                    $insert_details
                );
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validationHasError' => "1", 'error' => $validator->messages()]);
            }
        }else{
            $rules = [
                'control_number'                => 'required',
                'project_name'                  => 'required',
                'requestor'                     => 'required',
                'section_department_requestor'  => 'required',
                'request_type'                  => 'required',
                'timeline_start_date'           => 'required',
                'timeline_due_date'             => 'required',
                // 'completion_date'               => 'required',
                'project_status'                => 'required',
                'programmer'                    => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->passes()){
                $update_details = [
                    'control_number'                =>  $request->control_number,
                    'project_name'                  =>  $request->project_name,
                    'requestor'                     =>  $request->requestor,
                    'section_department_requestor'  =>  $request->section_department_requestor,
                    'request_type'                  =>  $request->request_type,
                    'timeline_start_date'           =>  $request->timeline_start_date,
                    'timeline_due_date'             =>  $request->timeline_due_date ,
                    'testing_start_date'            =>  $request->testing_start_date,
                    'testing_end_date'              =>  $request->testing_end_date,
                    'completion_date'               =>  $request->completion_date,
                    'project_status'                =>  $request->project_status,
                    'programmer'                    =>  $request->programmer,
                    'remarks'                       =>  $request->remarks,
                    'updated_at'                    =>  date('Y-m-d H:i:s'),
                ];

                if(isset($request->file)){
                    $original_file = $request->file('file')->getClientOriginalName();
                    $update_details['file'] = $original_file;
                    $update_details['uploaded_date'] = date('Y-m-d H:i:s');

                    Storage::putFileAs('public/files', $request->file,  $original_file);
                }

                if(isset($request->id_for_edit)){               
                    SysDevAndChangeRequestStatus::where('id', $request->id_for_edit)->update(
                        $update_details
                    );
                    return response()->json(['result' => "1"]);
                }
            }else{
                return response()->json(['validationHasError' => "1", 'error' => $validator->messages()]);
            }
        }
    }


    public function view_system_development(){
        if(!isset($_SESSION)){
            session_start();
        }
        $sessionDepartmentId = $_SESSION["rapidx_department_id"];
        $sessionUserLevelId = $_SESSION["rapidx_user_level_id"];
        
        if($sessionDepartmentId == 1 || $sessionDepartmentId == 2 || $sessionDepartmentId == 48){
            $sysDevAndChangeRequests = SysDevAndChangeRequestStatus::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
            ->where('is_deleted', 0)->where('request_type', 1)->get();
        }else{
            $sysDevAndChangeRequests = SysDevAndChangeRequestStatus::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
                        ->where('is_deleted', 0)->where('request_type', 1)->where('section_department_requestor', $sessionDepartmentId)->get();
        }
        // return $sysDevAndChangeRequests;
                
        return DataTables::of($sysDevAndChangeRequests)
            ->addColumn('project_status', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->project_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-warning">Pending</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">On Going</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 3){
                    $result .= '<center><span class="badge badge-pill badge-success">Completed</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 4){
                    $result .= '<center><span class="badge badge-pill badge-info">Scheduled</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 5){
                    $result .= '<center><span class="badge badge-pill badge-warning">On-hold</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 6){
                    $result .= '<center><span class="badge badge-pill badge-danger">Deferred</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-default">---</span></center>';
                }
                return $result;
            })
            // ->addColumn('request_type', function($sysDevAndChangeRequest){
            //     $result = "";
            //     if($sysDevAndChangeRequest->request_type == 1){
            //         $result .= '<center><span>System Development</span></center>';
            //     }
            //     elseif($sysDevAndChangeRequest->request_type == 2){
            //         $result .= '<center><span">Change Request</span></center>';
            //     }
            //     return $result;
            // })
            ->addColumn('testing_start_date', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->testing_start_date == null){
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                else{
                    $result .= '<center><span">'.$sysDevAndChangeRequest->testing_start_date.'</span></center>';
                }
                return $result;
            })
            ->addColumn('testing_end_date', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->testing_start_date == null){
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                else{
                    $result .= '<center><span">'.$sysDevAndChangeRequest->testing_end_date.'</span></center>';
                }
                return $result;
            })
            ->addColumn('file', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->file != null){
                    $result .= '<a title="Download" href="download_file/'.$sysDevAndChangeRequest->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$sysDevAndChangeRequest->file.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('action', function($sysDevAndChangeRequest) use($sessionUserLevelId){
                $result = "";
                if($sessionUserLevelId == 1 || $sessionUserLevelId == 2 || $sessionUserLevelId == 48){
                    $result .= '<center>
                                    <button type="button" class="btn btn-primary btn-xs text-center actionEditSystemDevelopment mr-1" type="button" id="' . $sysDevAndChangeRequest->id . '" data-toggle="modal" data-target="#modalAddSystemDevelopment" aria-haspopup="true" aria-expanded="false" title="Edit Details">
                                        <i class="fa fa-lg fa-edit"></i> 
                                    </button>';
                                '</center>';
                    return $result;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                    return $result;
                }
                    
            })
            ->rawColumns(['project_status', 'action', 'testing_start_date', 'testing_end_date', 'file']) // to format columns as html format
            ->make(true);
    }


    public function view_change_request(){
        if(!isset($_SESSION)){
            session_start();
        }
        $sessionDepartmentId = $_SESSION["rapidx_department_id"];
        $sessionUserLevelId = $_SESSION["rapidx_user_level_id"];
        
        if($sessionDepartmentId == 1 || $sessionDepartmentId == 2 || $sessionDepartmentId == 48){
            $sysDevAndChangeRequests = SysDevAndChangeRequestStatus::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
            ->where('is_deleted', 0)->where('request_type', 2)->get();
        }else{
            $sysDevAndChangeRequests = SysDevAndChangeRequestStatus::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
                        ->where('is_deleted', 0)->where('request_type', 2)->where('section_department_requestor', $sessionDepartmentId)->get();
        }
        // return $sysDevAndChangeRequests;
                
        return DataTables::of($sysDevAndChangeRequests)
            ->addColumn('project_status', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->project_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-warning">Pending</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 2){
                    $result .= '<center><span class="badge badge-pill badge-primary">On Going</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 3){
                    $result .= '<center><span class="badge badge-pill badge-success">Completed</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 4){
                    $result .= '<center><span class="badge badge-pill badge-info">Scheduled</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 5){
                    $result .= '<center><span class="badge badge-pill badge-warning">On-hold</span></center>';
                }
                elseif($sysDevAndChangeRequest->project_status == 6){
                    $result .= '<center><span class="badge badge-pill badge-danger">Deferred</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-default">---</span></center>';
                }
                return $result;
            })
            // ->addColumn('request_type', function($sysDevAndChangeRequest){
            //     $result = "";
            //     if($sysDevAndChangeRequest->request_type == 1){
            //         $result .= '<center><span>System Development</span></center>';
            //     }
            //     elseif($sysDevAndChangeRequest->request_type == 2){
            //         $result .= '<center><span">Change Request</span></center>';
            //     }
            //     return $result;
            // })
            ->addColumn('testing_start_date', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->testing_start_date == null){
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                else{
                    $result .= '<center><span">'.$sysDevAndChangeRequest->testing_start_date.'</span></center>';
                }
                return $result;
            })
            ->addColumn('testing_end_date', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->testing_start_date == null){
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                }
                else{
                    $result .= '<center><span">'.$sysDevAndChangeRequest->testing_end_date.'</span></center>';
                }
                return $result;
            })
            ->addColumn('file', function($sysDevAndChangeRequest){
                $result = "";
                if($sysDevAndChangeRequest->file != null){
                    $result .= '<a title="Download" href="download_file/'.$sysDevAndChangeRequest->id.'"><i class="far fa-lg fa-file">&nbsp;</i>'.$sysDevAndChangeRequest->file.'</a>';
                }
                else{
                    $result .= '<span class="badge badge-pill text-xs text-secondary" style="background-color: #E6E6E6">N/A</span>';
                }
                return $result;
            })
            ->addColumn('action', function($sysDevAndChangeRequest) use($sessionUserLevelId){
                $result = "";
                if($sessionUserLevelId == 1 || $sessionUserLevelId == 2 || $sessionUserLevelId == 48){
                    $result .= '<center>
                                    <button type="button" class="btn btn-primary btn-xs text-center actionEditChangeRequest mr-1" type="button" id="' . $sysDevAndChangeRequest->id . '" data-toggle="modal" data-target="#modalAddSystemDevelopment" aria-haspopup="true" aria-expanded="false" title="Edit Details">
                                        <i class="fa fa-lg fa-edit"></i> 
                                    </button>';
                                '</center>';
                    return $result;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">N/A</span></center>';
                    return $result;
                }
                    
            })
            ->rawColumns(['project_status', 'action', 'testing_start_date', 'testing_end_date', 'file']) // to format columns as html format
            ->make(true);
    }


    public function download_file(Request $request, $id){
        $file_id = SysDevAndChangeRequestStatus::where('id', $id)->first();
        $file =  storage_path() . "/app/public/files/" . $file_id->file;
        return Response::download($file, $file_id->file);
    }


    public function get_system_development_by_id(Request $request){
        $sysDevAndChangeRequestData = SysDevAndChangeRequestStatus::where('id', $request->id)->get();
        return response()->json(['sysDevAndChangeRequestData' => $sysDevAndChangeRequestData]);
    }


    public function get_data(){
        $sysDevAndChangeRequestData = SysDevAndChangeRequestStatus::where('is_deleted', 0)
        ->where('project_status', 2)
        ->get();
        return response()->json(['sysDevAndChangeRequestData' => $sysDevAndChangeRequestData]);
    }


    public function send_mail_for_testing(Request $request){
        $sysDevAndChangeRequestDetails = SysDevAndChangeRequestStatus::with('rapidx_requestor', 'rapidx_section_department')
        ->where('id', $request->id)->first();

        $to_email = array();
        $cc_email = array();

        $email_lists = [
            [
                "department_id"=> 1,
                "department_name"=> "ISS Software",
                "department_email"=> ["cbretusto@pricon.ph", "jgsulit@pricon.ph"], // Add as much as ya want
            ],
            [
                "department_id"=> 2,
                "department_name"=> "ISS Hardware",
                "department_email"=> "jnpineda@pricon.ph",
            ],
            [
                "department_id"=> 3,
                "department_name"=> "CN (Prod'n)",
                "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 4,
            "department_name"=> "CN (QC)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 5,
            "department_name"=> "CN (Eng'g)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 6,
            "department_name"=> "PPS (Prod'n)",
            "department_email"=> "group-pps@pricon.ph",
            ],
            [
            "department_id"=> 7,
            "department_name"=> "PPS (QC)",
            "department_email"=> "group-pps@pricon.ph",
            ],
            [
            "department_id"=> 8,
            "department_name"=> "PPS (Eng'g)",
            "department_email"=> "group-pps@pricon.ph",
            ],
            [
            "department_id"=> 9,
            "department_name"=> "YF (Prod'n)",
            "department_email"=> "group-yf@pricon.ph",
            ],
            [
            "department_id"=> 10,
            "department_name"=> "YF (QC)",
            "department_email"=> "group-yf@pricon.ph",
            ],
            [
            "department_id"=> 11,
            "department_name"=> "YF (Eng'g)",
            "department_email"=> "group-yf@pricon.ph",
            ],
            [
            "department_id"=> 12,
            "department_name"=> "TS (Prod'n)",
            "department_email"=> "group-ts@pricon.ph",
            ],
            [
            "department_id"=> 13,
            "department_name"=> "TS (QC)",
            "department_email"=> "group-ts@pricon.ph",
            ],
            [
            "department_id"=> 14,
            "department_name"=> "TS (Eng'g)",
            "department_email"=> "group-ts@pricon.ph",
            ],
            [
            "department_id"=> 15,
            "department_name"=> "CN WHSE",
            "department_email"=> "group-warehouse-cnyf@pricon.ph",
            ],
            [
            "department_id"=> 16,
            "department_name"=> "YF WHSE",
            "department_email"=> "group-warehouse-cnyf@pricon.ph",
            ],
            [
            "department_id"=> 17,
            "department_name"=> "PPS WHSE",
            "department_email"=> "group-pps@pricon.ph",
            ],
            [
            "department_id"=> 18,
            "department_name"=> "TS WHSE",
            "department_email"=> "group-warehouse-ts@pricon.ph",
            ],
            [
            "department_id"=> 19,
            "department_name"=> "Logistics Purchasing",
            "department_email"=> "group-logistics@pricon.ph",
            ],
            [
            "department_id"=> 20,
            "department_name"=> "Logistics Traffic",
            "department_email"=> "group-logistics@pricon.ph",
            ],
            [
            "department_id"=> 21,
            "department_name"=> "QAD DCC",
            "department_email"=> ["group-qad@pricon.ph", "test@pricon.ph"],
            ],
            [
            "department_id"=> 22,
            "department_name"=> "QAD QAS",
            "department_email"=> "group-qad@pricon.ph",
            ],
            [
            "department_id"=> 23,
            "department_name"=> "QAD QMS",
            "department_email"=> "group-qad@pricon.ph",
            ],
            [
            "department_id"=> 24,
            "department_name"=> "PPC",
            "department_email"=> "group-ppc@pricon.ph",
            ],
            [
            "department_id"=> 25,
            "department_name"=> "Finance",
            "department_email"=> "group-finance@pricon.ph",
            ],
            [
            "department_id"=> 26,
            "department_name"=> "EMS",
            "department_email"=> "screlativo@pricon.ph",
            ],
            [
            "department_id"=> 27,
            "department_name"=> "ESS",
            "department_email"=> "group-ess@pricon.ph",
            ],
            [
            "department_id"=> 28,
            "department_name"=> "YEC",
            "department_email"=> "group-yec@pricon.ph",
            ],
            [
            "department_id"=> 29,
            "department_name"=> "HRD",
            "department_email"=> "group-hrd@pricon.ph",
            ],
            [
            "department_id"=> 30,
            "department_name"=> "Facility Section",
            "department_email"=> "group-facility@pricon.ph",
            ],
            [
            "department_id"=> 31,
            "department_name"=> "IAS",
            "department_email"=> "jmmiranda@pricon.ph",
            ],
            [
            "department_id"=> 32,
            "department_name"=> "Board of Directors",
            "department_email"=> "group-bod@pricon.ph",
            ],
            [
            "department_id"=> 33,
            "department_name"=> "PPS TS (Prod'n)",
            "department_email"=> "group-pps-ts@pricon.ph",
            ],
            [
            "department_id"=> 34,
            "department_name"=> "PPS CN (Prod'n)",
            "department_email"=> "group-pps-cn@pricon.ph",
            ],
            [
            "department_id"=> 35,
            "department_name"=> "PPS TS (QC)",
            "department_email"=> "group-pps-ts@pricon.ph",
            ],
            [
            "department_id"=> 36,
            "department_name"=> "PPS CN (QC)",
            "department_email"=> "group-pps-cn@pricon.ph",
            ],
            [
            "department_id"=> 37,
            "department_name"=> "PPS TS (ENG)",
            "department_email"=> "group-pps-ts@pricon.ph",
            ],
            [
            "department_id"=> 38,
            "department_name"=> "PPS CN (ENG)",
            "department_email"=> "group-pps-cn@pricon.ph",
            ],
            [
            "department_id"=> 39,
            "department_name"=> "CN  1 (Prod'n)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 40,
            "department_name"=> "CN  2A (Prod'n)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 41,
            "department_name"=> "CN 2B (Prod'n)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 42,
            "department_name"=> "CN 1 (QC)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 43,
            "department_name"=> "CN 2A (QC)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 44,
            "department_name"=> "CN 2B (QC)",
            "department_email"=> "group-cn@pricon.ph",
            ],
            [
            "department_id"=> 45,
            "department_name"=> "CN 1 (ENG)",
            "department_email"=> "group-cn-engineering@pricon.ph",
            ],
            [
            "department_id"=> 46,
            "department_name"=> "CN 2A (ENG)",
            "department_email"=> "group-cn-engineering@pricon.ph",
            ],
            [
            "department_id"=> 47,
            "department_name"=> "CN 2B (ENG)",
            "department_email"=> "group-cn-engineering@pricon.ph",
            ],
            [
            "department_id"=> 48,
            "department_name"=> "ISS",
            "department_email"=> "group-iss@pricon.ph",
            ],
            [
            "department_id"=> 49,
            "department_name"=> "PPS TS WHS",
            "department_email"=> "group-pps-ts@pricon.ph",
            ],
            [
            "department_id"=> 50,
            "department_name"=> "PPC Warehouse",
            "department_email"=> "group-ppc@pricon.ph",
            ],
            [
            "department_id"=> 51,
            "department_name"=> "CN Packing",
            "department_email"=> null,
            ],
            [
            "department_id"=> 52,
            "department_name"=> "CN Parts Prep",
            "department_email"=> null,
            ],
            [
            "department_id"=> 53,
            "department_name"=> "FAS",
            "department_email"=> null,
            ],
            [
            "department_id"=> 54,
            "department_name"=> "Secretariat",
            "department_email"=> null,
            ]
        ];
        
        $to_email[] = $sysDevAndChangeRequestDetails->rapidx_requestor->email;
        $department_name = '';
        $requestor_name = '';
        $programmer_name = '';
        $sys_dev_and_change_request = [];
        for($i = 0; $i < count($email_lists); $i++){
            if($email_lists[$i]['department_name'] == $sysDevAndChangeRequestDetails->rapidx_section_department->department_name){
                $cc_email[] =  $email_lists[$i]['department_email'];
                $department_name = $sysDevAndChangeRequestDetails->rapidx_section_department->department_name;
                $requestor_name = $sysDevAndChangeRequestDetails->rapidx_requestor->name;
                $programmer_name = $sysDevAndChangeRequestDetails->rapidx_programmer->name;
                $sys_dev_and_change_request[] = $sysDevAndChangeRequestDetails;
            }
        }

        print_r($to_email);
        print_r(array_flatten($cc_email));
        $flatten_cc_email = array_flatten($cc_email);
        $data = array('data' => $sys_dev_and_change_request, 'department_name' => $department_name, 'requestor_name' => $requestor_name, 'programmer_name' => $programmer_name);
        Mail::send('mail.mailer_for_testing', $data, function($message) use ($to_email, $flatten_cc_email){
            $message->to($to_email);
            $message->cc($flatten_cc_email);
            $message->bcc('jdomingo@pricon.ph');
            $message->bcc('jgsulit@pricon.ph');
            $message->subject("System Development and Change Request Status Notification");
        });

        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }
        
    }


    // No use
    public function view_sdcr_status(){
        return RaijinUser::all();
        // $emailRecipients = EmailRecipient::
        //             where('logdel', 0)->get();
                
        // return DataTables::of($emailRecipients)
        //     ->addColumn('email_recipient_status', function($emailRecipient){
        //         $result = "";
        //         if($emailRecipient->email_recipient_status == 1){
        //             $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
        //         }
        //         else{
        //             $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
        //         }
        //         return $result;
        //     })
        //     ->addColumn('action', function($emailRecipient){
        //         if($emailRecipient->email_recipient_status == 1){
        //             $result = '<center><button type="button" class="btn btn-primary btn-xs text-center actionEditEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" data-target="#modalAddEmailRecipient" aria-haspopup="true" aria-expanded="false" title="Edit Claim Details">
        //                             <i class="fa fa-lg fa-edit"></i> 
        //                         </button>';
        //             $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionDeleteEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" status="' . $emailRecipient->email_recipient_status . '" data-target="#modalDeleteEmailRecipient" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
        //                             <i class="fas fa-lg fa-trash-alt"></i>
        //                         </button>';
        //                         '</center>';
        //         }else{
        //             $result = '<center>
        //                             <button type="button" class="btn btn-warning btn-xs text-center actionDeleteEmailRecipient mr-1" type="button" email-recipient-id="' . $emailRecipient->id . '" data-toggle="modal" status="' . $emailRecipient->email_recipient_status . '" data-target="#modalDeleteEmailRecipient" aria-haspopup="true" aria-expanded="false" title="View Claim Details">
        //                                 <i class="fas fa-lg fa-history"></i>
        //                             </button>';
        //                         '</center>';
        //         }

        //         return $result;
        //     })
        //     ->rawColumns(['email_recipient_status', 'action']) // to format columns as html format
        //     ->make(true);
    }
    
}
