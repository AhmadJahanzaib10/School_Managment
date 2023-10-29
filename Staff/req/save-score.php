<?php
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') { 

if (isset($_POST['score-1'])      &&
    isset($_POST['score-2'])      &&
    isset($_POST['score-3'])      &&
    isset($_POST['score-4'])      &&
    isset($_POST['score-5'])      &&
    isset($_POST['aoutof-1'])     &&
    isset($_POST['aoutof-2'])     &&
    isset($_POST['aoutof-3'])     &&
    isset($_POST['aoutof-4'])     &&
    isset($_POST['aoutof-5'])     &&
    isset($_POST['student_id'])     &&
    isset($_POST['subject_id'])     &&
    isset($_POST['current_semester'])     &&
    isset($_POST['current_year'])) {

    include '../../DB_connection.php';

    $score_1 = $_POST['score-1'];
    $score_2 = $_POST['score-2'];
    $score_3 = $_POST['score-3'];
    $score_4 = $_POST['score-4'];
    $score_5 = $_POST['score-5'];
    $aoutof_1 = $_POST['aoutof-1'];
    $aoutof_2 = $_POST['aoutof-2'];
    $aoutof_3 = $_POST['aoutof-3'];
    $aoutof_4 = $_POST['aoutof-4'];
    $aoutof_5 = $_POST['aoutof-5'];

    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $current_semester = $_POST['current_semester'];
    $current_year = $_POST['current_year'];
    $staff_id = $_SESSION['staff_id'];

    if (empty($score_1)  || empty($score_2)  || empty($score_3)  || empty($score_4)  || empty($score_5)    || empty($aoutof_1)   || 
        empty($aoutof_2) || empty($aoutof_3) || empty($aoutof_4) || empty($aoutof_5) || empty($student_id) || empty($subject_id) || 
        empty($current_semester)             || empty($current_year)) {
        

        $em  = "All fields are required";
        header("Location: ../student-grade.php?student_id=$student_id&error=$em");
        exit;

    }else{
        $data = '';
        $limit = 0;
        if ($score_1 <= 100 && $aoutof_1 <=100 && $score_1 > 0 && $aoutof_1 > 0 && $score_1 <=  $aoutof_1)  {
            $data .= $score_1." ".$aoutof_1; 
             $limit += $aoutof_1;
        } 
        if($score_2 <= 100 && $aoutof_2 <=100 && $score_2 > 0 && $aoutof_2 > 0 && $score_2 <=  $aoutof_2){
           $data .= ",".$score_2." ".$aoutof_2;
           $limit += $aoutof_2;
        }
        if($score_3 <= 100 && $aoutof_3 <=100 && $score_3 > 0 && $aoutof_3 > 0 && $score_3 <=  $aoutof_3){
           $data .= ",".$score_3." ".$aoutof_3;
           $limit += $aoutof_3;
        } 
        if($score_4 <= 100 && $aoutof_4 <=100 && $score_4 > 0 && $aoutof_4 > 0 && $score_4 <=  $aoutof_4){
           $data .= ",".$score_4." ".$aoutof_4;
           $limit += $aoutof_4;
        }
        if($score_5 <= 100 && $aoutof_5 <=100 && $score_5 > 0 && $aoutof_5 > 0 && $score_5 <=  $aoutof_5){
           $data .= ",".$score_5." ".$aoutof_5;
           $limit += $aoutof_5;
        }

        if (empty($data)) {
            $em  = "An error occurred";
            header("Location: ../student-grade.php?student_id=$student_id&error=$em");
        exit;
        }else if($limit > 100){
            $em  = "Out of boundaries";
            header("Location: ../student-grade.php?student_id=$student_id&error=$em");
        }
        else {
        if (isset($_POST['student_score_id'])) {
            $sql = "UPDATE student_score SET
                    results = ?
                    WHERE  semester=?
                    AND year=? AND student_id=? AND staff_id=? AND subject_id=?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$data, $current_semester, $current_year, $student_id, $staff_id, $subject_id]);
            $sm = "The Score has been updated successfully!";
            header("Location: ../student-grade.php?student_id=$student_id&success=$sm");
        exit;
          }else {
             $sql = "INSERT INTO student_score(semester, year, student_id, staff_id, subject_id, results)VALUES(?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$current_semester, $current_year, $student_id, $staff_id, $subject_id, $data]);
        $sm = "The Score has been created successfully!";
        header("Location: ../student-grade.php?student_id=$student_id&success=$sm");
          }
        }

    }
    
  }else {
    $em = "An error occurred";
    header("Location: ../classes.php?error=$em");
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