<?php
    session_start();

    echo "<a href=\"../index.php\">Back To Home</a>";
    //Getting username
    $user = $_SESSION['uname'];

    //Getting drug info from form
    $name = $_POST['name'];
    $type = $_POST['type'];
    $brand_name = $_POST['brand_name'];
    $method = $_POST['method'];
    $use = $_POST['use'];
    $side_effects = $_POST['side_effects'];
    $interactions = $_POST['interactions'];
    $mechanism = $_POST['mechanism'];
    $dosing = $_POST['dosing'];

    //Replacing endline characters
    $use = str_replace("\n", '', $use);
    $side_effects = str_replace("\n", '', $side_effects);
    $interactions = str_replace("\n", '', $interactions);
    $mechanism = str_replace("\n", '', $mechanism);
    $dosing = str_replace("\n", '', $dosing);

    //Connecting to database
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");

    //Insert statement for new case
    $stm = $db->prepare('INSERT into drugs VALUES (?,?,?,?,?,?,?,?,?,?)');
    $stm->bindParam(1,$name);
    $stm->bindParam(2,$type);
    $stm->bindParam(3,$brand_name);
    $stm->bindParam(5,$use);
    $stm->bindParam(4,$method);
    $stm->bindParam(6,$side_effects);
    $stm->bindParam(7,$interactions);
    $stm->bindParam(8,$mechanism);
    $stm->bindParam(9,$dosing);
    $stm->bindParam(10,$user);

    $stm->execute();
    
    $select_query = "SELECT * FROM drugs where name = '$name'";
    $res = $db->query($select_query);
    
    //Returning new entry
    echo "<p>Successfully added drug: " . $name . "<p>";
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

        while($row = $res->fetchArray()){
            echo "<tr>";
                echo "<td><button type='submit' value='" . $name . "' name='btn'>View</button></td>";
                for($i=0; $i<9; $i++){
                    echo "<td>" . $row[$i] . "</td>";
                }
            echo "</tr>";
            }
        echo "</table>";
    echo "</form>";
    
    session_destroy();
?>

<html>
<head>
    <title>New Drug Confirmation</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>


</body>


</html>
