<?php
    $image = $_COOKIE["firstimage"]; 
    $image1 = $_COOKIE["image0"];
    $image2 = $_COOKIE["image1"];
    $image3 = $_COOKIE["image2"];

    echo $image . "<br>";
    echo $image0 . "<br>";
    echo $image1 . "<br>";
    echo $image2 . "<br>";
?>


<html>
<head>
<title>Case Search</title>
<a href="../index.php">Back To Home</a>

</head>

<body>
    <!-- Form to get field and query for search -->
    <form action='case_search.php' method='POST' id="select_form">
        <p>Field to Query:</p>
        <select name='field_to_search' id='search_select' onchange="myfunction(value)">
            <option value=name selected>Name</option>
            <option value=species>Species</options>
            <option value=breed>Breed</options>
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
            <p><input type="text" name="text_query" onchange="text_btn_display(value)"></input></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
        </div>

        <div id="number_hideaway" style="display:none;">
            <p><input type="number" name="num_query" onchange="num_btn_display(value)"></input></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
        </div>

        <div id="textarea_hideaway" style="display:none;">
            <p><textarea rows="8" cols="50" placeholder="Type query here" name="textarea_query" onchange="text_area_btn_display(value)">test</textarea></p>
            <p><button id='search_button' type='submit' value='submit'>Search For Case</button></p>
            <p>test</p>
        </div>

    </form>
    



</body>

<script type = "text/javascript">
    //Script to hide input boxes that arn't going to be used. 
    function myfunction(value){
        document.getElementById('text_hideaway').style.display='none';
        document.getElementById('number_hideaway').style.display='none';
        document.getElementById('textarea_hideaway').style.display='none';


        if(value == "name" || value == "species" || value == "breed" || value == "sex" || value == "drug"){
            document.getElementById('text_hideaway').style.display='block';
          //  document.getElementById('search_button').style.display='block';
        }

        if(value == "age" || value == "weight" || value == "chip_num"){
            document.getElementById('number_hideaway').style.display='block';
         //   document.getElementById('num_search_button').style.display='block';
        }

        if(value == "symptoms" || value == "diagnosis" || value == "treatment"){
            document.getElementById('textarea_hideaway').style.display='block';
        }
    }

    //Script to make buttons appear
    function text_btn_display(value){
      //  if(!is_null(value)){
            document.getElementById('search_button').style.display='block';
      //  }
    }

    function num_btn_display(value){
      //  if(!is_null(value)){
            document.getElementById('num_search_button').style.display='block';
      //  }
    }

    function text_area_btn_display(value){
      //  if(!is_null(value)){
            document.getElementById('text_search_button').style.display='block';
      //  }
    }
</script>

</html>