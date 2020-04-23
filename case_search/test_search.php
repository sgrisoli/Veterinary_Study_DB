<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <a href="../index.php">Back To Home</a>
</head>

<body>
<?php
//Establish connection
$dir = dirname(getcwd());
$db = new SQLite3($dir . "/vet_case_study.db");
//$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

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
        $search_query = "SELECT case_num FROM cases WHERE $field LIKE '%$search%' COLLATE NOCASE";
        $res = $db->query($search_query);
        $check = $db->query($search_query);

        
        //Append matching cases to a master array
        if(!empty($check->fetchArray())){
            while(${'row' . $i} = $res->fetchArray()){
                array_push($result_arr, ${'row' . $i}[0]);
                }
        }
            else{
                echo "No cases exist where $field is $query";
            } 
	}
	
}
else{
	echo "No Valid Fields Entered";
}

//Make sure array isn't empty then display all cases matching
//Also creates a form allowing for detailed view of individual cases
if(!empty($result_arr)){
    for($j=1;$j<=max($result_arr);$j++){
        if(count_occurences($result_arr, count($result_arr), $j) == $number){
            echo "<form action='../view_case.php' method='POST'>";
            echo "<table id='result_tb'>";
                echo "<tr>";
                    echo "<th width='55px'></th>";
                    echo "<th width='45px'></th>";
                    echo "<th width='38px'>Case #</th>";
                    echo "<th width='60px' style='text-align:center'>Name</th>";
                    echo "<th width='60px' style='text-align:center'>Species</th>";
                    echo "<th width='60px' style='text-align:center'>Breed</th>";
                    echo "<th width='55px' style='text-align:center'>Sex</th>";
                    echo "<th width='35px' style='text-align:center'>Age</th>";
                    echo "<th width='55px' style='text-align:center'>Weight</th>";
                    echo "<th width='60px' style='text-align:center'>Chip #</th>";
                    echo "<th style='text-align:center'>Symptoms</th>";
                    echo "<th style='text-align:center'>Diagnosis</th>";
                    echo "<th style='text-align:center'>Treatment</th>";
                    echo "<th style='text-align:center'>Drugs Used</th>";
                echo "</tr>";
            break;
        }
    }


    //Return cases if they match all of the search criteria
    for($j=1;$j<=max($result_arr);$j++){
        if(count_occurences($result_arr, count($result_arr), $j) == $number){
            $search_query = "SELECT * FROM cases WHERE case_num LIKE '$j'";
            $res = $db->query($search_query);
            $check = $db->query($search_query);

            if(!empty($check->fetchArray())){
                while($row = $res->fetchArray()){
                    echo "<tr>";
                        echo "<td><button type='submit' value=$j name='delete_btn' id='case_delete_btn'>Delete</button></td>";
                        echo "<td><button type='submit' value=$j name='btn' id='case_view_btn'>View</button></td>";
                        for($i=0; $i<12; $i++){
                            echo "<td id='case_info_cell'>" . $row[$i] . "</td>";
                        }
                    echo "</tr>";
                    }
                }
        }
    }
}
echo "</table>";
echo "</form>";


//Function to count the number of occurences of a given number in array
function count_occurences($arr, $n, $x) 
{ 
    $res = 0; 
    for ($i = 0; $i < $n; $i++) 
        if ($x == $arr[$i]) 
        $res++; 
    return $res; 
}
?>

</body>
<script type="text/javascript">
</script>
</html>