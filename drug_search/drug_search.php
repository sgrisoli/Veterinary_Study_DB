<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <a href="../index.php">Back To Home</a><br>
</head>
<body>

<?php
//Establish connection
$dir = dirname(getcwd());
$db = new SQLite3($dir . "/vet_case_study.db");

//Get number of search fields requested
$number = count($_GET['name']);

//Initialize an array to include all cases numbers of matching searches
$result_arr = array();

//Getting variables from previous HTML and executing sqlite query
if($number >= 1){
	for($i=0; $i<$number; $i++){
		if(trim($_GET["name"][$i] != '')){
            $search = $_GET["name"][$i];
        }
        if(trim($_GET["search_select"][$i] != '')){
            $field = $_GET["search_select"][$i];
        }

        $search_query = "SELECT name FROM drugs WHERE $field LIKE '%$search%' COLLATE NOCASE";
        $res = $db->query($search_query);
        $check = $db->query($search_query);

        
        //Append matching cases to a master array
        if(!empty($check->fetchArray())){
            while(${'row' . $i} = $res->fetchArray()){
                array_push($result_arr, ${'row' . $i}[0]);
                }
        }
            else{
                echo "No drugs found where $field is $search";
            } 
	}
	
}
else{
	echo "No Valid Fields Entered";
}

//Make sure array isn't empty then display all cases matching
//Also creates a form allowing for detailed view of individual cases
if(!empty($result_arr)){
    for($j=0;$j<count($result_arr);$j++){
        if(count_occurences($result_arr, count($result_arr), $result_arr[$j]) == $number){
            echo "<form action='../view_drug.php' method='POST'>";
            echo "<table id='result_tb'>";
                echo "<tr>";
                    echo "<th width='55px'></th>";
                    echo "<th width='45px'></th>";
                    echo "<th width='110px'>Name</th>";
                    echo "<th width='100px' style='text-align:center'>Type/Class</th>";
                    echo "<th width='100px' style='text-align:center'>Generic Names</th>";
                    echo "<th width='60px' style='text-align:center'>Route</th>";
                    echo "<th width='100px' style='text-align:center'>Applications</th>";
                    echo "<th width='100px' style='text-align:center'>Side Effects</th>";
                    echo "<th width='100px' style='text-align:center'>Interactions</th>";
                    echo "<th width='100px' style='text-align:center'>Mechanism</th>";
                echo "</tr>";
            break;
        }
    }
    $matching_drugs = array();
    $matching_drugs = matching_drugs($result_arr, $number);

    //Return cases if they match all of the search criteria
    for($j=0;$j<count($matching_drugs);$j++){
            $search_query = "SELECT * FROM drugs WHERE name LIKE '$matching_drugs[$j]'";
            $res = $db->query($search_query);
            $check = $db->query($search_query);

            if(!empty($check->fetchArray())){
                while($row = $res->fetchArray()){
                    echo "<tr>";
                        echo "<td><button type='submit' value=\"$matching_drugs[$j]\" name='delete_btn' id='case_delete_btn'>Delete</button></td>";
                        echo "<td><button type='submit' value=\"$matching_drugs[$j]\" name='btn' id='case_view_btn'>View</button></td>";
                        for($i=0; $i<8; $i++){
                            echo "<td id='case_info_cell'>" . $row[$i] . "</td>";
                        }
                    echo "</tr>";
                    }
                }
        }
    }
echo "</table>";
echo "</form>";


//Function to count the number of occurences of a given number in array
function count_occurences($arr, $n, $x) { 
    $res = 0; 
    for ($i = 0; $i < $n; $i++) 
        if ($x == $arr[$i]) 
        $res++; 
    return $res; 
}

//Function to return an array that has drugs that fit all search criteria
function matching_drugs($result_arr, $n){
    $matching_drugs = array();
    for($i=0;$i<count($result_arr);$i++){
        if(count_occurences($result_arr, count($result_arr), $result_arr[$i]) == $n){
            array_push($matching_drugs, $result_arr[$i]);
        }
    }
    $matching_drugs = array_unique($matching_drugs);
    return $matching_drugs;
}
?>

</body>
<script type="text/javascript">
</script>
</html>