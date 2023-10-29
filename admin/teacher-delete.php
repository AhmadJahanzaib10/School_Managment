<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['staff_id'])){

    if ($_SESSION['role'] == 'Admin') { 
        include "../DB_connection.php";
        include "data/teacher.php";
        
        $id = $_GET['staff_id'];
        if (removeStaff($id, $conn)) {
        $sm = "Successfully deleted!.";
        header("location: teacher.php?success=$sm");
        exit;   
        }else{
        $em = "UnnKnown error occurred";
        header("location: teacher.php?error=$sm");
        exit;  
        }


    }else{
        header("location: teacher.php");
        exit;
    } 
}else{
    header("location: teacher.php");
    exit;
} 