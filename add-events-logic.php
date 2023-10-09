<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $startdate = filter_var($_POST['startdate'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $enddate = filter_var($_POST['enddate'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $location = filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $banner = $_FILES['banner'];


    //validate form data
    if(!$title){
        $_SESSION['add-events'] = "Enter Events Name";
    }
    elseif(!$startdate){
        $_SESSION['add-events'] = "Select Start Date";
    }
    elseif(!$enddate){
        $_SESSION['add-events'] = "Select End Date";
    }
    elseif(!$location){
        $_SESSION['add-events'] = "Choose Event Location";
    }
    elseif(!$category){
        $_SESSION['add-events'] = "Choose Category";
    }
    elseif(!$body){
        $_SESSION['add-events'] = "Write Event Description";
    }
    elseif(!$banner['name']){
        $_SESSION['add-events'] = "Choose Banner";
    }
    else {
        //work on thumbnail
        //rename the image
        $time = time(); //make each image name unique
        $banner_name = $time . $banner['name'];
        $banner_tmp_name = $banner['tmp_name'];
        $banner_destination_path = 'images/' . $banner_name;


        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $banner_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)){
            //make sure image is not too larg (2mb+)
            if($banner['size'] < 2_000_000) {
                move_uploaded_file($banner_tmp_name, $banner_destination_path);
            }
            else{
                $_SESSION['add-events'] = "file size is too big please upload less than 2mb";
            }
        }
        else {
            $_SESSION['add-events'] = "file should be png, jpg, jpeg";
        }
    }
    //redirect back (with form data) if there is any problem
    if(isset($_SESSION['add-events'])){
        $_SESSION['add-events-data'] = $_POST;
        header('location: ' . ROOT_URL . 'add-events.php');
        die();
    }
    else{
        //insert post into database
        $query = "INSERT INTO events (title, startdate, enddate, location, category, body, banner) VALUES ('$title', '$startdate', '$enddate', '$location', '$category', '$body', '$banner_name')";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)){
            $_SESSION['add-events-success'] = "New Event Added Successfully..";
            header('location: ' . ROOT_URL . 'user_index.php');
            die();
        }
    }
}
header('location: ' . ROOT_URL . 'user-index.php');
die();