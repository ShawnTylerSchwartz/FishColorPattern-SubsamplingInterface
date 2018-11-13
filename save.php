<?php
//save.php code

function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

$randomFileName = generateRandomString();
$fileName = "$randomFileName.png";
//Get the base-64 string from data
$filteredData=substr($_POST['data'], strpos($_POST['data'], ",")+1);
//Decode the string
$unencodedData=base64_decode($filteredData);
//Save the image
file_put_contents($fileName, $unencodedData);

echo json_encode($fileName);

?>