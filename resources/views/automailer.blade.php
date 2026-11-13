
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  @include('shared.css_links.css_links')
</head>
<body>
  <div class="container-fluid">
    {{-- <input type="text" name="" id="clock"> --}}
    <div style="margin-top: 8%;">
      <h1 class="display-2 text-center">DO NOT CLOSE</h1>
     
      <hr class="my-4 ">
     
      <p class="text-center">Auto Mail Notification for SDCRS System</p>
      <span id="time"></span>

    </div>
  </div>
 

</body>
<!-- @section('js_content') -->
@include('shared.js_links.js_links')
<script type="text/javascript">


$(document).ready(function () {
    setInterval(myTimer, 1000);

    // checkDateForEmail();
    function myTimer() {

        const d = new Date();

        var current_time = d.toLocaleString("en-US", {
                timeZone: 'Asia/Manila',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
        });

        $("#time").html(current_time);
        
        if(current_time == "10:25:50 AM"){
            checkDateForEmail();
            // monthlyMailerFunction();
        }
    }

    // Auto Email every 7th day of the month
        // function monthlyMailerFunction(){
        //     const date = new Date();
        //     const currentYear = date.getFullYear();
        //     const currentMonth = date.getMonth();
        //     const currentDay = date.getDate();
        //     const seventhDayOfTheMonthInLongFormat = new Date(currentYear, currentMonth, 7);
        //     const seventhDayOfTheMonth = `${(currentMonth+1)}/7/${currentYear}`;
        //     const sixthDayOfTheMonth = `${(currentMonth+1)}/6/${currentYear}`;
        //     const fifthDayOfTheMonth = `${(currentMonth+1)}/5/${currentYear}`;
        //     const fourthDayOfTheMonth = `${(currentMonth+1)}/4/${currentYear}`;
        //     const thirdDayOfTheMonth = `${(currentMonth+1)}/3/${currentYear}`;
        //     const secondDayOfTheMonth = `${(currentMonth+1)}/2/${currentYear}`;
        //     const firstDayOfTheMonth = `${(currentMonth+1)}/1/${currentYear}`;
        //     console.log('currentYear ', currentYear);
        //     console.log('currentMonth ', currentMonth + ' (0 based, thats why I add 1 for the currentMonth)');
        //     console.log('currentDay ', currentDay);
        //     console.log('seventhDayOfTheMonth ', seventhDayOfTheMonth);
        //     console.log('seventhDayOfTheMonthInLongFormat ', seventhDayOfTheMonthInLongFormat);
        //     console.log('-----------------------------------------------------------------------------------------------------');

        //     const dateToday = `${(currentMonth+1)}/${currentDay}/${currentYear}`;
        //     const dateTodayInLongFormat = new Date(currentYear, currentMonth, currentDay);
        //     console.log('dateToday ', dateToday);
        //     console.log('dateTodayInLongFormat ', dateTodayInLongFormat);
            
        //     if(dateToday == seventhDayOfTheMonth ||
        //         dateToday == sixthDayOfTheMonth ||
        //         dateToday == fifthDayOfTheMonth ||
        //         dateToday == fourthDayOfTheMonth ||
        //         dateToday == thirdDayOfTheMonth ||
        //         dateToday == secondDayOfTheMonth ||
        //         dateToday == firstDayOfTheMonth
        //     ){
        //         console.log(`Date today ${dateToday} is equal to ${seventhDayOfTheMonth}`);
        //         console.log(`Date today ${dateToday} is equal to ${firstDayOfTheMonth}`);
        //         sendMonthlyMailerFunction();
        //     }else{
        //         console.log(`Date today ${dateToday} is not equal to ${seventhDayOfTheMonth}`);
        //         console.log(`Date today ${dateToday} is not equal to ${firstDayOfTheMonth}`);
        //     }
        // }

        // function sendMonthlyMailerFunction(){
        //     console.log('sendMonthlyMailerFunction() called');
        //     $.ajax({
        //         url: "sendMonthlyMailer",
        //         method: "get",
        //         dataType: "json",
        //         success: function(response){
        //             if(response['result'] == 1){
        //                 console.log(`sendMonthlyMailerFunction Successful`);
        //             }
        //             else{
        //                 console.log(`sendMonthlyMailerFunction Unsuccessful`);
        //             }
        //         }
        //     });
    // }
    
    function checkDateForEmail(){
        $.ajax({
            url: "get_data",
            method: "get",
            dataType: "json",
            success: function(response){
                const date = new Date();
                const currentYear = date.getFullYear();
                const currentMonth = date.getMonth();
                const currentDay = date.getDate();
                // const dateTodayInLongFormat = new Date(currentYear, currentMonth, currentDay);
                // console.log('dateTodayInLongFormat ', dateTodayInLongFormat);
                // const dateToday = `${currentYear}-0${(currentMonth+1).slice(-2)}-${currentDay}`;
                const dateToday = currentYear + '-'
                                + ('0' + (currentMonth+1)).slice(-2) + '-'
                                + ('0' + currentDay).slice(-2);
                console.log(`currentMonth is ${currentMonth}, 0 based, thats why I add 1 for the currentMonth to make it ${currentMonth+1}`);
                console.log(`currentDay ${currentDay}`);
                console.log('dateToday ', dateToday);

                let sysDevAndChangeRequestData = response['sysDevAndChangeRequestData'];
                for(let i = 0; i < sysDevAndChangeRequestData.length; i++){
                    testingStartDate = sysDevAndChangeRequestData[i]['testing_start_date'];
                    if(dateToday == testingStartDate){
                        console.log('----');
                        console.log(sysDevAndChangeRequestData[i]['project_name']);
                        console.log(`testingStartDate ${testingStartDate} and dateToday ${dateToday} is equal`);
                        sendMailForTesting(sysDevAndChangeRequestData[i]['id']);
                    }
                }
            }
        });
    }

    function sendMailForTesting(id){
        console.log(`sendMailForTesting() called`);
        $.ajax({
            url: "send_mail_for_testing",
            method: "get",
            data: {
                id : id,
            },
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log(`sendMailForTesting for database id ${id} Successful`);
                }
                else{
                    console.log(`sendMailForTesting for database id ${id} Failed`);
                }
            }
        });
    }
});
</script>
</html>

