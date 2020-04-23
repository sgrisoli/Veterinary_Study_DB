<?php
foreach($_COOKIE as $key => $value)
    unset($_COOKIE[$key]);

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
<title>Image upload test</title>
</head>
<body>

</body>


</html>
