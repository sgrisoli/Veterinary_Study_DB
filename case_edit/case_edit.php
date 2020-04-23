<?php
        session_start();
        //Recieving variables
        $case_num = $_POST["case_num"];
        $field = $_POST["update_select"];

        //Sending the field to the next page
        $_SESSION['field'] = $field;
        $_SESSION['case_num'] = $case_num;
?>

<html>
<head>
<title>Edit Case</title>
<a href="../index.php">Back To Home</a>
</head>

<body>

    <p>You are editing the <?= $field?> of case number: <?= $case_num?></p>

    <?php
        //Connecting to database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");
        //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        //SQL statement to find what the previous entry was
        $sql = "SELECT $field FROM cases WHERE case_num = $case_num";

        //Saving previous entry to variable
        $res = $db->query($sql);
        while($row = $res->fetchArray()){
            $previous_entry = $row[0];
        }
        
        //Form for updating previous entry
        echo "<form action='case_update.php' method='POST' id=\"update_form\">";
        if(is_string($previous_entry)){
            echo "<p><textarea rows=\"8\" cols=\"50\" name=\"new_entry\">$previous_entry</textarea>";
        } elseif(is_numeric($previous_entry)){
            echo "<p><input name=\"new_entry\" type='number' value=$previous_entry></input></p>";
        }
        echo "<p><button id='update_button' type='submit' value='submit'>Update Field</button></p>";
        echo "</form>";

    ?>

</body>

</html>