<?php
    session_start();
    $date = $_POST['start_date'];
    $field = $_POST['update_select'];

    $_SESSION['orig_date'] = $date;
    $_SESSION['field'] = $field;
    echo $date . $field;

    $date_as_str = strtotime($date);
?>

<html>
<head>
    <title>Edit Hours</title>
</head>


<body>
    <p>You are editing the <b><?= $field?></b> of date: <b><?= $date?></b></p>

    <?php
        //Connecting to database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");
        //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        //SQL statement to find what the previous entry was
        $sql = "SELECT $field FROM hours WHERE date = $date_as_str";

        //Saving previous entry to variable
        $res = $db->query($sql);
        if($field == "date"){
            while($row = $res->fetchArray()){
                $previous_entry = $row[0];
                $previous_entry = date('m/d/Y', $previous_entry);
            }     
        } else{    
            while($row = $res->fetchArray()){
                $previous_entry = $row[0];
            }
        }
        
        
        //Form for updating previous entry
        echo "<form action='hours_update.php' method='POST' id=\"update_form\">";
        if(is_string($previous_entry)){
            echo "<p><textarea rows=\"8\" cols=\"50\" name=\"new_entry\">$previous_entry</textarea>";
        } elseif(is_numeric($previous_entry)){
            echo "<p><input name=\"new_entry\" type='number' value=$previous_entry></input></p>";
        }
        echo "<p><button id='update_button' type='submit' value='submit'>Update Field</button></p>";
        echo "</form>";

    ?>


</body>

</html>