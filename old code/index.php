<?php
    session_start();
    $user = $_SESSION['uname'];

    if(!is_string($user)){
        //header('Location: /login.php');    //COMMENT BACK IN TO ENSURE LOGIN
    }
    $_SESSION['uname'] = $user;

    echo "Logged in as " .$user. "<br>";

?>

<?php
    //DB connection
    $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    
    //Query to get all case numbers for comparison
    $res = $db->query('SELECT case_num, username FROM cases');

    //Saving all case numbers to multidimentional array
    $data = array();
    while($row = $res->fetchArray()){
        $data[] = $row;
    }
    //Resaving all case numbers as simple array
    $arr_to_send = array();
    for($i=0; $i<=count($data); $i++){
        $arr_to_send[] = $data[$i][0];
    }
/*
    echo "<pre>";
    print_r($data);
    echo "</pre>";
*/
?>
<html>
    <a href="login.php">Logout</a>

    <head>
        <link rel="stylesheet" href="styles/styles.css">
        <title>Veterninary Case Study DB</title>
        <div class="header">
        <h1>Vet Case Database</h1>
        <h2>Stephen Grisoli</h2>
        </div>

    </head>
<body>

    <!-- Change width if number of buttons change -->
    <div class="btn-group" style="width:100%">
        <button style="width:25%" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">New Case</button>
        <button style="width:25%" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Edit Case</button>
        <button style="width:25%" onclick="document.getElementById('id03').style.display='block'" style="width:auto;">Search Case</button>
        <button style="width:25%" onclick="document.getElementById('id04').style.display='block'" style="width:auto;">Delete Case</button>

    </div>
    <div class="btn-group" style="width:100%">
        <button style="width:50%" onclick="window.location.href = 'exp_hours/add_select_hours.php'">Add Hours</button>
        <button style="width:50%" onclick="window.location.href = 'exp_hours/view_hours.php'">View Hours</button>
    <!--    <button style="width:33.33%" onclick="window.location.href = 'exp_hours/case_select_hours.php'">Edit Hours</button> -->
    </div>

    <div class="btn-group" style="width:100%">
        <button style="width:100%" onclick="window.location.href = 'web_images/upload_form.php'">Add Hours</button>
  
    </div>

    <!--------- Case insert modal ---------->
    <div id="id01" class="modal">
  
    <form class="modal-content animate" action="case_insert/case_insert.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="web_images/macy.png" alt="Avatar" class="avatar">
      <header><b>Add New Case</b></header>
    </div>

    <div class="container">
        <label for="name"><b>Name</b></label>
        <input type="text" name='name'>

        <label for="species"><b>Species</b></label>
        <input type="text" name='species'>

        <label for="breed"><b>Breed</b></label>
        <input type="text" name='breed'>

        <label for="sex"><b>Sex</b></label>
        <input type="text" name='sex'>

        <label for="age"><b>Age</b></label>
        <input type="number" name="age">

        <label for="weight"><b>Weight</b></label>
        <input type="number" name='weight'>

        <label for="chip_num"><b>Chip Number</b></label>
        <input type="number" name='chip_num'>

        <label for="symptoms"><b>Symptoms</b></label>
        <textarea rows="5" cols="50" placeholder="Symptoms" name='symptoms'></textarea>

        <label for="diagnosis"><b>Diagnosis</b></label>
        <textarea rows="5" cols="50" placeholder="Diagnosis" name='diagnosis'></textarea>

        <label for="treatment"><b>Treatment</b></label>
        <textarea rows="5" cols="50" placeholder="Treatment" name='treatment'></textarea>

        <label for="drug"><b>Drug</b></label>
        <input type="text" name='drug'>

        <label for="image"><b>Select an Image to Upload</b></label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        
        <button type="submit">Create Case</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    </form>
    </div>


    <!--------- Case edit modal ---------->
    <div id="id02" class="modal">

    <form class="modal-content animate" action="case_edit/case_edit.php" method="post">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="web_images/macy.png" alt="Avatar" class="avatar">
        <header><b>Edit Case</b></header>
    </div>

    <div class="container">
        <label for="case_num"><b>Case Number to Edit</b></label>
            <input type="number" name='case_num' id='case_num' onkeyup="test_case_num()" required><br>
        <p id="check_case"></p>

        <label for='update_select'><b>Field to Edit</b></label>
        <select name='update_select' id='update_select' onchange="test_case_num()">
            <option value="" disabled selected>Select Field</option>
            <option value=name>Name</option>
            <option value=species>Species</option>
            <option value=breed>Breed</option>
            <option value=sex>Sex</option>
            <option value=age>Age</option>
            <option value=weight>Weight</option>
            <option value=chip_num>Chip Number</option>
            <option value=symptoms>Symptoms</option>
            <option value=diagnosis>Diagnosis</option>
            <option value=treatment>Treatment</option>
            <option value=drug>Drug</option>
        </select>

        <button type="submit" id="edit_case_btn" style="display: none">Edit Case</button>

    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    </form>
    </div>


    <!--------- Case Search Modal ---------->
    <div id="id03" class="modal">

    <form class="modal-content animate" action="case_search/case_search.php" method="post">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="web_images/macy.png" alt="Avatar" class="avatar">
        <header><b>Search Case</b></header>
    </div>

    <div class="container">
        <label for='search_select'><b>Field to Search</b></label>
        <select name='search_select' id='search_select' onchange="popup(value)">
            <option value="" disabled selected>Select Field</option>
            <option value=case_num>Case Number</option>
            <option value=name>Name</option>
            <option value=species>Species</option>
            <option value=breed>Breed</option>
            <option value=sex>Sex</option>
            <option value=age>Age</option>
            <option value=weight>Weight</option>
            <option value=chip_num>Chip Number</option>
            <option value=symptoms>Symptoms</option>
            <option value=diagnosis>Diagnosis</option>
            <option value=treatment>Treatment</option>
            <option value=drug>Drug</option>
        </select>

        <div id="text_hideaway" style="display:none;">
            <p><input type="text" name="text_query" id="text_query" onkeyup="button_bool(document.getElementById('text_query').value)"></input></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
        </div>

        <div id="number_hideaway" style="display:none;">
            <p><input type="number" name="num_query" id="num_query" onkeyup="button_bool(document.getElementById('num_query').value)"></input></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
        </div>

        <div id="textarea_hideaway" style="display:none;">
            <p><textarea rows="8" cols="50" placeholder="Type query here" name="textarea_query" id="textarea_query" onkeyup="button_bool(document.getElementById('textarea_query').value)"></textarea></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
        </div>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    </form>
    </div>


    <!-- Case Delete Modal -->
    <div id="id04" class="modal">

    <form class="modal-content animate" action="case_delete/case_delete.php" method="POST">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="web_images/macy.png" alt="Avatar" class="avatar">
        <header><b>Delete Case</b></header>
    </div>

    <div class="container">
        <label for="del_case_num"><b>Case Number to Delete</b></label>
            <input type="number" name='del_case_num' id='del_case_num' onkeyup="test_del_case_num()" required><br>
        <p id="check_delete_case"></p>

        <button type="submit" id="delete_case_btn" style="display: none">Delete Case</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancel</button>
    
        <p id="tester"></p>
        <p id="testers"></p>


    
    </div>
    </form>
    </div>


</body>

<script>
//Get the modals
var new_case_modal = document.getElementById('id01');
var edit_case_modal = document.getElementById('id02');
var search_case_modal = document.getElementById('id03');
var delete_case_modal = document.getElementById('id04');


//Function to close window if they click outside of it
window.onclick = function(event) {
    if (event.target == new_case_modal) {
        new_case_modal.style.display = "none";
    }
    if (event.target == edit_case_modal){
       edit_case_modal.style.display = "none";
    }
    if (event.target == search_case_modal){
       search_case_modal.style.display = "none";
    }
    if (event.target == delete_case_modal){
       delete_case_modal.style.display = "none";
    }
}

//Function to check if case number is real
function test_case_num(){

    //Recieve array from php
    var passed_array = <?php echo json_encode($data); ?>;
    var user = <?php echo json_encode($user); ?>;

    //Get value user has typed into username filed
    var current_case = document.getElementById("case_num").value;
    var field = document.getElementById("update_select").value;
    
    var i = 0;
    //Compare potential username with all taken usernames
    for(i = 0; i <= passed_array.length; i++){
       // document.getElementById("check_case").innerHTML = "";
        
        //Case num matches case and field is selected
        if(current_case == passed_array[i]["case_num"] && field.length > 0 && user == passed_array[i]["username"]){
            document.getElementById("edit_case_btn").style.display='block';
            break;

        //Case number is correct but no field selected
        } else if(field.length == 0){
            document.getElementById("check_case").innerHTML = "Please Select a Field";
            //break;

        //Nothing has been typed
        } else if(current_case.length == 0){
            document.getElementById("check_case").innerHTML = "";
            document.getElementById("edit_case_btn").style.display='none';

        //Trying to edit another user's 
        } else if(user != passed_array[i]["username"]){
            document.getElementById("check_case").innerHTML = "You can only edit cases that you have added";
        } 
    }
}

//Script to hide input boxes that arn't going to be used. 
function popup(value){
    if(value == "name" || value == "species" || value == "breed" || value == "sex" || value == "drug"){
        document.getElementById('text_hideaway').style.display='block';
    } else {
        document.getElementById('text_hideaway').style.display='none';
    }

    if(value == "case_num" || value == "age" || value == "weight" || value == "chip_num"){
        document.getElementById('number_hideaway').style.display='block';
    } else {
        document.getElementById('number_hideaway').style.display='none';
    }

    if(value == "symptoms" || value == "diagnosis" || value == "treatment"){
        document.getElementById('textarea_hideaway').style.display='block';
    } else{
        document.getElementById('textarea_hideaway').style.display='none';
    }
}

//Function to make search button appear on proper input
function button_bool(value){
    if(value.length > 0){
        document.getElementById('search_button').style.display='block';
    } else {
        document.getElementById('search_button').style.display='none';
    }
}

//Function to make delete case button appear on proper input
function test_del_case_num(){
    //Recieve array from php
    var passed_array = <?php echo json_encode($data); ?>;
    var user = <?php echo json_encode($user); ?>;

    //Get user input
    var case_num = document.getElementById('del_case_num').value;

    //Setting this text to null before loop
    document.getElementById("check_delete_case").innerHTML = "";

    //Compare potential username with all taken usernames
    for(var i = 0; i <= passed_array.length; i++){
        document.getElementById("delete_case_btn").style.display='none';
        
        //Case num matches case and field is selected
        if(case_num == passed_array[i]["case_num"] && user == passed_array[i]["username"]){
            document.getElementById("delete_case_btn").style.display='block';
            document.getElementById("check_delete_case").innerHTML = "";
            break;
        //Shouldn't be able to delete this case
        } else{
            document.getElementById("check_delete_case").innerHTML = "You can only delete your cases";
        }
    }
}

</script>


</html>
