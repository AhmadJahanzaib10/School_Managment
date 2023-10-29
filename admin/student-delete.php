<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['student_id'])){

    if ($_SESSION['role'] == 'Admin') { 
        include "../DB_connection.php";
        include "data/student.php";
        
        $id = $_GET['student_id'];
        if (removeStudent($id, $conn)) {
        $sm = "Successfully deleted!.";
        header("location: student.php?success=$sm");
        exit;   
        }else{
        $em = "UnnKnown error occurred";
        header("location: student.php?error=$sm");
        exit;  
        }


    }else{
        header("location: student.php");
        exit;
    } 
}else{
    header("location: student.php");
    exit;
} 