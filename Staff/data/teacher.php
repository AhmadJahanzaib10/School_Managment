<?php 

function getTeachersById($staff_id, $conn){
	$sql = "SELECT * FROM staff WHERE staff_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$staff_id]);

	if ($stmt->rowCount() == 1) {
		$staff = $stmt->fetch();
		return $staff;
	}else{
		return 0;
	}
}

function TeacherPasswordVerify($staff_pass, $conn, $staff_id){
  $sql = "SELECT * FROM staff WHERE staff_id =?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$staff_id]);

  if ($stmt->rowCount() >= 1) {
    $admin = $stmt->fetch();
    $pass  = $admin['password'];
    if (password_verify($staff_pass, $pass)) {
      return 1;
    }else{
      return 0;
    }
  }else{
    return 0;
  }
}
?>