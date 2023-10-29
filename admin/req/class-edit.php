<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['section']) &&
            isset($_POST['grade'])      &&
            isset($_POST['class_id'])
        ) {

            include '../../DB_connection.php';
            include "../data/class.php";

            $section = $_POST['section'];
            $grade      = $_POST['grade'];
            $class_id   = $_POST['class_id'];

            $data = 'class_id='.$class_id;


            if (empty($section)) {
                $em = "Section is required";
                header("Location: ../class-edit.php?error=$em&$data");
                exit;
            }else if (empty($grade)) {
                $em = "Grade is required";
                header("Location: ../class-edit.php?error=$em&$data");
                exit;
            }else if (empty($grade)) {
                $em = "Grade is required";
                header("Location: ../class-edit.php?error=$em&$data");
                exit;
            }else {
            
                $sql_check = "SELECT * FROM classes WHERE grade=? AND section=?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->execute([$grade, $section]);   
                if ($stmt_check->rowCount() > 0) {
                    $em  = "Class already exists";
                    header("Location: ../class-add.php?error=$em");
                    exit;
                }else{
                    $sql = "UPDATE classes SET section=?, grade=? WHERE class_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$section,$grade,$class_id]);
                    $sm = "Grade Updated successfully!.";
                    header("location: ../class-add.php?success=$sm&$data");
                    exit;  
                }
            }
        }else {
            $em = "An error Occurred";
            header("Location: ../class.php?error=$em&$data");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>
