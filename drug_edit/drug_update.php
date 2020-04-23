<?php  
    //Recieving the field from the next page
    session_start();
    $field = $_SESSION['field'];
    $name = $_SESSION['name'];
    $updated_field = $_POST['new_entry'];

    //$field = SQLite3::escapeString($field);
    $updated_field = SQLite3::escapeString($updated_field);
?>

<html>
<head>
<title>Update Drug</title>
<a href="../index.php">Back To Home</a>
<link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
<?php
    //Database connection
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    
    //Update query and exeuction
    $sql = "UPDATE drugs SET '$field' = '$updated_field' WHERE name = '$name' COLLATE NOCASE";
    $res = $db->query($sql);
    if($res){
        echo "<p>Successfully updated drug: " . $name . "<p>";
        echo "<b>Updated Info</b>";
    } else {
        echo "Was not able to update database";
    }
   
    //Select query and execution
    $select_query = "SELECT * FROM drugs WHERE name = '$name' COLLATE NOCASE";
    $result = $db->query($select_query);
        
    //Returning new entry
    echo "<form action='../view_drug.php' method='POST'>";
        echo "<table>";
            echo "<tr>";
                echo "<th></th>";
                echo "<th>Name</th>";
                echo "<th>Type</th>";
                echo "<th>Brand Names</th>";
                echo "<th>Uses</th>";
                echo "<th>Route</th>";
                echo "<th>Side Effects</th>";
                echo "<th>Interactions</th>";
                echo "<th>Mechanism</th>";
                echo "<th>Dosing</th>";
            echo "</tr>";
        while($row = $result->fetchArray()){
            echo "<tr>";
                echo "<td><button type='submit' value='" . $name . "' name='btn'>View</button></td>";
                for($i=0; $i<9; $i++){
                    echo "<td>" . $row[$i] . "</td>";
                }
            echo "</tr>";
            }
        echo "</table>";
    echo "</form>";
?>

</body>

</html>