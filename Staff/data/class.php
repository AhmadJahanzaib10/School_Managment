<?php 

function getAllClasses($conn){
	$sql = "SELECT * FROM classes";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() >= 1) {
		$classes = $stmt->fetchAll();
		return $classes;
	}else{
		return 0;
	}
}

function getclassesById($class_id, $conn){
	$sql = "SELECT * FROM classes WHERE class_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$class_id]);

	if ($stmt->rowCount() == 1) {
		$classes = $stmt->fetch();
		return $classes;
	}else{
		return 0;
	}
}
function removeclass($id, $conn){
  $sql= "DELETE FROM classes WHERE class_id=?";
  $stmt= $conn->prepare($sql);
  $re= $stmt->execute([$id]);

  if ($re) {
    return 1;
  }else{
    return 0;
  }
}
 ?>