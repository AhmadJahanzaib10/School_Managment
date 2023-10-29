<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

if (isset($_POST['fname'])    &&
    isset($_POST['lname'])    &&
    isset($_POST['uname'])    &&
    isset($_POST['id'])       &&
    isset($_POST['pnumber'])  &&
    isset($_POST['pass'])     &&
    isset($_POST['address']) &&
    isset($_POST['employee_number']) &&
    isset($_POST['date_of_birth']) &&
    isset($_POST['qualification']) &&
    isset($_POST['gender']) &&
    isset($_POST['email_address']) &&
    isset($_POST['subjects']) &&
    isset($_POST['classes'])) {

    include '../../DB_connection.php';
    include "../data/teacher.php";

    $fname =            $_POST['fname'];
    $lname =            $_POST['lname'];
    $uname =            $_POST['uname'];
    $id =               $_POST['id'];
    $pnumber =          $_POST['pnumber'];
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

    $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname.'&address='.$address.'&en='.$employee_number
           .'&pn='.$pnumber.'&qf='.$qualification.'&email='.$ea;       

    if (empty($fname)) {
        $em  = "First Name is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last Name is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($id)) {
        $em  = "ID is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($pnumber)) {
        $em  = "Phone Number is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($employee_number)) {
        $em  = "Employee number is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date of birth is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($qualification)) {
        $em  = "Qualification is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Gender is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($email_address)) {
        $em  = "Email address is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (!userIdIsUniqe($id, $conn)) {
        $em  = "ID is taken, Please try again!.";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO staff(fname, lname, phone, staff_id, password, class, username, subjects, address,employee_number, date_of_birth, qualification, gender, email_address) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fname,$lname,$pnumber,$id,$pass,$classes,$uname,$subjects,$address,$employee_number,$date_of_birth,$qualification,$gender,$email_address]);
        $sm = "New teacher registered successfully!.";
        header("location: ../teacher-add.php?success=$sm");
        exit;                
    }

        }else{ 
            $em = "An error Occurred";
            header("location: ../teacher-add.php?error=$em");
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