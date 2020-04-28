<?php
    session_start();
    $name = $_POST['btn'];
    $delete_drug = $_POST['delete_btn'];
    $_SESSION['drug_to_delete'] = $delete_drug;
    if(!empty($delete_drug)){
        header('Location: drug_delete/drug_delete.php');
    }

    //establish connection
    $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    //save search query result to an array
    $search_query = "SELECT * FROM drugs WHERE name LIKE '$name' COLLATE NOCASE";
    $res = $db->query($search_query);

    $case_data = array();
    while($row = $res->fetchArray()){
        $case_data[] = $row;
    }
?>

<html>
<head>
    <title><?php echo $name . " Info"?> </title>
    <link rel="stylesheet" href="../styles/styles.css">
    <a href="../index.php">Back To Home</a>

</head>

    <div id="basic_info">
        <table style="width:auto">
            <tr>
                <td><b>Name</b></td>
                <td><?php echo $case_data[0][0]?></td>
            </tr>
            <tr>
                <td><b>Type/Class</b></td>
                <td><?php echo $case_data[0][1]?></td>
            </tr>
            <tr>
                <td><b>Generic/Brand Names</b></td>
                <td><?php echo $case_data[0][2]?></td>
            </tr>
            <tr>
                <td><b>Route</b></td>
                <td><?php echo $case_data[0][3]?></td>
            </tr>
            <tr>
                <td><b>Dosing</b></td>
                <td><?php echo $case_data[0][8]?></td>
            </tr>
        </table>
        <img id="drug_image" alt="drug_image.jpg" src="../web_images/drug_image.jpg" style="height:150px; width=auto">

    </div>
    <div id="basic_info">
        <table>
            <tr>
                <td><b>Applications</b></td>
                <td><?php echo $case_data[0][4]?></td>
            </tr>
            <tr>
                <td><b>Possible Side Effects</b></td>
                <td><?php echo $case_data[0][5]?></td>
            </tr>
            <tr>
                <td><b>Known Interactions</b></td>
                <td><?php echo $case_data[0][6]?></td>
            </tr>
            <tr>
                <td><b>Mechanism</b></td>
                <td><?php echo $case_data[0][7]?></td>
            </tr>
        </table>
    </div>



</body>