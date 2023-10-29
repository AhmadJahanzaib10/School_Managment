<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

if (isset($_POST['admin_pass'])      &&
    isset($_POST['new_pass'])      &&
    isset($_POST['c_new_pass'])      &&
    isset($_POST['staff_id'])) {

    include '../../DB_connection.php';
    include "../data/teacher.php";
    include "../data/admin.php";


    $admin_pass = $_POST['admin_pass'];
    $new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];
    $staff_id = $_POST['staff_id'];

    $id = $_SESSION['admin_id'];

    $data = 'staff_id='.$staff_id.'#change_password';    

    if (empty($admin_pass)) {
        $em  = "Admin password is required";
        header("Location: ../teacher-edit.php?perror=$em&$data");
        exit;
    }else if (empty($new_pass)) {
        $em  = "New password is required";
        header("Location: ../teacher-edit.php?perror=$em&$data");
        exit;
    }else if (empty($c_new_pass)) {
        $em  = "Confirmation password is required";
        header("Location: ../teacher-edit.php?perror=$em&$data");
        exit;
    }else if ($new_pass !== $c_new_pass) {
        $em  = "New password and confirm password does not match.";
        header("Location: ../teacher-edit.php?perror=$em&$data");
        exit;
    }else if (!adminPasswordVerify($admin_pass, $conn, $id)) {
        $em  = "Incorrect admin password.";
        header("Location: ../teacher-edit.php?perror=$em&$data");
        exit;
    }else{
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);   	
        $sql = "UPDATE staff SET password=? WHERE staff_id=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$new_pass,$staff_id]);
        $sm = "The password has been successfully changed!";
        header("Location: ../teacher-edit.php?psuccess=$sm&$data");
        exit;            
    }

        }else{ 
            $em = "An error Occurred";
            header("Location: ../teacher-edit.php?error=$em&$data");
            exit;
            }
    }else{
        header("Location: ../../logout.php");
        exit;
        } 
}else{
    header("Location: ../../logout.php");
    exit;
    } 