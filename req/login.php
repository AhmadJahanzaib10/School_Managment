<?php
session_start();

if (isset($_POST['uname']) &&
    isset($_POST['pass']) &&
    isset($_POST['role'])) {

	include "../DB_connection.php";
	
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	$role = $_POST['role'];

	if (empty($uname)) {
		$em  = "ID is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($role)) {
		$em  = "An error Occurred";
		header("Location: ../login.php?error=$em");
		exit;
	}else{

		if ($role == '1') {
				$sql = "SELECT * FROM admins 
						WHERE admin_id = ?";
				$role = "Admin";
		}else if($role == '2'){
				$sql = "SELECT * FROM staff 
						WHERE staff_id = ?";
				$role = "Staff";
		}else if($role == '3'){
				$sql = "SELECT * FROM students 
						WHERE student_id = ?";
				$role = "Student";
		}else{
				$sql = "SELECT * FROM registrar_office 
						WHERE r_user_id = ?";
				$role = "Registrar Office";
		}	

		$stmt = $conn->prepare($sql);
		$stmt->execute([$uname]);

		if ($stmt->rowCount() == 1) {
			$user = $stmt->fetch();
			$username = $user['username'];
			$password = $user['password'];
			$id  = $user['r_user_id'];
			$id1 = $user['admin_id'];
			$id2 = $user['student_id'];
			$id3 = $user['staff_id'];

			if ($uname === $id || $uname === $id1 || $uname === $id2 || $uname === $id3) {
				if (password_verify($pass, $password)) {
					$_SESSION['role'] = $role;
					if ($role == 'Admin') {
					$id = $user['admin_id'];
					$_SESSION['admin_id'] = $id;					
					header("Location: ../admin/index.php");
					exit;
					}else if($role == 'Registrar Office') {
					$id = $user['r_user_id'];
					$_SESSION['r_user_id'] = $id;					
					header("Location: ../RegistrarOffice/index.php");
					exit;
					}else if($role == 'Staff') {
					$id = $user['staff_id'];
					$_SESSION['staff_id'] = $id;					
					header("Location: ../Staff/index.php");
					exit;
					}else if($role == 'Student') {
					$id = $user['student_id'];
					$_SESSION['student_id'] = $id;					
					header("Location: ../Student/index.php");
					exit;
					}else{
					$em  = "Incorrect ID or Password";
					header("Location: ../login.php?error=$em");
					exit;
					}

				}else{
					$em  = "Incorrect ID or Password";
					header("Location: ../login.php?error=$em");
					exit;
					}
			}else{
				$em  = "Incorrect ID or Password";
				header("Location: ../login.php?error=$em");
				exit;
				}

		}else{
			$em  = "Incorrect ID or Password";
			header("Location: ../login.php?error=$em");
			exit;
		}
	}

}else{
    header("location: ../login.php");
    exit; 
}