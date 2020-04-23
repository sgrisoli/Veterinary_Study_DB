<?php  
    //Recieving the field from the next page
    session_start();
    $field = $_SESSION['field'];
    $orig_date = $_SESSION['orig_date'];
    $new_entry = $_POST['new_entry'];
    
    //Database connection
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    
    //Update query and exeuction CURRENTLY WORKING ON THIS SECTION
    if($field = 'date'){
        $date_as_str = strtotime($new_entry);
        $sql = "UPDATE  hours set date = $date_as_str WHERE date = $orig_date";
        $res = $db->query($sql);
        if($res){
            echo "<p>Successfully updated case number: " . $case_num . "<p>";
        } else {
            echo "Was not able to update database";
        }
    } else{
        $sql = "UPDATE  hours set '$field' = '$new_entry' WHERE date = $orig_date";
        $res = $db->query($sql);
        if($res){
            echo "<p>Successfully updated case number: " . $case_num . "<p>";
        } else {
            echo "Was not able to update database";
        }
    }

    
?>

<!--
<html>
<head>
<title>Update Hours</title>
<a href="../index.php">Back To Home</a>
</head>

<body>
<?php
/*
    //Database connection
    $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    
    //Update query and exeuction
    $sql = "UPDATE  SET '$field' = '$updated_field' WHERE case_num = $case_num";
    $res = $db->query($sql);
    if($res){
        echo "<p>Successfully updated case number: " . $case_num . "<p>";
    } else {
        echo "Was not able to update database";
    }
   
    //Select query and execution
    $select_query = "SELECT * FROM hours WHERE case_num = $case_num";
    $res = $db->query($select_query);
        
    //Returning new entry
    echo "<table>";
        echo "<tr>";
            echo "<th>Case Number</th>";
            echo "<th>Name</th>";
            echo "<th>Species</th>";
            echo "<th>Breed</th>";
            echo "<th>Sex</th>";
            echo "<th>Age</th>";
            echo "<th>Weight</th>";
            echo "<th>Chip Number</th>";
            echo "<th>Symptoms</th>";
            echo "<th>Diagnosis</th>";
            echo "<th>Treatment</th>";
            echo "<th>Drugs Used</th>";

    while($row = $res->fetchArray()){
        echo "<tr>";
            for($i=0; $i<12; $i++){
                echo "<td>" . $row[$i] . "</td>";
            }
        echo "</tr>";
        }
    echo "</table>";
    */
?>

</body>

</html>
-->