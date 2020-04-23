<?php
    session_start();
    $user = $_SESSION['uname'];
?>
<html>
<head>
    <title>New Case Addition</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <a href="../index.php">Back To Home</a>
</head>

<body>
    <?php
        //Recieving variables
        $name = ucwords($_POST["name"]);
        $species = ucwords($_POST["species"]);
        $breed = ucwords($_POST["breed"]);
        $sex = ucwords($_POST["sex"]);
        $age = $_POST["age"];
        $weight = $_POST["weight"];
        $chip_num = $_POST["chip_num"];
        $symptoms = $_POST["symptoms"];
        $diagnosis = $_POST["diagnosis"];
        $treatment = $_POST["treatment"];
        $drug = $_POST["drug"];

        //Connecting to database
        $dir = dirname(getcwd());
        $db = new SQLite3($dir . "/vet_case_study.db");
        //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        //Assigning a new case number to the case
        $res = $db->query('SELECT MAX(case_num) FROM cases');
        while($row = $res->fetchArray()){
            $case_num = $row[0] + 1;
        }   

        //Change current directory to the uploaded image folder
        chdir('../web_images/uploads');

        //Getting image files to upload
        $number = count($_FILES['fileToUpload']["name"]);
        if($number >= 1){
            for($i=0; $i<$number; $i++){
                if(trim($_FILES["fileToUpload"]["name"][$i] != '')){
                    $pathparts = pathinfo($_FILES["fileToUpload"]["name"][$i]);
                    $target_dir = getcwd() . "/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
                    $uploadOk = 1;
                    echo "The target upload file is: " . $target_file;
                    echo "<br>";
                    
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["create_button"]) && $_FILES["fileToUpload"]["tmp_name"][$i]) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            echo "<br>";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            echo "<br>";
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        echo "<br>";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"][$i] > 500000) {
                        echo "Sorry, your file is too large.";
                        echo "<br>";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        echo "<br>";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        //If the file can be uploaded also need to add the path into image table
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                            echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                            $stmt = $db->prepare('INSERT into images VALUES (?,?)');
                            $stmt->bindParam(1,$_FILES["fileToUpload"]["name"][$i]);
                            $stmt->bindParam(2,$case_num);
                            if($stmt->execute()){
                                echo "Successfully added " . $_FILES["fileToUpload"]["name"][$i] . " to the database";
                            }
                        } else {
                            echo "Sorry, there was an error uploading your file. I am not sure why this is happening for many images ICLOUD?.";
                        }
                    }
                }
            }
        }

        //Deleting endline characters
        $symptoms = str_replace("\n", '', $symptoms);
        $diagnosis = str_replace("\n", '', $diagnosis);
        $treatment = str_replace("\n", '', $treatment);

        //Insert statement for new case
        $stm = $db->prepare('INSERT into cases VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $stm->bindParam(1,$case_num);
        $stm->bindParam(2,$name);
        $stm->bindParam(3,$species);
        $stm->bindParam(4,$breed);
        $stm->bindParam(5,$sex);
        $stm->bindParam(6,$age);
        $stm->bindParam(7,$weight);
        $stm->bindParam(8,$chip_num);
        $stm->bindParam(9,$symptoms);
        $stm->bindParam(10,$diagnosis);
        $stm->bindParam(11,$treatment);
        $stm->bindParam(12,$drug);
        $stm->bindParam(13,$user);

        $stm->execute();
        
        $select_query = "SELECT * FROM cases where case_num = $case_num";
        $res = $db->query($select_query);
        
        //Returning new entry
        echo "<p>Successfully added case number: " . $case_num . "<p>";
        echo "<form action='../view_case.php' method='POST'>";
            echo "<table>";
                echo "<tr>";
                    echo "<th></th>";
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
                    echo "<td><button type='submit' value='" . $case_num . "' name='btn'>View</button></td>";
                    for($i=0; $i<12; $i++){
                        echo "<td>" . $row[$i] . "</td>";
                    }
                echo "</tr>";
                }
            echo "</table>";
        echo "</form>";
    
    ?>
</body>

</html>