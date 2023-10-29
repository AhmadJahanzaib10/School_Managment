<?php 
session_start();
if (isset($_SESSION['r_user_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Registrar Office') { 
    	include "../DB_connection.php";
    	include "data/student.php";
    	include "data/subject.php";
    	include "data/grade.php";
    	include "data/section.php";

    	if(isset($_GET['student_id'])){

    	$student_id = $_GET['student_id'];
    	$student 	= getStudentById($student_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		if ($student != 0) {
	 ?>
	<div class="container mt-5">	 		
			<div class="card" style="width: 22rem;">
			  <img src="../img/student-<?=$student['gender']?>.png" class="card-img-top" alt="...">	
			  <div class="card-body">
			    <h5 class="card-title text-center">@<?= $student['fname'];?> <?= $student['student_id'];?></h5>
			  </div>
			  	<ul class="list-group list-group-flush">
			    <li class="list-group-item">First name: 			<?= $student['fname'];?></li>
			    <li class="list-group-item">Last name: 				<?= $student['lname'];?></li>
			    <li class="list-group-item">Username: 				<?= $student['username'];?></li>
			    <li class="list-group-item">Phone number: 			<?= $student['phone'];?></li>
			    <li class="list-group-item">Address: 				<?= $student['address'];?></li>
			    <li class="list-group-item">Gender: 				<?= $student['gender'];?></li>
			    <li class="list-group-item">Email address: 			<?= $student['email_address'];?></li>
			    <li class="list-group-item">Date of birth: 			<?= $student['date_of_birth'];?></li>
			    <li class="list-group-item">Data of joined: 		<?= $student['date_of_joined'];?></li>
			    <li class="list-group-item">Parent first name: 		<?= $student['parent_fname'];?></li>
			    <li class="list-group-item">Parent last name: 		<?= $student['parent_lname'];?></li>
			    <li class="list-group-item">Parent phone number: 	<?= $student['parent_phone_number'];?></li>
			    <li class="list-group-item">Grade:
			      	<?php 
			      		$g = '';
			      		$grades = str_split(trim($student['grade']));
			      		foreach ($grades as $grade) {
			      			$g_temp = getGradeById($grade, $conn);
			      			if ($g_temp != 0) 
			      				$g .=$g_temp['grade']. ' '.$g_temp['grade_code'].', ';	
			      		}
			      		$g = rtrim($g, ', ');
			      		echo $g;
			      	 ?>	    	
			    </li>
			    <li class="list-group-item">Section:
			      	<?php 
			      		$e = '';
			      		$sections = str_split(trim($student['section']));
			      		foreach ($sections as $section) {
			      			$e_temp = getSectionById($section, $conn);
			      			if ($e_temp != 0) 
			      				$e .=$e_temp['section'].', ';	
			      		}
			      		$e = rtrim($e, ', ');
			      		echo $e;
			      	 ?>	    	
			    </li>			    			    			    
			  </ul>
			  <div class="card-body">
				    <a href="student.php" 
		 	   		class="btn btn-dark">Go Back</a>
			  </div>
			</div>			
	</div>

	<?php 
		}else{
			header("location: student.php");
        	exit;
		}
	 ?>
}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
    	$(document).ready(function(){
    		$("#navLinks li:nth-child(3) a").addClass('active');
			  });
	</script>
</body>
</html>
<?php 
	    }else{
        	header("location: student.php");
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
