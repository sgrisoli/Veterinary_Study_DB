<html>
<head>
    <title>View Hours</title>
    <a href="../index.php">Back To Home</a>
</head>

<body>
<?php
    //SQL for total overall hours
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    $sql = "SELECT SUM(duration) from hours";
    $res = $db->query($sql);

    while($row = $res->fetchArray()){
        $hours = floor($row[0] / 3600);
        $minutes = floor(($row[0] / 60) % 60);
        echo "<p>Total Hours: " . $hours .":". $minutes . "</p>";
    }
?>

<?php
    //Hours by location
    $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    $sql = "SELECT DISTINCT location, SUM(duration) FROM hours GROUP BY location";
    $res = $db->query($sql);

    echo "<table>";
    while($row = $res->fetchArray()){
        $hours = floor($row[1] / 3600);
        $minutes = floor(($row[1] / 60) % 60);
        echo "<tr>";
            echo "<td>" . $row[0] . " hours: " . $hours . ":" . $minutes . "</td>";
        echo "</tr>";
    }
    echo "</table>";
?>

</body>


</html>