<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

if (isset($_POST['grade'])                  &&
    isset($_POST['section'])) {

    include '../../DB_connection.php';
    include "../data/student.php";

    $section   = $_POST['section'];
    $grade     = $_POST['grade'];


    $data = 'section='.$section.'&grade='.$grade;

    if (empty($section)) {
        $em  = "Section is required";
        header("Location: ../class-add.php?error=$em");
        exit;
    }else if (empty($grade)) {
        $em  = "Grade is required";
        header("Location: ../class-add.php?error=$em");
        exit;
    }else{
        $sql_check = "SELECT * FROM classes WHERE grade=? AND section=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$grade, $section]);   
        if ($stmt_check->rowCount() > 0) {
            $em  = "Class already exists";
            header("Location: ../class-add.php?error=$em");
            exit;
        }else{
            $sql = "INSERT INTO classes(grade, section) 
                    VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$grade,$section]);
            $sm = "New Class registered successfully!.";
            header("location: ../class-add.php?success=$sm");
            exit; 
        }       
    }
        }else{ 
            $em = "An error Occurred";
            header("location: ../class-add.php?error=$em");
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