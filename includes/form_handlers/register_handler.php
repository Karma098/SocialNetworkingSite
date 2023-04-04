<?php


$fname="";
$lname="";
$em="";
$em2="";
$password="";
$password2="";
$date="";      //sign up date
$error_array=array(); //holds error msg

if(isset($_POST['register_button'])){
    $fname= strip_tags($_POST['reg_fname']); //remove html tags
    $fname= str_replace(' ','',$fname); //remove spaces
    $fname= ucfirst(strtolower($fname));//uppercase first letter
    $_SESSION['reg_fname']=$fname;
    
    $lname= strip_tags($_POST['reg_lname']); //remove html tags
    $lname= str_replace('','',$lname); //remove spaces
    $lname= ucfirst(strtolower($lname));//uppercase first letter
    $_SESSION['reg_lname']=$lname;

    $em= strip_tags($_POST['reg_email']); //remove html tags
    $em= str_replace(' ','',$em); //remove spaces
    $_SESSION['reg_email']=$em;

    $em2= strip_tags($_POST['reg_email2']); //remove html tags
    $em2= str_replace(' ','',$em2); //remove spaces
    $_SESSION['reg_email2']=$em2;


    $password= strip_tags($_POST['reg_password']); //remove html tags
    
    $password2= strip_tags($_POST['reg_password2']); //remove html tags

    $date=date("Y-m-d");

    if($em==$em2){
        //Check if email in valid format
        if(filter_var($em, FILTER_VALIDATE_EMAIL)){
            $em=filter_var($em, FILTER_VALIDATE_EMAIL);
            $e_check=mysqli_query($con,"SELECT email FROM users WHERE email='$em'");
            // $e_check=mysqli_query($con,"SELECT `email` FROM `users` WHERE 'email'='$em'");

            $num_rows=mysqli_num_rows($e_check);
            if($num_rows>0){
                // echo "Email already exist";
                array_push($error_array,"Email already exist<br>");
            }
        }
        else{
            array_push($error_array,"Invalid Format<br>"); 
        }
    }
    else{
        array_push($error_array,"Email dont match<br>"); 
    }

    if(strlen($fname)>25 || strlen($fname)<2){
        array_push($error_array, "first name should be between 2 and 25<br>");
    }

    if(strlen($lname)>25 || strlen($lname)<2){
        array_push($error_array, "Last name should be between 2 and 25<br>");
    }

    if($password != $password2){
        array_push($error_array, "Your password do not match<br>");
    }
    else{
        if(preg_match('/[^A-Za-z0-9]/',$password)){
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }

    if(strlen($password)>30||strlen($password)<5){
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if(empty($error_array)){
        $password=md5($password);
        $username = strtolower($fname."_".$lname);
        $check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
        $i=0;
        while(mysqli_num_rows($check_username_query)!=0){
            $i++;
            $username=$username."_".$i;
            $check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
            
        }
        //profile picture assignment
        $rand=rand(1,2);
        if($rand==1){
            $profile_pic="assets\images\profile_pics\defaults\head_deep_blue.png";
        }
        else if($rand==2){
            $profile_pic="assets\images\profile_pics\defaults\head_emerald.png";
        }
        $query="INSERT INTO users  VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')";
        // $query="INSERT INTO `users`(`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES ('','$fname','$lname','$username',$em','$password','$date','$profile_pic','0','0','no',',')";
        $result = mysqli_query($con,$query);
        if($result){
            array_push($error_array,"<span style='color: #14C800'>You're all set go ahead and login!</span><br>");

        //Clear session variables
        $_SESSION['reg_fname']="";
        $_SESSION['reg_lname']="";
        $_SESSION['reg_email']="";
        $_SESSION['reg_email2']="";
        }
        else{
            echo "Cannot run query";
        }
    }
   
    
}

?>