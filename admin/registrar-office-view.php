<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 
    	include "../DB_connection.php";
    	include "data/registrar-office.php";

    	if(isset($_GET['r_user_id'])){

    	$r_user_id = $_GET['r_user_id'];
    	$r_user 		= getR_usersById($r_user_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Registrar Office</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";
		if ($r_user != 0) {
	 ?>
	<div class="container mt-5">	 		
			<div class="card" style="width: 22rem;">
			  <img src="../img/r_user_<?=$r_user['gender']?>.png" class="card-img-top" alt="...">	
			  <div class="card-body">
			    <h5 class="card-title text-center">@<?= $r_user['fname'];?> <?= $r_user['r_user_id'];?></h5>
			  </div>
			  <ul class="list-group list-group-flush">
			    <li class="list-group-item">First name: <?= $r_user['fname'];?></li>
			    <li class="list-group-item">Last name: <?= $r_user['lname'];?></li>
			    <li class="list-group-item">Phone number: <?= $r_user['phone_number'];?></li>
			    <li class="list-group-item">Address: <?= $r_user['address'];?></li>
			    <li class="list-group-item">Employee number: <?= $r_user['employee_number'];?></li>
			    <li class="list-group-item">Date of birth: <?= $r_user['date_of_birth'];?></li>
			    <li class="list-group-item">Qualification: <?= $r_user['qualification'];?></li>
			    <li class="list-group-item">Gender: <?= $r_user['username'];?></li>
			    <li class="list-group-item">Email address: <?= $r_user['email_address'];?></li>
			    <li class="list-group-item">Data of joined: <?= $r_user['data_of_join'];?></li>
			  </ul>
			  <div class="card-body">
				    <a href="registrar-office.php" 
		 	   		class="btn btn-dark">Go Back</a>
			  </div>
			</div>			
	</div>

	<?php 
		}else{
			header("location: registrar-office.php");
        	exit;
		}
	 ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
    	$(document).ready(function(){
    		$("#navLinks li:nth-child(7) a").addClass('active');
			  });
	</script>
</body>
</html>
<?php 
	    }else{
        	header("location: registrar-office.php");
        	exit;
    	}
    }else{
        header("location: ../login.php");
        exit;
    } 
}else{
    header("location: ../login.php");
    exit;
} 
?>
