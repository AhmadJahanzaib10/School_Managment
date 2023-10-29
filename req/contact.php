<?php 
    if (isset($_POST['email']) &&
        isset($_POST['full_name']) &&
        isset($_POST['message'])) {

    include "../DB_connection.php";
    
    $email      = $_POST['email'];
    $full_name  = $_POST['full_name'];
    $message    = $_POST['message'];

    if (empty($email)) {
        $em  = "Email is required.";
        header("Location: ../index.php?error=$em#contact");
        exit;
    }else if (empty($full_name)) {
        $em  = "Your full name is required.";
        header("Location: ../index.php?error=$em#contact");
        exit;
    }else if (empty($message)) {
        $em  = "Write a message to send please.";
        header("Location: ../index.php?error=$em#contact");
        exit;
    }else{    
        $sql = "INSERT INTO message(sender_full_name,send_email,message) 
                VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name,$email,$message]);
        $sm = "New message successfully sent!.";
        header("location: ../index.php?success=$sm#contact");
        exit;
    }
}else{
    header("location: ../index.php");
    exit; 
}

 ?>