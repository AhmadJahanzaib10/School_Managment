<?php 
function getAllMessages($conn){
	$sql = "SELECT * FROM message ORDER BY message_id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() >= 1) {
		$message = $stmt->fetchAll();
		return $message;
	}else{
		return 0;
	}
}


function removeMessage($id, $conn){
  $sql= "DELETE FROM message WHERE message_id=?";
  $stmt= $conn->prepare($sql);
  $re= $stmt->execute([$id]);

  if ($re) {
    return 1;
  }else{
    return 0;
  }
}