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
        $case_num = $_SESSION["delete_case_num"];

        //Open database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");
        //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        //Delete statement
        $search_query = "SELECT * FROM cases WHERE case_num = '$case_num'";
        $res = $db->query($search_query);
        $check = $db->query($search_query);

        
    //Deleting with confirmation
    if(!empty($check->fetchArray())){
        $stm = $db->prepare('DELETE FROM cases WHERE case_num = ?');
        $stm->bindParam(1,$case_num);
        $stm->execute();
        echo "Case number $case_num deleted";
    }
     else{
       echo "There is no case number $case_num";
    }   
    ?>
    </p>

</body>
<html>