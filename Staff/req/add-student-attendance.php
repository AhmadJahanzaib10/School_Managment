<?php
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') { 

if (isset($_POST['staff_id'])      &&
    isset($_POST['class_id'])      &&
    isset($_POST['ssubject_id'])      &&
    isset($_POST['student_id'])) {

    include '../../DB_connection.php';

    $staff_id = $_POST['staff_id'];
    $class_id = $_POST['class_id'];
    $ssubject_id = $_POST['ssubject_id'];
    $student_id = $_POST['student_id'];
    $attendance_status = $_POST['attandance_status'];
    $attendance_id = $_POST['attendance_id'];
    //print_r($attendance_status);die();
    //print_r($student_id);die();

        /*if (empty($attendance_status)) {
            $em  = "An error occurred";
            header("Location: ../student-attendance.php?class_id=$class_id&error=$em");
        exit;
        }else{*/

          if(isset($_REQUEST['btn_submit'])){
            $check = 0;
          $sql = "SELECT * FROM `attendance` WHERE subject_id = '".$ssubject_id."' AND CAST(date AS DATE) = '".date("Y-m-d")."'";
          $rs = $conn->query($sql);

          if ($rs->rowCount() > 0) {
            $count = 0;
          //if(isset($_REQUEST['Update'])){
            //for($i = 0; $i < count($_REQUEST['attendance_id']); $i++){
              while($rw = $rs->fetch(PDO::FETCH_OBJ)){
              //$strQry = "UPDATE attendance SET attendance_status = '".$attendance_status[$student_id[$i]]."' WHERE attendance_id=" . $_REQUEST['attendance_id'][$i];
              $strQry = "UPDATE attendance SET attendance_status = '".$attendance_status[$student_id[$count]]."' WHERE attendance_id=" . $rw->attendance_id;
              $conn->query($strQry);
              $count++;
              $check = 1;
            }
            $sm = "The attendance has been updated successfully!";
          } else{

            for($i = 0; $i < count($_POST['attandance_status']); $i++){
              $sql = "INSERT INTO attendance(attendance_status, student_id, staff_id, subject_id, class_id)VALUES(?,?,?,?,?)";
              $stmt = $conn->prepare($sql);
              $stmt->execute([$attendance_status[$student_id[$i]], $student_id[$i], $staff_id, $ssubject_id, $class_id]);
              $check = 1;
            }
            $sm = "The attendance has been created successfully!";
          }
          
        /*$sql = "INSERT INTO attendance(attendance_status, student_id, staff_id, subject_id, class_id)VALUES(?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$attendance_status, $student_id, $staff_id, $ssubject_id, $class_id]);*/
        if($check == 0){
          header("Location: ../student-attendance.php?class_id=$class_id&ssubject_id=$ssubject_id");
        } else {
          header("Location: ../student-attendance.php?class_id=$class_id&ssubject_id=$ssubject_id&success=$sm");
        }
          } else {
            header("Location: ../student-attendance.php?class_id=$class_id&ssubject_id=$ssubject_id");
          }
          //}
    
  }else {
    $em = "An error occurred";
    header("Location: ../student-attendance.php?error=$em");
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