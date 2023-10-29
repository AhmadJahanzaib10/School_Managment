<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['section_id'])){

    if ($_SESSION['role'] == 'Admin') { 
        include "../DB_connection.php";
        include "data/section.php";
        
        $id = $_GET['section_id'];
        if (removeSection($id, $conn)) {
        $sm = "Successfully deleted!.";
        header("location: section.php?success=$sm");
        exit;   
        }else{
        $em = "UnKnown error occurred";
        header("location: section.php?error=$sm");
        exit;  
        }

    }else{ 
        header("location: section.php");
        exit;
    } 
}else{
    header("location: section.php");
    exit;
} 