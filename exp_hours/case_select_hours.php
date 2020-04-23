<?php
    //DB connection
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    //Query to get all usernames and passwords for comparison
    $res = $db->query('SELECT date FROM hours');

    $data = array();
    while($row = $res->fetchArray()){
        $data[] = $row;
    }

    //Resaving all usernames as simple array
    $arr_to_send = array();
    for($i=0; $i<count($data); $i++){
        $arr_to_send[] = $data[$i][0];
    }

?>

<html>
<head>
    <title>Select Hours</title>
</head>

<body>

<form action="edit_hours.php" method="POST" id='edit_hours_form'>
    <!-- Calender Popup -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="container">
    <div class="row">
    <div class="col-md-3">
    <div class="input-group">
    <label for="start_date">Date to edit</label>
    <div class="input-group-addon" id="calendar1">
        <i class="fa fa-calendar"></i>
    </div>
        <input type="text" name="start_date" id="start_date" class="form-control start_date" data-inputmask="'alias':'mm/dd/yyyy'" data-mask="" value="" onchange=check_date()>
    </div>
    </div>
    </div>
    </div>

    <p id=tester></p>
    <p id=testers></p>

    <p>Field to Modify:</p>
            <select name='update_select' id='update_select'>
                <option value=date>Date</option>
                <option value=begin_time>Start Time</option>
                <option value=end_time>End Time</option>
                <option value=location>Location</option>
                <option value=pri_vet>Primary Vet</option>
                <option value=type>Type</option>
            </select>
    <button id='update_button' type='submit' value='submit'>Submit</button>
    
</form>


</body>

<script>

    $(document).ready(function() {
        $('#calendar1').click(function(event) {
            $('.start_date').datepicker('show');
        });
    });

    function check_date(){
        //Recieve array from php
        var passed_array = <?php echo json_encode($arr_to_send); ?>;

        //Get user input for date
        var current_date = document.getElementById("start_date").value;
        var curr_date_as_str = (Date.parse(current_date) / 1000) - 18000;


        for(var i=0; i<passed_array.length; i++){
            if(passed_array[i]==curr_date_as_str){
                document.getElementById("tester").innerHTML = "";
                document.getElementById("update_button").style.display='inline-block';
                break;
            } else{
                document.getElementById("tester").innerHTML = "No data entered on this date (use add hours)";
                document.getElementById("update_button").style.display='none';
            }
        }
    }
</script>

</html>

