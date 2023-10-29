<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

if (isset($_POST['fname'])      &&
    isset($_POST['lname'])      &&
    isset($_POST['uname'])      &&
    isset($_POST['pnumber'])    &&
    isset($_POST['address']) &&
    isset($_POST['employee_number']) &&
    isset($_POST['date_of_birth']) &&
    isset($_POST['qualification']) &&
    isset($_POST['gender']) &&
    isset($_POST['email_address']) &&
    isset($_POST['staff_id'])   &&
    isset($_POST['subjects'])   &&
    isset($_POST['classes'])) {

    include '../../DB_connection.php';
    include "../data/teacher.php";

    $fname =            $_POST['fname'];
    $lname =            $_POST['lname'];
    $uname =            $_POST['uname'];
    $pnumber =          $_POST['pnumber'];
    $staff_id =         $_POST['staff_id'];
    $pass =             $_POST['pass'];
    $address =          $_POST['address'];
    $employee_number =  $_POST['employee_number'];
    $date_of_birth =    $_POST['date_of_birth'];
    $qualification =    $_POST['qualification'];
    $gender =           $_POST['gender'];
    $email_address =    $_POST['email_address'];


    $classes = "";
    foreach ($_POST['classes'] as $class) {
        $classes .= $class;
    }

    $subjects = "";
    foreach ($_POST['subjects'] as $subject) {
        $subjects .= $subject;
    }  

    $data = 'staff_id='.$staff_id;    

    if (empty($fname)) {
        $em  = "First Name is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last Name is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($staff_id)) {
        $em  = "ID is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($pnumber)) {
        $em  = "Phone Number is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($employee_number)) {
        $em  = "Employee number is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date of birth is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($qualification)) {
        $em  = "Qualification is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Gender is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (empty($email_address)) {
        $em  = "Email address is required";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else if (!userIdIsUniqe($staff_id, $conn, $staff_id)) {
        $em  = "ID is taken, Please try again!.";
        header("Location: ../teacher-edit.php?error=$em&$data");
        exit;
    }else{
        $sql = "UPDATE staff SET fname=?, lname=?, phone=?, username=?, subjects=?, class=?,
                       employee_number=?, date_of_birth=?, qualification=?, gender=?, email_address=?, 
                       address=?
                       WHERE staff_id=?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        if ($stmt->execute([$fname, $lname, $pnumber, $uname, $subjects, $classes, $employee_number, $date_of_birth, $qualification, $gender, $email_address, $address, $staff_id])) {
            $sm = "Successfully updated!";
            header("Location: ../teacher-edit.php?success=$sm&$data");
            exit;
        } else {
            $em = "Update failed: " . $stmt->error;
            header("Location: ../teacher-edit.php?error=$em&$data");
            exit;
        }
            
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