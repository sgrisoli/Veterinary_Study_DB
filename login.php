<?php
    //DB connection
    $dir = getcwd();
    $db = new SQLite3($dir . "/vet_case_study.db");
    //$db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');
    
    //Query to get all usernames for comparison
    $res = $db->query('SELECT username FROM accounts');
    
    //Saving all usernames to multidimentional array
    $data = array();
    while($row = $res->fetchArray()){
        $data[] = $row;
    }
    //Resaving all usernames as simple array
    $arr_to_send = array();
    for($i=0; $i<=count($data); $i++){
        $arr_to_send[] = $data[$i][0];
    }
?>
<?php
    //Getting variables from create account form
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    //Ensureing proper input
    if(!is_null($user) && !is_null($pass)){
        $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

        $stm = $db->prepare('INSERT into accounts VALUES (?,?)');
        $stm->bindParam(1,$user);
        $stm->bindParam(2,$pass);
        if(!$stm->execute()){
            echo "Was not able to create account";
        }
    }
?>
<?php
    session_start();
    //Validating login credentials
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];

    //Sending the field to the next page
    $_SESSION['uname'] = $uname;

    //DB connection
    $db = new SQLite3('/Users/stephengrisoli/Desktop/vet_case_db/vet_case_study.db');

    //Query to get all usernames and passwords for comparison
    $res = $db->query('SELECT * FROM accounts');
        
    //Saving all usernames and passwords to multidimentional array
    $data = array();
    while($row = $res->fetchArray()){
        $data[] = $row;
    }

    //Testing username and password combo against all in db
    if(!is_null($uname) && !is_null($psw)){
        for($i=0; $i<=count($data); $i++){
            if(($uname == $data[$i][0]) && ($psw == $data[$i][1])){
                $flag = TRUE;
                header("Location: index.php");
                break;
            }
        }
        if(!$flag){
            echo "Username and Password don't match!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles/styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h2>Veterinary Case Database Login Form</h2>

<!-- Login Modal-->
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

<div id="id01" class="modal">

  <form class="modal-content animate" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit">Login</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<!-- Create Account Modal -->
<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Create Account</button>

<div id="id02" class="modal">
  
  <form class="modal-content animate" autocomplete="off" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Create Username</b></label>
      <input style="text-transform: lowercase" type="text" placeholder="Enter Username" name="user" id="user" onkeyup="testUser()" required>
      <p id='taken'></p>
      <p id='not_taken'></p>



      <label for="psw"><b>Create Password</b></label>
      <input type="password" placeholder="Enter Password" name="pass" id='pass' required>
      <input type="checkbox" onclick="showPass()">Show Password
     
      <button type="submit" id="create_acc_btn">Create Account</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>
<script>

//Get the modal
var login_modal = document.getElementById('id01');
var create_modal = document.getElementById('id02');


//Function to close window if they click outside of it
window.onclick = function(event) {
    if (event.target == login_modal) {
        login_modal.style.display = "none";
    }
    if (event.target == create_modal){
       create_modal.style.display = "none";
    }
}


//Function to show password in plain text
function showPass() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

//Function to check if username already exists
function testUser(){
    //Recieve array from php
    var passed_array = <?php echo json_encode($arr_to_send); ?>;
    //Get value user has typed into username filed
    var current_user = document.getElementById("user").value;
             
    //Compare potential username with all taken usernames
    for(var i = 0; i <= passed_array.length; i++){
        document.getElementById("taken").innerHTML = "";  
        document.getElementById("create_acc_btn").style.display='block';
        if(current_user == passed_array[i]){
            document.getElementById("taken").innerHTML = "This username is already taken";
            document.getElementById("create_acc_btn").style.display='none';
            break;
        }
    }
}
</script>
</body>
</html>