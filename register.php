<?php

require('connection.php');

$fname="";
$lname="";
$em="";
$em2="";
$password="";
$password2="";
$date="";      //sign up date
$error_array=""; //holds error msg

if(isset($_POST['register_button'])){
    $fname= strip_tags($_POST['reg_fname']); //remove html tags
    $fname= str_replace(' ','',$fname); //remove spaces
    $fname= ucfirst(strtolower($fname));//uppercase first letter
    
    $lname= strip_tags($_POST['reg_lname']); //remove html tags
    $lname= str_replace(' ','',$lname); //remove spaces
    $lname= ucfirst(strtolower($lname));//uppercase first letter

    $em= strip_tags($_POST['reg_email']); //remove html tags
    $em= str_replace(' ','',$em); //remove spaces
    $em= ucfirst(strtolower($em));//uppercase first letter
    
    $em2= strip_tags($_POST['reg_email2']); //remove html tags
    $em2= str_replace(' ','',$em2); //remove spaces
    $em2= ucfirst(strtolower($em2));//uppercase first letter

    $password= strip_tags($_POST['reg_password']); //remove html tags
    
    $password2= strip_tags($_POST['reg_password2']); //remove html tags

    $date=date("Y-m-d");

    if($em==$em2){
        //Check if email in valid format
        if(filter_var($em, FILTER_VALIDATE_EMAIL)){
            $em=filter_var($em, FILTER_VALIDATE_EMAIL);
        }
        else{
            echo "Invalid Format";
        }
    }
    else{
        echo "Emails do not match";
    }

   
    
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Social site</title>
</head>
<body>
    <form action="register.php" method="POST">
        <input type="text" name="reg_fname" placeholder="First Name" required>
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" required>
        <br>
        <input type="email" name="reg_email" placeholder="Email" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" required>
        <br>
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required>
        <br>
        <input type="submit" name="register_button" value="Register">
    </form>
    
</body>
</html>