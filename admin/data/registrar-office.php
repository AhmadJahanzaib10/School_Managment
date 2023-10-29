<?php 

function getR_usersById($r_user_id, $conn){
	$sql = "SELECT * FROM registrar_office WHERE r_user_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$r_user_id]);

	if ($stmt->rowCount() == 1) {
		$staff = $stmt->fetch();
		return $staff;
	}else{
		return 0;
	}
}

function getAllR_users($conn){
	$sql = "SELECT * FROM registrar_office";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() >= 1) {
		$staff = $stmt->fetchAll();
		return $staff;
	}else{
		return 0;
	}
}

function userIdIsUniqe($id, $conn, $staff_id = 0){
	$sql  = "SELECT staff_id FROM staff WHERE staff_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

	if ($staff_id == 0) {
		if ($stmt->rowCount() >= 1) {
			return 0;
		}else{
			return 1;
		}
	}else {
		if ($stmt->rowCount() >= 1) {
			$staff = $stmt ->fetch();
			if ($staff['staff_id'] == $staff_id) {
				return 1;
			}else{
				return 0;
			}
		}else{
			return 1;
		}
	}


}

function removeR_user($id, $conn){
	$sql= "DELETE FROM registrar_office WHERE r_user_id=?";
	$stmt= $conn->prepare($sql);
	$re= $stmt->execute([$id]);

	if ($re) {
		return 1;
	}else{
		return 0;
	}
}
?>