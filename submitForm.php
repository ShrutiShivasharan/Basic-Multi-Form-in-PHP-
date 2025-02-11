<?php
include('./connection.php');

if($_SERVER['REQUEST_METHOD'] === "POST"){
    // $name = mysqli_real_escape_string($con, $_POST['name']);
    // $email = mysqli_real_escape_string($con, $_POST['email']);
    // $password = mysqli_real_escape_string($con, $_POST['password']);
    // $phone = mysqli_real_escape_string($con, $_POST['phone']);
    // $address = mysqli_real_escape_string($con, $_POST['address']);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `user`(`name`, `email`, `password`, `phone`, `address`) VALUES ('$name', '$email', '$hashPassword', '$phone', '$address')";
    if(mysqli_query($con, $sql)){
        echo "form submitted!!";
    }else{
        echo "form not submitted!!".mysqli_error($con);
    }
}

?>
