<?php
//Retrieve variables from form
session_start();

echo "<a href=\"../index.php\">Back To Home</a>";

$case_num = $_POST["btn"];
$delete_case_num = $_POST['delete_btn'];
$_SESSION['delete_case_num'] = $delete_case_num;
    if(!empty($delete_case_num)){
        header('Location: case_delete/case_delete.php');
    }

//establish connection
$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

//save search query result to an array
$search_query = "SELECT * FROM cases WHERE case_num LIKE $case_num";
$res = $db->query($search_query);

$case_data = array();
while($row = $res->fetchArray()){
    $case_data[] = $row;
}
echo "<pre>";
//print_r($case_data);
echo "</pre>";


//Save image paths from this case to an array
$image_query = "SELECT image_path FROM images WHERE case_num LIKE $case_num";
$res = $db->query($image_query);
$image_data = array();
while($row = $res->fetchArray()){
    $image_data[] = $row;
}


for($i=0; $i<sizeof($image_data); $i++){
//    echo "<img style=\"max-width:25%; height:auto\" src=\"./web_images/uploads/" . $image_data[$i][0] . "\"alt=\"failure\">";
}

?>

<html>
<head>
    <title><?php echo "Case #" .  $case_num . " " . $case_data[0][1] . " the " . $case_data[0][2]?> </title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body onload=choose_image()>

    <div id="basic_info">
        <div class="block">
            <img id="animal_icon" alt="small_dsh.jpg" style="max-width:250px; max-height:175px">
        </div> 
        <div class="block">
            <table>
                <tr>
                    <td><b>Case Number</b></td>
                    <td><?php echo $case_data[0][0]?></td>
                </tr>
                <tr>
                    <td><b>Name</b></td>
                    <td><?php echo $case_data[0][1]?></td>
                </tr>
                <tr>
                    <td><b>Species</b></td>
                    <td><?php echo $case_data[0][2]?></td>
                </tr>
                <tr>
                    <td><b>Breed</b></td>
                    <td><?php echo $case_data[0][3]?></td>
                </tr>
            </table>
        </div>
        <div class="block">
            <table>
                <tr>
                    <td><b>Sex</b></td>
                    <td><?php echo $case_data[0][4]?></td>
                </tr>
                <tr>
                    <td><b>Age</b></td>
                    <td><?php echo $case_data[0][5]?></td>
                </tr>
                <tr>
                    <td><b>Weight</b></td>
                    <td><?php echo $case_data[0][6]?></td>
                </tr>
                <tr>
                    <td><b>Chip Number</b></td>
                    <td><?php echo $case_data[0][7]?></td>
                </tr>
            </table>
        </div>           
    </div>

    <div id="medical_info">
        <table>
            <tr>
                <td><b>Symptoms: </b><?php echo $case_data[0][8]?></td>
            </tr>
            <tr>
                <td><b>Diagnosis: </b><?php echo $case_data[0][9]?></td>
            </tr>
            <tr>
                <td><b>Treatment: </b><?php echo $case_data[0][10]?></td>
            </tr>
        </table>
    </div>

    <div id="drug_info">
        <table>
            <tr>
                <td><b>Drugs Used: </b><?php echo $case_data[0][11]?></td>
            </tr>
            <!-- ADD LINK TO DRUG DB HERE -->
        </table>
    </div>

</body>

<script>
    function choose_image(){
        //Fetching data array from php
        var case_data = <?php echo json_encode($case_data); ?>;

        //Switch to decide which picture to use based on species and weight
        if(case_data[0][2] == "Cat" && case_data[0][6] <= 6){
            document.getElementById("animal_icon").src = "web_images/small_dsh.jpg";
        }

        if(case_data[0][2] == "Cat" && case_data[0][6] > 6){
            document.getElementById("animal_icon").src = "web_images/large_dsh.jpg";
        }

        if(case_data[0][2] == "Dog" && case_data[0][6] <= 25){
            document.getElementById("animal_icon").src = "web_images/small_dog.jpg";
        }

        if(case_data[0][2] == "Dog" && case_data[0][6] > 25){
            document.getElementById("animal_icon").src = "web_images/large_dog.jpg";
        }
    }

</script>

</html>