<?php

include 'config.php';

if (isset($_POST['submit'])) {

    // fetching data and storing to db

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    

    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn,md5($_POST['cpassword']));

    
    $user_type = $_POST['user_type'];

    // checking of user existence on db

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email' AND password='$pass'  ") or die('query Failed');

    if (mysqli_num_rows($select_users) > 0) {
        //if user exists
        $message[] = 'user already exists!';
    } else {

        // check password is same
        if ($pass != $cpass) {
            $message[] = 'confirm password not matched';
        } else {
            // if user doesn't exist

            mysqli_query($conn, "INSERT INTO `users` (name,email,password,user_type) VALUES('$name','$email','$pass','$user_type') ") or die("query Failed");

            $message[] = "registered successfully!!";
            header('Location:login.php');

        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link -->

    <link rel="stylesheet" href="css/style.css">

</head>

<body>



<!-- fetch/display messages fon register or an error -->
<?php
    if(isset($message)){
        foreach($message as $message){

            // <!-- message handler -->
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            
            
            ';
        }
    }

?>

    <div class="form-container">
        <form action="" method="post">
            <h3>Register Now!!</h3>
            <input type="text" name="name" id="" placeholder="Enter Your name:" required class="box">
            <input type="email" name="email" id="" placeholder="Enter Your email:" required class="box">
            <input type="password" name="password" id="" placeholder="Enter Your password:" required class="box"><input type="password" name="cpassword" id="" placeholder="Confirm your Password:" required class="box">

            <select name="user_type" id="" class="box">
                <option value="user">User</option>
                <option value="admin">admin</option>
            </select>

            <input type="submit" value="register now" name="submit" class="btn">
            <p>Already have an account? <a href="login.php">login now</a></p>
        </form>
    </div>

</body>

</html>