<?php

include 'config.php';

if (isset($_POST['submit'])) {

    // fetching data and storing to db

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    // $user_type=$_POST['user_type'];
    // checking of user existence on db

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email' AND password='$pass'  ") or die('query Failed');

    if (mysqli_num_rows($select_users) > 0) {
        // fetch data from db 
        $row = mysqli_fetch_assoc($select_users);

        // select diff user acconts

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');

           


        }elseif($row['user_type']== 'user'){
            $_SESSION['user_name']=$row['name'];
            $_SESSION['user_email']=$row['email'];
            $_SESSION['user_id']=$row['id'];
            header('location:home.php');

        }
        

    } else {
        $message[] = 'incorrect email or password!!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link -->

    <link rel="stylesheet" href="css/style.css">

</head>

<body>



    <!-- fetch/display messages fon register or an error -->
    <?php
    if (isset($message)) {
        foreach ($message as $message) {

            // <!-- message handler -->
            echo '
            <div class="message">
                <span>' . $message . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            
            
            ';
        }
    }

    ?>

    <div class="form-container">
        <form action="" method="post">
            <h3>Login Now!!</h3>

            <input type="email" name="email" id="" placeholder="Enter Your email:" required class="box">
            <input type="password" name="password" id="" placeholder="Enter Your password:" required class="box">

            <input type="submit" value="login now" name="submit" class="btn">
            <p>Don't have an account? <a href="register.php">register now</a></p>
        </form>
    </div>

</body>

</html>