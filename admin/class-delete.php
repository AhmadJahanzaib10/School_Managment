<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['class_id'])){

    if ($_SESSION['role'] == 'Admin') { 
        include "../DB_connection.php";
        include "data/class.php";
        
        $id = $_GET['class_id'];
        if (removeclass($id, $conn)) {
        $sm = "Successfully deleted!.";
        header("location: class.php?success=$sm");
        exit;   
        }else{
        $em = "UnnKnown error occurred";
        header("location: class.php?error=$sm");
        exit;  
        }


    }else{
        header("location: class.php");
        exit;
    } 
}else{
    header("location: class.php");
    exit;
} 