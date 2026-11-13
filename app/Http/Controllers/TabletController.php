<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RapidXUser;
use App\RaijinUser;
use App\Tablet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use DataTables;
use Mail;

class TabletController extends Controller
{
    public function view_tablet(){
        if(!isset($_SESSION)){
            session_start();
        }
        $sessionDepartmentId = $_SESSION["rapidx_department_id"];
        $sessionUserLevelId = $_SESSION["rapidx_user_level_id"];
        $sessionRapidxName = $_SESSION["rapidx_name"];
        
        $approver = Tablet::with(['rapidx_requestor'])->where('approved_by', $sessionRapidxName)->get();
        // return $approver;

        if($sessionDepartmentId == 1 || $sessionDepartmentId == 2 || $sessionDepartmentId == 48){
            $tabletDetails = Tablet::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
            ->where('is_deleted', 0)
            ->orderBy('is_checked', 'DESC')
            ->get();
        }else{
            $sysDevAndChangeRequests = Tablet::with('rapidx_programmer', 'rapidx_requestor', 'rapidx_section_department')
            ->where('is_deleted', 0)->where('section', $sessionDepartmentId)->get();
        }
        // return $tabletDetails;
                
        return DataTables::of($tabletDetails)
            ->addColumn('tablet_status', function($row){
                $result = "";
                if($row->tablet_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Deployed</span></center>';
                }
                elseif($row->tablet_status == 2){
                    $result .= '<center><span class="badge badge-pill badge-info">Disposed</span></center>';
                }
                elseif($row->tablet_status == 3){
                    $result .= '<center><span class="badge badge-pill badge-info">For Disposal</span></center>';
                }
                elseif($row->tablet_status == 4){
                    $result .= '<center><span class="badge badge-pill badge-primary">Decomissioned</span></center>';
                }
                elseif($row->tablet_status == 5){
                    $result .= '<center><span class="badge badge-pill badge-danger">Missing</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-default">---</span></center>';
                }
                return $result;
            })
            ->addColumn('approval_status', function($row){
                $result = "";
                if($row->approval_status == 0){
                    $result .= '<center>----</center>';
                }
                elseif($row->approval_status == 1){
                    $result .= '<center><span class="badge badge-pill badge-warning">For approval</span></center>';
                }
                elseif($row->approval_status == 2){
                    $result .= '<center><span class="badge badge-pill badge-success">Approved</span></center>';
                }
                elseif($row->approval_status == 3){
                    $result .= '<center><span class="badge badge-pill badge-danger">Disaprroved</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-default">---</span></center>';
                }
                return $result;
            })
            ->addColumn('disposition', function($row){
                $result = "";
                if($row->tablet_status == 1){
                    $result .= '<center><span>Deployed</span></center>';
                }
                elseif($row->tablet_status == 2){
                    $result .= '<center><span>Disposed</span></center>';
                }
                elseif($row->tablet_status == 3){
                    $result .= '<center><span>For Disposal</span></center>';
                }
                elseif($row->tablet_status == 4){
                    $result .= '<center><span>Decomissioned</span></center>';
                }
                elseif($row->tablet_status == 5){
                    $result .= '<center><span>Missing</span></center>';
                }
                else{
                    $result .= '<center><span>---</span></center>';
                }
                return $result;
            })
            // ->addColumn('department', function($row){
            //     $result = "";

            //     if($row->department == 1){
            //         $result .= '<center><span>Administration</span></center>';
            //     }
            //     elseif($row->department == 2){
            //         $result .= '<center><span>Production</span></center>';
            //     }
            //     elseif($row->department == 3){
            //         $result .= '<center><span>QAD</span></center>';
            //     }
            //     elseif($row->department == 4){
            //         $result .= '<center><span>CN</span></center>';
            //     }
            //     elseif($row->department == 5){
            //         $result .= '<center><span>TS</span></center>';
            //     }
            //     elseif($row->department == 6){
            //         $result .= '<center><span>PPS</span></center>';
            //     }
            //     elseif($row->department == 7){
            //         $result .= '<center><span>YF</span></center>';
            //     }
            //     elseif($row->department == 8){
            //         $result .= '<center><span>PPC</span></center>';
            //     }
            //     elseif($row->department == 9){
            //         $result .= '<center><span>Logistics</span></center>';
            //     }
            //     else{
            //         $result .= '<center><span class="badge badge-pill badge-default">---</span></center>';
            //     }
            //     return $result;
            // })

            ->addColumn('action', function($row) use($sessionUserLevelId, $approver, $sessionRapidxName){
                $result = "";
                if(count($approver) != 0){
                    // if($approver[0]->approved_by == $sessionRapidxName){
                        if($row->approval_status == 1 && $row->approved_by == $sessionRapidxName && $row->approved_by != null){
                            $result .='<center>';
                            $result .= '<button type="button" class="btn btn-success btn-xs text-center actionEditTablet actionTabletApprovedDisapproved mr-1" type="button" id="' . $row->id . '" status="2" data-toggle="modal" data-target="#modalTabletApprovedDisapproved" aria-haspopup="true" aria-expanded="false" title="Approved">
                                            <i class="fa fa-lg fa-thumbs-up"></i>                             
                                        </button>';
                            $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionEditTablet actionTabletApprovedDisapproved mr-1" type="button" id="' . $row->id . '" status="3" data-toggle="modal" data-target="#modalTabletApprovedDisapproved" aria-haspopup="true" aria-expanded="false" title="Disapproved">
                                            <i class="fa fa-lg fa-thumbs-down"></i>                             
                                        </button>';
                            // $result .= '<button type="button" class="btn btn-danger btn-xs text-center actionTabletDisapproved" type="button" id="' . $row->id . '" status="2" data-toggle="modal" data-target="#modalTabletDisapproved" aria-haspopup="true" aria-expanded="false" title="Disapproved">
                            //                 <i class="fa fa-lg fa-thumbs-down"></i>                             
                            //             </button>';
                            $result .='</center>';
                            return $result;
                        // }
                    }
                    else{
                        
                    }
                }
                

                if($sessionUserLevelId == 1 || $sessionUserLevelId == 2 || $sessionUserLevelId == 48){
                    $result .= '<center>
                                    <button type="button" class="btn btn-primary btn-xs text-center actionEditTablet mr-1" type="button" id="' . $row->id . '" data-toggle="modal" data-target="#modalAddTablet" aria-haspopup="true" aria-expanded="false" title="Edit Details">
                                        <i class="fa fa-lg fa-edit"></i> 
                                    </button>';
                                '</center>';
                    if($row->is_checked == 1 && $row->approved_by == null){
                        $result .= '<button type="button" class="btn btn-dark btn-xs text-center actionTabletSelectApprover mr-1" type="button" id="' . $row->id . '" data-toggle="modal" data-target="#modalTabletSelectApprover" aria-haspopup="true" aria-expanded="false" title="Select Approver">
                                        <i class="fa fa-lg fa-thumbs-up"></i>                             
                                    </button>';
                    }
                    return $result;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary"></span></center>';
                    return $result;
                }
                return $result;
            })

            ->rawColumns(['tablet_status', 'action', 'approval_status', 'disposition', 'department']) // to format columns as html format
            ->make(true);
    }

    public function add_tablet(Request $request){
        date_default_timezone_set('Asia/Manila');
        if(!isset($_SESSION)){
            session_start();
        }

        $data = $request->all();
        if(!isset($request->id_for_edit)){ // For Insert
            $rules = [
                'asset_tag'             => 'required',
                'serial_number'         => 'required',
                'brand'                 => 'required',
                'model'                 => 'required',
                'capacity'              => 'required',
                'department'            => 'required',
                'section'               => 'required',
                'assigned_user'         => 'required',
                'disposition'           => 'required',
                'date_of_disposal'      => 'required',
                'date_of_purchase'      => 'required',
            ];
    
            $validator = Validator::make($data, $rules);
            if($validator->passes()){
                $insert_array = [
                    'tablet_status'              =>  $request->disposition,
                    'asset_tag'                =>  $request->asset_tag,
                    'serial_number'                  =>  $request->serial_number,
                    'brand'                     =>  $request->brand,
                    'model'                 =>  $request->model,
                    'capacity'                  =>  $request->capacity,
                    'department'           =>  $request->department,
                    'section'             =>  $request->section ,
                    'assigned_user'            =>  $request->assigned_user,
                    'disposition'              =>  $request->disposition,
                    'date_of_disposal'               =>  $request->date_of_disposal,
                    'date_of_purchase'                =>  $request->date_of_purchase,
                    'remarks_1'                    =>  $request->remarks_1,
                    'remarks_2'                       =>  $request->remarks_2,
                    'created_by'                    =>  $_SESSION["rapidx_user_id"],
                    'created_at'                    =>  date('Y-m-d H:i:s')
                ];

                Tablet::insert(
                    $insert_array
                );
                return response()->json(['result' => "1"]);
            }else{
                return response()->json(['validationHasError' => "1", 'error' => $validator->messages()]);
            }
        }else{
            $rules = [
                'id_for_edit'           => 'required',
                'asset_tag'             => 'required',
                'serial_number'         => 'required',
                'brand'                 => 'required',
                'model'                 => 'required',
                'capacity'              => 'required',
                'department'            => 'required',
                'section'               => 'required',
                'assigned_user'         => 'required',
                'disposition'           => 'required',
                'date_of_disposal'      => 'required',
                'date_of_purchase'      => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->passes()){
                $update_details = [
                    'tablet_status'              =>  $request->disposition,
                    'asset_tag'                =>  $request->asset_tag,
                    'serial_number'                  =>  $request->serial_number,
                    'brand'                     =>  $request->brand,
                    'model'                 =>  $request->model,
                    'capacity'                  =>  $request->capacity,
                    'department'           =>  $request->department,
                    'section'             =>  $request->section ,
                    'assigned_user'            =>  $request->assigned_user,
                    'disposition'              =>  $request->disposition,
                    'date_of_disposal'               =>  $request->date_of_disposal,
                    'date_of_purchase'                =>  $request->date_of_purchase,
                    'remarks_1'                    =>  $request->remarks_1,
                    'remarks_2'                       =>  $request->remarks_2,
                    // 'created_by'                    =>  $_SESSION["rapidx_user_id"],
                    'updated_at'                    =>  date('Y-m-d H:i:s')
                ];


                if(isset($request->id_for_edit)){               
                    Tablet::where('id', $request->id_for_edit)->update(
                        $update_details
                    );
                    return response()->json(['result' => "1"]);
                }
            }else{
                return response()->json(['validationHasError' => "1", 'error' => $validator->messages()]);
            }
        }
    }

    public function get_tablet_by_id(Request $request){
        $tabletDetails = Tablet::where('id', $request->id)->get();
        return response()->json(['tabletDetails' => $tabletDetails]);
    }

    //============================== SELECT APPROVER ==============================
    public function tablet_select_approver(Request $request){
        date_default_timezone_set('Asia/Manila');
        if(!isset($_SESSION)){
            session_start();
        }

        $data = $request->all();
        $rules = [
            'id_for_edit'                   => 'required',
            'tablet_select_approver'        => 'required',
            'tablet_select_supervisor'      => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            $insert_array = [
                'approved_by'       =>  $request->tablet_select_approver,
                'supervisor_user'   =>  $request->tablet_select_supervisor,
                'approval_status'   =>  1,
                'created_at'        =>  date('Y-m-d H:i:s')
            ];
            
            Tablet::where('id', $request->id_for_edit)->update(
                $insert_array
            );
            $records = Tablet::where('id', $request->id_for_edit)->get();
            $send_email_to_approved = $request->tablet_select_approver;
            $send_email_to_supervisor = $request->tablet_select_supervisor;
            $get_data = ['list' => $records];
            $to_approved_by = RapidXUser::where('name', $send_email_to_approved)->get('email');
            $to_supervisor = RapidXUser::where('name', $send_email_to_supervisor)->get('email');
            // return $get_data;
            if($to_approved_by[0]->email != null){
                Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_approved_by, $to_supervisor){
                    $message->to($to_approved_by[0]->email)->cc($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('For Approval in ISS Asset Tag Traceability System');
                });

                // return $to_approved_by;
            }else{
                Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_supervisor){
                    $message->to($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('For Approval in ISS Asset Tag Traceability System');
                });
            //     // return 'NO';
            }
            // return $to_approved_by[0]->email;

            return response()->json(['result' => "1"]);
        }else{
            return response()->json(['validationHasError' => "1", 'error' => $validator->messages()]);
        }
    }

    //============================== APPROVED DISAPPROVED==============================
    public function tablet_approved_disapproved(Request $request){        
        date_default_timezone_set('Asia/Manila');

            $data = $request->all(); // collect all input fields
    
            $validator = Validator::make($data, [
                'id_for_edit'   => 'required',
                'status'        => 'required',
            ]);
    
            $arr_disapproved = [
                'status' => $request->status,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
    
            if($validator->passes()){
                $insert_array = [
                    'approval_status' => $request->status,
                    'approval_remarks'  => $request->approved_remarks,
                    'approved_date'     => NOW(),
                ];
                
                Tablet::where('id', $request->id_for_edit)->update(
                    $insert_array
                );

                $records = Tablet::where('id', $request->id_for_edit)->get();
                $send_email_to_approved = $records[0]->approved_by;
                $send_email_to_supervisor =  $records[0]->supervisor_user;
                $to_approved_by = RapidXUser::where('name', $send_email_to_approved)->get('email');
                $to_supervisor = RapidXUser::where('name', $send_email_to_supervisor)->get('email');
                $get_data = ['list' => $records];

                // return $records[0]->approval_status;
                if($records[0]->approval_status == 2){
                    if($to_approved_by[0]->email != null){
                        Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_approved_by, $to_supervisor){
                            $message->to($to_approved_by[0]->email)->cc($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('Approved ISS Asset Tag Traceability System');
                        });        
                    }else{
                        Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_supervisor){
                            $message->to($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('Approved ISS Asset Tag Traceability System');
                        });
                    }
                }elseif($records[0]->approval_status == 3){
                    if($to_approved_by[0]->email != null){
                        Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_approved_by, $to_supervisor){
                            $message->to($to_approved_by[0]->email)->cc($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('Disapproved ISS Asset Tag Traceability System');
                        });        
                    }else{
                        Mail::send('mail.tablet_send_email', $get_data, function($message) use($to_supervisor){
                            $message->to($to_supervisor[0]->email)->bcc('jedelosreyes@pricon.ph')->bcc('abantonio@pricon.ph')->subject('Disapproved ISS Asset Tag Traceability System');
                        });
                    }

                }

                return response()->json(['result' => "1"]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
    }
}

