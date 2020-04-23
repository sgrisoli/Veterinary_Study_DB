<html>
<head>
<title>Add Hours</title>
<a href="../index.php">Back To Home</a>

</head>

<body>
    <form action="add_hours.php" method="POST" id='add_hours_form'>
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
        <label for="start_date">Date</label>
        <div class="input-group-addon" id="calendar1">
            <i class="fa fa-calendar"></i>
        </div>
            <input type="text" name="start_date" id="start_date" class="form-control start_date" data-inputmask="'alias':'mm/dd/yyyy'" data-mask="" value="">
        </div>
        </div>
        </div>
        </div>

            <p>
            <label for="start_time">Start Time</label>
            <input id="start_time" type="time" name="start_time" value="12:00">
            </p>

            <p>
            <label for="end_time">End Time</label>
            <input id="end_time" type="time" name="end_time" value="12:00">
            </p>

            <p>
            <label for="location">Location</label>
            <input id="location" type="text" name="location" value="SJC Humane Society">
            </p>

            <p>
            <label for="vet">Primary Vet</label>
            <input id="vet" type="text" name="vet" value="Dr. Lindsay Fredricks">
            </p>

            <p>
            <label for="type">Type</label>
            <input id="type" type="text" name="type" value="clinical work">
            </p>

        <button id='add_hours_button' type='submit' value='submit'>Submit</button>
    </form>

</body>

<script>

    $(document).ready(function() {
        $('#calendar1').click(function(event) {
            $('.start_date').datepicker('show');
        });
    });

</script>
</html>
