<?php
    session_start();
?>

<html>
<head>
    <title>Deletion Confirmation</title>
    <a href="../index.php">Back To Home</a>
</head>
<body>
    <p>
    <?php
        //Retrieving variables
        $drug_to_delete = $_SESSION["drug_to_delete"];
        echo $drug_to_delete;

        //Open database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");

        //Delete statement
        $search_query = "SELECT * FROM drugs WHERE name = '$drug_to_delete'";
        $res = $db->query($search_query);
        $check = $db->query($search_query);

        
    //Deleting with confirmation
    if(!empty($check->fetchArray())){
        $stm = $db->prepare('DELETE FROM drugs WHERE name = ?');
        $stm->bindParam(1,$drug_to_delete);
        $stm->execute();
        echo $drug_to_delete . " deleted";
    }
     else{
       echo "There is no drug $drug_to_delete";
    }   
    ?>
    </p>

</body>
<html>