<?php 
function getAllStudents($conn){
	$sql = "SELECT * FROM students";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() >= 1) {
		$students = $stmt->fetchAll();
		return $students;
	}else{
		return 0;
	}
}

function getAllStudentsbyattendance($conn, $subject_id){
	$sql = "SELECT stu.*, att.attendance_id, att.attendance_status FROM students AS stu LEFT OUTER JOIN attendance AS att ON att.student_id = stu.student_id AND CAST(att.date AS DATE) = '".date('Y-m-d')."'  AND att.subject_id = '".$subject_id."'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() >= 1) {
		$students = $stmt->fetchAll();
		return $students;
	}else{
		return 0;
	}
}


function getStudentById($id, $conn){
  $sql = "SELECT * FROM students WHERE student_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);

  if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    return $student;
  }else{
    return 0;
  }
}

// Check if the username Unique
function IdIsUnique($uname, $conn, $student_id=0){
   $sql = "SELECT username, student_id FROM students
           WHERE username=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$uname]);
   
   if ($student_id == 0) {
     if ($stmt->rowCount() >= 1) {
       return 0;
     }else {
      return 1;
     }
   }else {
    if ($stmt->rowCount() >= 1) {
       $student = $stmt->fetch();
       if ($student['student_id'] == $student_id) {
         return 1;
       }else {
        return 0;
      }
     }else {
      return 1;
     }
   }
   
}

function studentPasswordVerify($student_pass, $conn, $student_id){
  $sql = "SELECT * FROM students WHERE student_id =?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$student_id]);

  if ($stmt->rowCount() >= 1) {
    $admin = $stmt->fetch();
    $pass  = $admin['password'];
    if (password_verify($student_pass, $pass)) {
      return 1;
    }else{
      return 0;
    }
  }else{
    return 0;
  }
}
 
 ?>