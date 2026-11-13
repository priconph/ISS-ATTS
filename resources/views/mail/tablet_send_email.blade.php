<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style type="text/css">
            body{
                font-family: Arial;
                font-size: 15px;
            }

            .text-green{
                color: green;
                font-weight: bold;
            }

            /*.input[type="radio"]{
                font
            }*/
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-12">
                <div class="row" style="margin: 1px 10px;">
                    <div class="col-sm-12">
                        <form id="frmSaveRecord">
                            <div class="row">
                                @if($list[0]->approval_status == 1)
                                    <div class="col-sm-12">
                                        <label style="font-size: 18px;">Magandang Buhay!</label><br>
                                        <label style="font-size: 18px;">Nais naming ipaalam na may aaprubahan si Ginoo/Binibini: {{ $list[0]->approved_by }} ngayong {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                        <br><br>
                                        <hr>
                                    </div>
                                @elseif($list[0]->approval_status == 2)
                                    <div class="col-sm-12">
                                        <label style="font-size: 18px;">Magandang Buhay!</label><br>
                                        <label style="font-size: 18px;">Nais naming ipaalam na naaprubahan na ni Ginoo/Binibini: {{ $list[0]->approved_by }} ngayong {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                        <br><br>
                                        <hr>
                                    </div>
                                @elseif($list[0]->approval_status == 3)
                                    <div class="col-sm-12">
                                        <label style="font-size: 18px;">Magandang Buhay!</label><br>
                                        <label style="font-size: 18px;">Nais naming ipaalam na hindi inaprubahan ni Ginoo/Binibini: {{ $list[0]->approved_by }} ngayong {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                        <br><br>
                                        <hr>
                                    </div>
                                @endif

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><h3>ISS Asset Tag Traceability System </h3></label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Asset Tag: </b><span class="text-black">{{ $list[0]->asset_tag }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Serial Number: </b><span class="text-black">{{ $list[0]->serial_number }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Brand: </b><span class="text-black">{{ $list[0]->brand }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Model: </b><span class="text-black">{{ $list[0]->model }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Capacity(in GB): </b><span class="text-black">{{ $list[0]->capacity }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Department: </b><span class="text-black">{{ $list[0]->department }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Section: </b><span class="text-black">{{ $list[0]->section }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Assigned User: </b><span class="text-black">{{ $list[0]->assigned_user }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Disposition: </b><span class="text-black">{{ $list[0]->disposition }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Date of Disposal: </b><span class="text-black">{{ $list[0]->date_of_disposal }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Date of Purchase: </b><span class="text-black">{{ $list[0]->date_of_purchase }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Remarks 1: </b><span class="text-black">{{ $list[0]->remarks_1 }} </span></label>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b>Remarks 2: </b><span class="text-black">{{ $list[0]->remarks_2 }} </span></label>
                                    </div>

                                <br>
                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">For more info, please log-in to your Rapidx account. Go to http://rapidx/iss_atts </label>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b> Notice of Disclaimer: </b></label>
                                        <br>
                                        <label class="col-sm-12 col-form-label"></label>   This message contains confidential information intended for a specific individual and purpose. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.</label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br><br>
                                    <label style="font-size: 18px;"><b>For concerns on using the form, please contact ISS at local numbers 205, 206, or 208. You may send us e-mail at <a href="mailto: servicerequest@pricon.ph">servicerequest@pricon.ph</a></b></label>
                                </div>
                            </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </body>
</html>