<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

    if (isset($_POST['course_name']) &&
        isset($_POST['course_code']) && 
        isset($_POST['grade'])){

    include '../../DB_connection.php';
    include "../data/subject.php";

    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $grade       = $_POST['grade'];


    $data = 'course_name='.$course_name;

    if (empty($course_name)) {
        $em  = "Course name is required";
        header("Location: ../course-add.php?error=$em&$data");
        exit;
    }elseif (empty($course_code)) {
        $em  = "Course code is required";
        header("Location: ../course-add.php?error=$em&$data");
        exit;
    }elseif (empty($grade)) {
        $em  = "Grade is required";
        header("Location: ../course-add.php?error=$em&$data");
        exit;
    }else{
        $sql_check = "SELECT * FROM subjects WHERE grade=? AND subject_code=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$grade, $course_code]); 
        if ($stmt_check->rowCount() > 0) {
            $em = "The course is already exists";
            header("Location: ../course-add.php?error=$em");
            exit;
        }else{
            $sql = "INSERT INTO subjects(subject, subject_code, grade) 
                    VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$course_name, $course_code, $grade]);
            $sm = "New Course registered successfully!.";
            header("location: ../course-add.php?success=$sm");
            exit;    
        }
                        
    }

        }else{ 
            $em = "An error Occurred";
            header("location: ../course-add.php?error=$em");
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