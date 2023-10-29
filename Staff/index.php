<?php 
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') {    
    	include "../DB_connection.php";
    	include "data/teacher.php";
    	include "data/class.php";
    	include "data/grade.php";
    	include "data/subject.php";
    	include "data/section.php";

    	$staff_id = $_SESSION['staff_id'];
    	$staff 	= getTeachersById($staff_id, $conn);    	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";
		
		if ($staff != 0) {
	 ?>
	<div class="container mt-5">	 		
			<div class="card" style="width: 22rem;">
			  <img src="../img/teacher-<?=$staff['gender']?>.png" class="card-img-top" alt="...">	
			  <div class="card-body">
			    <h5 class="card-title text-center">@<?= $staff['fname'];?> <?= $staff['staff_id'];?></h5>
			  </div>
			  	<ul class="list-group list-group-flush">
			    <li class="list-group-item">First name: 			<?= $staff['fname'];?></li>
			    <li class="list-group-item">Last name: 				<?= $staff['lname'];?></li>
			    <li class="list-group-item">Username: 				<?= $staff['username'];?></li>
			    <li class="list-group-item">Phone number: 			<?= $staff['phone'];?></li>
			    <li class="list-group-item">Address: 				<?= $staff['address'];?></li>
			    <li class="list-group-item">Gender: 				<?= $staff['gender'];?></li>
			    <li class="list-group-item">Email address: 			<?= $staff['email_address'];?></li>
			    <li class="list-group-item">Date of birth: 			<?= $staff['date_of_birth'];?></li>
			    <li class="list-group-item">Qualification: 			<?= $staff['qualification'];?></li>
			    <li class="list-group-item">Data of joined: 		<?= $staff['data_of_joined'];?></li>
			    <li class="list-group-item">Subject:
			      	<?php 
			      		$s = '';
			      		$subjects = str_split(trim($staff['subjects']));
			      		foreach ($subjects as $subject) {
			      			$s_temp = getSubjectsById($subject, $conn);
			      			if ($s_temp != 0) 
			      				$s .=$s_temp['subject_code'].', ';	
			      		}
			      		echo $s;
			      	 ?>	    	
			    </li>
			    <li class="list-group-item">Class:
			      	<?php 
			      		$c = '';
			      		$classes = str_split(trim($staff['class']));
			      		foreach ($classes as $class_id) {
			      			$class = getclassesById($class_id, $conn);
			      			$c_temp = getGradeById($class['grade'], $conn);
			      			$section = getSectionById($class['section'],$conn);
			      			if ($c_temp != 0) 
			      				$c .=$c_temp['grade'].'-'.$c_temp['grade_code'].' '.$section['section'].', ';	
			      		}
			      		echo $c;
			      	 ?>	    	
			    </li>			    			    			    
			  </ul>
			</div>			
	</div>

	<?php 
		}else{
			header("location: logout.php?error=An error occurred");
        	exit;
		}
	 ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
	$(document).ready(function(){
		$("#navLinks li:nth-child(1) a").addClass('active');
		  });
	</script>

</body>
</html>
<?php 
    }else{
        header("location: ../login.php");
        exit;
    } 
}else{
    header("location: ../login.php");
    exit;
} 
?>
