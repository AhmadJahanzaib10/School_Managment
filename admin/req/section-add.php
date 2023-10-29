<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

    if (isset($_POST['section'])){

    include '../../DB_connection.php';
    include "../data/section.php";

    $section = $_POST['section'];


    $data = 'section='.$section;

    if (empty($section)) {
        $em  = "Section is required";
        header("Location: ../section-add.php?error=$em&$data");
        exit;
    }else{
        $sql = "INSERT INTO section(section) 
                VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$section]);
        $sm = "New Section registered successfully!.";
        header("location: ../section-add.php?success=$sm");
        exit;                
    }

        }else{ 
            $em = "An error Occurred";
            header("location: ../section-add.php?error=$em");
            exit;
            }
    }else{
        header("location: ../../logout.php");
        exit;
        } 
}else{
    header("location: ../../logout.php");
    exit;
    } 