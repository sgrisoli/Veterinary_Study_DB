<html>
<head>
    <title>Add Hours Confirmation></title>
    <a href="../index.php">Back To Home</a>
</head>

<body>
    <?php
        //Retrieving Variables
        $date = $_POST["start_date"];
        $start_time = $_POST["start_time"];
        $end_time = $_POST["end_time"];
        $location = $_POST["location"];
        $vet = $_POST["vet"];
        $type = $_POST["type"];


        //Escaping strings
        $location = SQLite3::escapeString($location);
        $vet = SQLite3::escapeString($vet);
        $type = SQLite3::escapeString($type);

        //Setting date to seconds since epoch
        $date_as_str = strtotime($date);

        //Calculating duration
        $duration = (strtotime($end_time) - strtotime($start_time));
        
        echo $duration;


        //Connecting to database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");
        //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        //Insert statement for new hours
        $stm = $db->prepare('INSERT into hours VALUES (?,?,?,?,?,?,?)');
        $stm->bindParam(1,$date_as_str);
        $stm->bindParam(2,$location);
        $stm->bindParam(3,$vet);
        $stm->bindParam(4,$type);
        $stm->bindParam(5,$start_time);
        $stm->bindParam(6,$end_time);
        $stm->bindParam(7,$duration);

        $stm->execute();

        $select_query = "SELECT * FROM hours where date = $date_as_str";
        $res = $db->query($select_query);
        
        //Returning new entry
        echo "<table>";
            echo "<tr>";
                echo "<th>Date</th>";
                echo "<th>Location</th>";
                echo "<th>Primary Vet</th>";
                echo "<th>Type</th>";
                echo "<th>Begin Time</th>";
                echo "<th>End Time</th>";
                echo "<th>Duration</th>";

        while($row = $res->fetchArray()){
            echo "<tr>";
                for($i=0; $i<7; $i++){
                    echo "<td>" . $row[$i] . "</td>";
                }
            echo "</tr>";
            }
        echo "</table>";
        

      //USE THIS FOR DATE HTML  echo date('M/d/Y', $date_as_str);
        

    $hours = floor($duration / 3600);
    $minutes = floor(($duration / 60) % 60);
    echo "$hours:$minutes";
    ?>

</body>
</html>