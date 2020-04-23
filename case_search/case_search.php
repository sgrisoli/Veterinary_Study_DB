<html>
<head>
<title>Case Search</title>
<a href="../index.php">Back To Home</a>
</head>

<body>
<?php
    //Clearing any saved variables from previous sessions
    unset($textarea_query);
    unset($num_query);
    unset($text_query);

    //Retrieving variables
    $text_query = $_POST["text_query"];
    $num_query = $_POST["num_query"];
    $textarea_query = $_POST["textarea_query"];
    $field = $_POST["search_select"];

    //Assigned variable to query
    if(strlen($textarea_query) > 0){
        $query = SQLite3::escapeString($textarea_query);
    } elseif (strlen($text_query) > 0){
        $query = SQLite3::escapeString($text_query);
    } elseif (strlen($num_query) > 0){
        $query = (int)$num_query;
    }

    //Searching db for relavant cases
    $dir = dirname(getcwd());
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    $search_query = "SELECT * FROM cases WHERE $field LIKE '%$query%' COLLATE NOCASE";
        $res = $db->query($search_query);
        $check = $db->query($search_query);

        
    //Returning new entry
    if(!empty($check->fetchArray())){
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
    }
     else{
       echo "No cases exist where $field is $query";
    } 
 ?>

</body>

</html>