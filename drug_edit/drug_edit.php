<?php
        session_start();
        //Recieving variables
        $name = $_POST["edit_drug_name"];
        $field = $_POST["update_select"];
        
        //Sending the field to the next page
        $_SESSION['field'] = $field;
        $_SESSION['name'] = $name;
?>

<html>
<head>
<title>Edit Drug</title>
<a href="../index.php">Back To Home</a>
</head>

<body>

    <p>You are editing the <?= $field?> of: <?= $name?></p>

    <?php
        //Connecting to database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");

        //SQL statement to find what the previous entry was
        $sql = "SELECT $field FROM drugs WHERE name = '$name' COLLATE NOCASE";

        //Saving previous entry to variable
        $res = $db->query($sql);
        while($row = $res->fetchArray()){
            $previous_entry = $row[0];
        }
        
        //Form for updating previous entry
        echo "<form action='drug_update.php' method='POST' id=\"update_form\">";
        if(is_string($previous_entry)){
            echo "<p><textarea rows=\"8\" cols=\"50\" name=\"new_entry\">$previous_entry</textarea>";
        } 
        echo "<p><button id='update_button' type='submit' value='submit'>Update Field</button></p>";
        echo "</form>";

    ?>

</body>

</html>