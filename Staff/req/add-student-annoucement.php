<?php
session_start();
//print_r($_POST);die;
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') { 

if (isset($_POST['grade_id'])      &&
    isset($_POST['section_id'])      &&
    isset($_POST['anno_start_date'])      &&
    isset($_POST['anno_end_date'])      &&
    isset($_POST['anno_message'])) {

    include '../../DB_connection.php';

    $staff_id = $_SESSION['staff_id'];
    $grade_id = $_POST['grade_id'];
    $section_id = $_POST['section_id'];
    $subject_id = $_POST['subject_id'];
    $anno_start_date = $_POST['anno_start_date'];
    $anno_end_date = $_POST['anno_end_date'];
    $anno_message = $_POST['anno_message'];
    //print_r($_POST);die;
    //print_r($attendance_status);
    //print_r($student_id);

      
        $sql = "INSERT INTO annoucement (staff_id, grade_id, section_id, subject_id, anno_message, anno_start_date, anno_end_date)VALUES(?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$staff_id, $grade_id, $section_id, $subject_id, $anno_message, $anno_start_date, $anno_end_date]);
        $sm = "The annoucement has been created successfully!";
        //header("Location: ../student-attendance.php?student_id=$student_id&success=$sm");
        header("Location: ../student_annoucement_view.php?grade_id=$grade_id&section_id=$section_id&success=$sm");
    
  }else {
    $em = "An error occurred";
    header("Location: ../student_annoucement_view.php?grade_id=$grade_id&section_id=$section_id&error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
    header("Location: ../../logout.php");
    exit;
} 