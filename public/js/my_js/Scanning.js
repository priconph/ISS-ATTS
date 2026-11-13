function verifyData(scannedData){
    $.ajax({
        type: "get",
        url: "scanning_check_data",
        data: {
            'scan_data' : scannedData,
        },
        dataType: "json",
        success: function (response) {
            console.log(response);

            if(response['result'] == 0){
                toastr.error(response['message']);
            }
            else if(response['result'] == 2){
                toastr.error(response['message']);
            }
            else{
                toastr.success('Data Scanned');
                $('#modalQRChecking').modal('hide');
                dataTablesTablet.draw();
            }
        }
    });
    // $('#tableTablet tbody tr').each(function(index, tr){
    //     // var assetTag = $(tr).find('td:eq(3)').text().toUpperCase();
    //     // console.log(assetTag);
    // });
}