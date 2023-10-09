<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    //get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username_email){
        $_SESSION['signin'] = "Username or Email Required";
    }
    elseif (!$password) {
        $_SESSION['signin'] = "Password Required";
    }
    else {
        //fetch user from database
        $fetch_user_query = "SELECT * FROM user WHERE username = '$username_email' OR email = '$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_result) == 1){
            //convert the record inti assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            //compare from password with database password
            if(password_verify($password, $db_password)){
                //set session for access control
                $_SESSION['user-id'] = $user_record['id'];
                //set session if user is admin
                if($user_record['is_admin'] == 1){
                    $_SESSION['user_is_admin'] = true;
                }

                //log user in
                header('location: ' . ROOT_URL . 'user_index.php');
            }
            else {
                $_SESSION['signin'] = "Please check your input";
            }
        }
        else {
            $_SESSION['signin'] = "User Not Found";
        }
    }
    //if any problem redirect back to signin page with login data
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL. 'signin.php');
        die();
    }
}
else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}