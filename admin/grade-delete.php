<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['grade_id'])){

    if ($_SESSION['role'] == 'Admin') { 
        include "../DB_connection.php";
        include "data/grade.php";
        
        $id = $_GET['grade_id'];
        if (removeGrade($id, $conn)) {
        $sm = "Successfully deleted!.";
        header("location: grade.php?success=$sm");
        exit;   
        }else{
        $em = "UnnKnown error occurred";
        header("location: grade.php?error=$sm");
        exit;  
        }


    }else{
        header("location: grade.php");
        exit;
    } 
}else{
    header("location: grade.php");
    exit;
} 