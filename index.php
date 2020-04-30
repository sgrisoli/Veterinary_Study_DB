<?php
    session_start();
    $user = $_SESSION['uname'];

    if(!is_string($user)){
   //     header('Location: /login.php');    //COMMENT BACK IN TO ENSURE LOGIN
    }
    $_SESSION['uname'] = $user;

    echo "Logged in as " .$user. "<br>";
?>

<?php
    //DB connection
    $dir = getcwd();
    $db = new SQLite3($dir . "/vet_case_study.db");
    
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

    //Query to get all drug names for comparison
    $drug_res = $db->query('SELECT name FROM drugs');

    //Saving all durg names to multidimentional array
    $drugs = array();
    while($row = $drug_res->fetcharray()){
        $drugs[] = $row;
    }

?>
<html>
    <a href="login.php">Logout</a>

    <head>
        <link rel="stylesheet" href="styles/styles.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <title>VetCentral</title>
        <div class="header">
            <h1>VetCentral</h1>
            <h2>Veterinary Study Toolkit and Database
        </div>

    </head>
<body>

    <!-- Master Dropdown menus -->
    <div class="dropdown" style="width:33%">
    <button class="dropbtn">Cases</button>
        <div class="dropdown-content">
            <button onclick="document.getElementById('id01').style.display='block'">New Case</button>
            <button onclick="document.getElementById('id02').style.display='block'">Edit Case</button>
            <button onclick="document.getElementById('id03').style.display='block'">Search Case</button>
            <button onclick="document.getElementById('id04').style.display='block'">Delete Case</button>
        </div>
    </div>

    <div class="dropdown" style="width:33%">
    <button class="dropbtn">Drugs</button>
        <div class="dropdown-content">
            <button onclick="document.getElementById('id05').style.display='block'">Add Drug</button>
            <button onclick="document.getElementById('id06').style.display='block'">Edit Drug</button>
            <button onclick="document.getElementById('id07').style.display='block'">Search/Delete Drug</button>
        </div>
    </div>

    <div class="dropdown" style="width:33%">
    <button class="dropbtn">Experience Hours</button>
        <div class="dropdown-content">
            <button onclick="window.location.href = 'exp_hours/add_select_hours.php'">Add Experience Hours</button>
            <button onclick="window.location.href = 'exp_hours/view_hours.php'">View Experience Hours</button>
        </div>
    </div>

    <!--------- Case insert modal ---------->
    <div id="id01" class="modal">
  
    <form class="modal-content animate" action="case_insert/case_insert.php" id="insert_form" method="POST" enctype="multipart/form-data" class="form-control name_list">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
      <header><b>Add New Case</b></header>
    </div>

    <div class="container">
        <label for="name"><b>Name</b></label>
        <input type="text" name='name'/>

        <label for="species"><b>Species</b></label>
        <input type="text" name='species'/>

        <label for="breed"><b>Breed</b></label>
        <input type="text" name='breed'/>

        <label for="sex"><b>Sex</b></label>
        <input type="text" name='sex'/>

        <label for="age"><b>Age</b></label>
        <input type="number" name="age"/>

        <label for="weight"><b>Weight</b></label>
        <input type="number" name='weight' step=".01"/>

        <label for="chip_num"><b>Chip Number</b></label>
        <input type="number" name='chip_num'/>

        <label for="symptoms"><b>Symptoms</b></label>
        <textarea rows="5" cols="50" placeholder="Symptoms" name='symptoms'></textarea>

        <label for="diagnosis"><b>Diagnosis</b></label>
        <textarea rows="5" cols="50" placeholder="Diagnosis" name='diagnosis'></textarea>

        <label for="treatment"><b>Treatment</b></label>
        <textarea rows="5" cols="50" placeholder="Treatment" name='treatment'></textarea>

        <label for="drug"><b>Drug</b></label>
        <input type="text" name='drug'/>

        <div class="table-responsive">
            <label><b>Select an Image to Upload</b></label>
            <table class="table table-bordered" id="image_upload_tb">
                <tr>
                    <td><input type="file" name="fileToUpload[]"/></td>
                    <td><button type="button" name="add_image" id="add_image" class="btn btn-success">Add Another Image</button></td>
                </tr>
            </table>
        </div>
        
        <button type="submit" name="create_button" id="create_button">Create Case</button>
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
        <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
        <header><b>Edit Case</b></header>
    </div>

    <div class="container">
        <label for="case_num"><b>Case Number to Edit</b></label>
            <input type="number" name='case_num' id='case_num' onkeyup="test_case_num()" required><br>
        <p id="check_case"></p>

        <label for='update_select'><b>Field to Edit</b></label>
        <select name='update_select' id='update_select' onchange="test_case_num()" required>
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
        <div class="form-group">

        <form name="add_name" id="add_name" class="modal-content animate" action="case_search/test_search.php" method="GET">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
                <header><b>Search Cases by Fields</b></header>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <td><input type="text" name="name[]" placeholder="Query" class="form-control name_list"></td>
                            <td><select name='search_select[]' id='search_select' onchange="popup(value)" required>
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
                            </td>
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <button type="submit" name="search_submit" id="search_submit" class="btn btn-info">Submit</button>
                </div>
            </form>
	    </div>
    </div>


    <!-- Case Delete Modal -->
    <div id="id04" class="modal">

    <form class="modal-content animate" action="case_delete/case_delete.php" method="POST">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
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
    </div>
    </form>
    </div>


    <!--------- Drug insert modal ---------->
    <div id="id05" class="modal">
  
    <form class="modal-content animate" action="drug_insert/drug_insert.php" id="drug_insert_form" method="POST" enctype="multipart/form-data" class="form-control name_list">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
      <header style="font-size:20px"><b>Add New Drug</b></header>
    </div>

    <div class="container">
        <div id="basic_drug_info" name="basic_drug_info">
            <label for="basic_drug_info"><b>Basic Information</b></label>
            <div id="basic_drug_info_left">
                <input type="text" name='name' id='drug_name' placeholder="Drug Name" onkeyup="test_drug_name()" required/>

                <input type="text" name='type' placeholder="Type or Class"/>
            </div>
            <div id="basic_drug_info_right">
                <input type="text" name='brand_name' placeholder="Generic Name(s)"/>

                <input type="text" name='method' placeholder="Route"/> 
            </div>
        </div>

            <p id="drug_name_confirm">&nbsp</p>

            <label for="use"><b>Uses</b></label>
            <textarea rows="4" cols="50" placeholder="Common uses" name='use'></textarea>

            <label for="side_effetcs"><b>Side Effects</b></label>
            <textarea rows="4" cols="50" placeholder="Common side effects" name='side_effects'></textarea>

            <label for="interactions"><b>Known Interactions</b></label>
            <textarea rows="4" cols="50" placeholder="Known interactions" name='interactions'></textarea>

            <label for="interactions"><b>Mechanism</b></label>
            <textarea rows="4" cols="50" placeholder="Mechanism" name='mechanism'></textarea>

            <label for="dosing"><b>Dosing</b></label>
            <input type="text" name="dosing" placeholder="Common Dosing"/>

            <button type="submit" id="add_drug_btn" style="display: block">Add Drug</button>
            
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id05').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>

    <!--------- Drug edit modal ---------->
    <div id="id06" class="modal">

    <form class="modal-content animate" action="drug_edit/drug_edit.php" method="post">
    <div class="imgcontainer">
        <span onclick="document.getElementById('id06').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
        <header><b>Edit Drug</b></header>
    </div>

    <div class="container">
        <label for="edit_drug_name"><b>Drug to Edit</b></label>
            <input type="text" name='edit_drug_name' id='edit_drug_name' onkeyup="test_drug_edit()" required style="width:400px"><br>
        <p id="check_drug"></p>

        <label for='update_select'><b>Field to Edit</b></label>
        <select name='update_select' id='update_select' required>
            <option value="" disabled selected>Select Field</option>
            <option value=name>Name</option>
            <option value=type>Type</option>
            <option value=brand_name>Brand/Generic Name</option>
            <option value=use>Applications/Uses</option>
            <option value=route>Route</option>
            <option value=side_effects>Side Effects</option>
            <option value=interaction>Interaction</option>
            <option value=mechanism>Mechanism</option>
            <option value=dosing>Dosing</option>
        </select>

        <button type="submit" id="edit_drug_btn" style="display: none">Edit Drug</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id06').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    </form>
    </div>

    <!--------- Drug Search Modal ---------->
    <div id="id07" class="modal">
        <div class="form-group">

        <form name="add_name" id="add_name" class="modal-content animate" action="drug_search/drug_search.php" method="GET">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id07').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="web_images/avatar_img.jpg" alt="Avatar" class="avatar">
                <header><b>Search Drug by Fields</b></header>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_drug_search_field" name="dynamic_drug_search_field">
                        <tr>
                            <td><input type="text" name="name[]" placeholder="Query" class="form-control name_list"></td>
                            <td><select name='search_select[]' id='search_select' onchange="popup(value)">
                                <option value="" disabled selected>Select Field</option>
                                <option value=name>Name</option>
                                <option value=type>Type</option>
                                <option value=brand_name>Brand/Generic Name</option>
                                <option value=use>Applications/Uses</option>
                                <option value=method>Route</option>
                                <option value=side_effects>Side Effects</option>
                                <option value=interaction>Interaction</option>
                                <option value=mechanism>Mechanism</option>
                                <option value=dosing>Dosing</option>
                            </select>
                            </td>
                            <td><button type="button" name="add_drug_search" id="add_drug_search" class="btn btn-success">Add More</button></td>
                        </tr>
                    </table>
                    <button type="submit" name="search_submit" id="search_submit" class="btn btn-info">Submit</button>
                </div>
            </form>
	    </div>
    </div>


    <!-- Slideshow container -->
<div class="slideshow-container">

<!-- Full-width images with number and caption text -->
<div class="mySlides fade">
  <div class="numbertext">1 / 4</div>
  <img src="web_images/veterinary_logo.jpg" style="width:auto; height:45%" class="center">
  <div class="text">Your Hub for Veterinary Learning</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 4</div>
  <img src="web_images/animals_slideshow.jpg" style="width:auto; height:45%" class="center">
  <div class="text">Store Animal Specific Drug Information</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 4</div>
  <img src="web_images/dog_xray.jpg" style="width:auto%; height:45%" class="center">
  <div class="text">Image Storage Capabilities for Cases</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">4 / 4</div>
  <img src="web_images/exp_hours.jpg" style="width:auto%; height:45%" class="center">
  <div class="text">Veterinary Experience Hour Tracking</div>
</div>

<!-- Next and previous buttons -->
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
<span class="dot" onclick="currentSlide(1)"></span>
<span class="dot" onclick="currentSlide(2)"></span>
<span class="dot" onclick="currentSlide(3)"></span>
<span class="dot" onclick="currentSlide(4)"></span>

</div>


</body>




<script>
$(document).ready(function(){
    //Functions for case search dynamic input fields
	var i=1;
	$('#add').click(function(){
        i++;
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Query" class="form-control name_list" /></td><td><select name="search_select[]" id="search_select" onchange="popup(value)"><option value="" disabled selected>Select Field</option><option value=case_num>Case Number</option><option value=name>Name</option><option value=species>Species</option><option value=breed>Breed</option><option value=sex>Sex</option><option value=age>Age</option><option value=weight>Weight</option><option value=chip_num>Chip Number</option><option value=symptoms>Symptoms</option><option value=diagnosis>Diagnosis</option><option value=treatment>Treatment</option><option value=drug>Drug</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
	});

    $('#add_drug_search').click(function(){
        i++;
        $('#dynamic_drug_search_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Query" class="form-control name_list" /></td><td><select name="search_select[]" id="search_select" onchange="popup(value)"><option value="" disabled selected>Select Field</option><option value=name>Name</option><option value=type>Type</option><option value=brand_name>Brand/Generic Name</option><option value=use>Applications/Uses</option><option value=method>Route</option><option value=side_effects>Side Effects</option><option value=interaction>Interaction</option><option value=mechanism>Mechanism</option><option value=dosing>Dosing</option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    

	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
    
	$('#search_submit').click(function(){		
		$.ajax({
			url:"test_search.php",
			type:"GET",
            date: {name:name},
			success:function(data)
			{
				alert(data);
				$('#add_name')[0].reset();
			}
		});
    });
    
    //Functions for case insert dynamic input fields
	var row_num=1;
	$('#add_image').click(function(){
        row_num++;
        $('#image_upload_tb').append('<tr id="row'+row_num+'"><td><input type="file" name="fileToUpload[]"/></td><td><button style="background-color:red" type="button" name="remove" id="'+row_num+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    
	$('#create_button').click(function(){	
		$.ajax({
			url:"case_insert.php",
			type:"POST",
            data: {fileToUpload:fileToUpload},
			success:function(data)
			{
				alert(data);
				$('#insert_form')[0].reset();
			}
		});
    });
});

//Not allowing for form submission with enter key
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

//Get the modals
var new_case_modal = document.getElementById('id01');
var edit_case_modal = document.getElementById('id02');
var search_case_modal = document.getElementById('id03');
var delete_case_modal = document.getElementById('id04');
var new_drug_modal = document.getElementById('id05');
var edit_drug_modal = document.getElementById('id06');
var search_drug_modal = document.getElementById('id07');

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
    if (event.target == new_drug_modal){
        new_drug_modal.style.display = "none";
    }
    if (event.target == edit_drug_modal){
        edit_drug_modal.style.display = "none";
    }
    if (event.target == search_drug_modal){
        search_drug_modal.style.display = "none";
    }
}

//Function to check if case number is real
function test_case_num(){

    //Recieve array from php
    var passed_array = <?php echo json_encode($data); ?>;

    //Get value user has typed into username filed
    var current_case = document.getElementById("case_num").value;
    var field = document.getElementById("update_select").value;

    var i = 0;
    //Compare potential username with all taken usernames
    for(i = 0; i <= passed_array.length; i++){
        document.getElementById("edit_case_btn").style.display='none';
        document.getElementById("check_case").innerHTML = 'Case Does Not Exist';

        //Case num matches case and field is selected
        if(current_case == passed_array[i]["case_num"]){
            document.getElementById("edit_case_btn").style.display='block';
            document.getElementById("check_case").innerHTML = '';
            break;
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

    //Get user input
    var case_num = document.getElementById('del_case_num').value;

    //Setting this text to null before loop
    document.getElementById("check_delete_case").innerHTML = "";

    //Compare potential username with all taken usernames
    for(var i = 0; i <= passed_array.length; i++){
        document.getElementById("delete_case_btn").style.display='none';
        document.getElementById("check_delete_case").innerHTML = "Case Does Not Exist";
        
        //Case num matches case and field is selected
        if(case_num == passed_array[i]["case_num"]){
            document.getElementById("delete_case_btn").style.display='block';
            document.getElementById("check_delete_case").innerHTML = "";
            break;
        } 
    }
}

//Function to ensure unique addtions of drugs to DB
function test_drug_name(){
    //Revieve drug name array from php
    var passed_array = <?php echo json_encode($drugs); ?>;

    //Revieve users drug name
    var new_drug_name = document.getElementById('drug_name').value;

    //Reset button and warning text
    document.getElementById("drug_name_confirm").innerHTML = "";
    document.getElementById("add_drug_btn").style.display='block';

    //Loop to compare user name to all names in DB
    for(var i = 0; i<= passed_array.length; i++){
        if(passed_array[i]['name'] == new_drug_name.ucwords()){
            document.getElementById("drug_name_confirm").innerHTML = "This drug already exists, try edit drug";
            document.getElementById("add_drug_btn").style.display='none';
        }
    }
}

//Function to ensure only editing of existing drugs
function test_drug_edit(){
    //Recieve drug name array from PHP
    var passed_array = <?php echo json_encode($drugs); ?>;

    //Revieve users drug name
    var edit_drug_name = document.getElementById('edit_drug_name').value;

    //Reset button and warning text
    document.getElementById("check_drug").innerHTML = "Drug doesn't exist, add drug before editing";
    document.getElementById("edit_drug_btn").style.display='none';

    //Loop to compare user name to all names in DB
    for(var i = 0; i<= passed_array.length; i++){
        if(passed_array[i]['name'] == edit_drug_name.ucwords()){
            document.getElementById("check_drug").innerHTML = "";
            document.getElementById("edit_drug_btn").style.display='block';
            break;
        }
    }
}

//Function to preform php's ucwords function
String.prototype.ucwords = function() {
    str = this.toLowerCase();
    return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
        function($1){
            return $1.toUpperCase();
        });
}

//Slideshow JS
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 7000); // Change image every 2 seconds
}
</script>
</html>