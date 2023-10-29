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

function getAllTeachers($conn){
	$sql = "SELECT * FROM staff";
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

function removeStaff($id, $conn){
	$sql= "DELETE FROM staff WHERE staff_id=?";
	$stmt= $conn->prepare($sql);
	$re= $stmt->execute([$id]);

	if ($re) {
		return 1;
	}else{
		return 0;
	}
}

function searchTeachers($key, $conn){
	$key = "%{$key}%";
	$sql = "SELECT * FROM staff WHERE staff_id LIKE ?
								OR 	fname LIKE ?
								OR  lname LIKE ? 
								OR  phone LIKE ?
								OR  username LIKE ?
								OR 	subjects LIKE ?
								OR 	grades LIKE ?
								OR  section LIKE ? 
								OR  address LIKE ?
								OR  employee_number LIKE ?
								OR 	date_of_birth LIKE ?
								OR 	qualification LIKE ?
								OR  gender LIKE ? 
								OR  email_address LIKE ?
								OR  data_of_joined LIKE ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$key, $key, $key, $key, $key,$key, $key, $key, $key, $key,$key, $key, $key, $key, $key]);

	if ($stmt->rowCount() == 1) {
		$staffs = $stmt->fetchAll();
		return $staffs;
	}else{
		return 0;
	}
}