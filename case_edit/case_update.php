<?php  
    //Recieving the field from the next page
    session_start();
    $field = $_SESSION['field'];
    $case_num = $_SESSION['case_num'];
    $updated_field = $_POST['new_entry'];

    //$field = SQLite3::escapeString($field);
    $updated_field = SQLite3::escapeString($updated_field);
?>

<html>
<head>
<title>Update Case</title>
<a href="../index.php">Back To Home</a>
<link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
<?php
    //Database connection
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    
    //Update query and exeuction
    $sql = "UPDATE cases SET '$field' = '$updated_field' WHERE case_num = $case_num";
    $res = $db->query($sql);
    if($res){
        echo "<p>Successfully updated case number: " . $case_num . "<p>";
    } else {
        echo "Was not able to update database";
    }
   
    //Select query and execution
    $select_query = "SELECT * FROM cases WHERE case_num = $case_num";
    $res = $db->query($select_query);
        
    //Returning new entry
    echo "<form action='../view_case.php' method='POST'>";
        echo "<table>";
            echo "<tr>";
                echo "<th></th>";
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
            echo "<td><button type='submit' value='" . $case_num . "' name='btn'>View</button></td>";
                for($i=0; $i<12; $i++){
                    echo "<td>" . $row[$i] . "</td>";
                }
            echo "</tr>";
            }
        echo "</table>";
    echo "</form>";
?>

</body>

</html>