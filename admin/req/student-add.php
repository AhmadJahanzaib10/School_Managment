<?php
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 

if (isset($_POST['fname'])                  &&
    isset($_POST['lname'])                  &&
    isset($_POST['uname'])                  &&
    isset($_POST['id'])                     &&
    isset($_POST['pnumber'])                &&
    isset($_POST['email_address'])          &&
    isset($_POST['address'])                &&
    isset($_POST['date_of_birth'])          &&
    isset($_POST['gender'])                 &&
    isset($_POST['parent_first_name'])      &&
    isset($_POST['parent_last_name'])       &&
    isset($_POST['parent_phone_number'])    &&
    isset($_POST['section'])                &&
    isset($_POST['pass'])                   &&
    isset($_POST['grade'])) {

    include '../../DB_connection.php';
    include "../data/student.php";

    $fname                      = $_POST['fname'];
    $lname                      = $_POST['lname'];
    $uname                      = $_POST['uname'];
    $id                         = $_POST['id'];
    $pnumber                    = $_POST['pnumber'];
    $email_address              = $_POST['email_address'];
    $address                    = $_POST['address'];
    $date_of_birth              = $_POST['date_of_birth'];
    $gender                     = $_POST['gender'];
    $parent_first_name          = $_POST['parent_first_name'];
    $parent_last_name           = $_POST['parent_last_name'];
    $parent_phone_number        = $_POST['parent_phone_number'];
    $pass                       = $_POST['pass'];

    $grade      = $_POST['grade'];
    $section    = $_POST['section'];

    $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname;

    if (empty($fname)) {
        $em  = "First Name is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last Name is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($id)) {
        $em  = "ID is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($pnumber)) {
        $em  = "Phone Number is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (!IdIsUnique($id, $conn, $id)) {
        $em  = "ID is taken, Please try again!.";
        header("Location: ../student-add.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date of birth is required";
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
    }else if (empty($parent_first_name)) {
        $em  = "Parent first name is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($parent_last_name)) {
        $em  = "Parent last name number is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($parent_phone_number)) {
        $em  = "Parent phone number of birth is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else{
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO students(fname, lname, phone, student_id, password, username, grade, address,parent_fname, date_of_birth,parent_lname, gender, email_address,parent_phone_number,section) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fname,$lname,$pnumber,$id,$pass,$uname,$grade, $address, $parent_first_name,             
                        $date_of_birth,$parent_last_name, $gender, $email_address, $parent_phone_number, $section]);
        $sm = "New student registered successfully!.";
        header("location: ../student-add.php?success=$sm");
        exit;                
    }

        }else{ 
            $em = "An error Occurred";
            header("location: ../student-add.php?error=$em");
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