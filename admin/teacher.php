<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Admin') { 
    	include "../DB_connection.php";
    	include "data/teacher.php";
    	include "data/subject.php";
    	include "data/grade.php";
    	include "data/class.php";
    	include "data/section.php";
    	$staff = getAllTeachers($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";
		if ($staff != 0) {
	 ?>
	 <div class="container mt-5">
	 	<a href="teacher-add.php" class="btn btn-dark">Add new Teacher</a>
	 	
		<form action="teacher-search.php" 
			  class="mt-3 n-table"
			  method="post">
		    <div class="input-group mb-3">
		    	<input type="text" 
		    		   class="form-control"
		    		   name="searchkey"
		    		   placeholder="Search...">
		    	<button class="btn btn-primary">
		    			<i class="fa fa-search" 
		    			   aria-hidden="true"></i>
						</button>
		    </div>			
		</form>	 		

			<?php if (isset($_GET['error'])) { ?>
			<div class="alert alert-danger mt-3 n-table" role="alert">
		  		<?=$_GET['error']?>
			</div>
			<?php } ?>

			<?php if (isset($_GET['success'])) { ?>
			<div class="alert alert-info mt-3 n-table" role="alert">
		  		<?=$_GET['success']?>
			</div>
			<?php } ?>
								 	
	 	<div class="table-responsive">
	 		<table class="table table-bordered mt-3 n-table">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">ID</th>			      
			      <th scope="col">First Name</th>
			      <th scope="col">Last Name</th>
			      <th scope="col">Phone</th>
			      <th scope="col">Subject</th>
			      <th scope="col">Class</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i = 0; foreach ($staff as $teacher) { $i++?>
			    <tr>
			      <th scope="row"><?=$i?></th>
			      <td><?=$teacher['staff_id']?></td>
			      <td><a href="teacher-view.php?staff_id=<?=$teacher['staff_id']?>"><?=$teacher['fname']?></a></td>
			      <td><?=$teacher['lname']?></td>
			      <td><?=$teacher['phone']?></td>		      
			      <td>
			      	<?php 
			      		$s = '';
			      		$subjects = str_split(trim($teacher['subjects']));
			      		foreach ($subjects as $subject) {
			      			$s_temp = getSubjectsById($subject, $conn);
			      			if ($s_temp != 0) 
			      				$s .=$s_temp['subject_code']. ', ';	
			      		}
			      		echo $s;
			      	 ?>
			      </td>
			      <td>
			      	<?php 
			      		$c = '';
			      		$classes = str_split(trim($teacher['class']));
			      		foreach ($classes as $class_id) {
			      			$class = getclassesById($class_id, $conn);
			      			$c_temp = getGradeById($class['grade'], $conn);
			      			$section = getSectionById($class['section'], $conn);
			      			if ($c_temp != 0) 
			      				$c .=$c_temp['grade']. '-'.$c_temp['grade_code'].' '.$section['section'].', ';	
			      		}
			      		$c = rtrim($c, ', ');
			      		echo $c;
			      	 ?>
			      </td>
			      <td>
			      	<a href="teacher-edit.php?staff_id=<?=$teacher['staff_id']?>" class="btn btn-warning">Edit</a>
			      	<a href="teacher-delete.php?staff_id=<?=$teacher['staff_id']?>" class="btn btn-danger">Delete</a>
			      </td>
			    </tr>
			  	<?php } ?>
			  </tbody>
			</table>
	 	</div>
	 <?php }else{ ?>
	 	<div class="alert alert-info .w-450 m-5" role="alert">
		  Empty!.
		</div>
	 <?php }?>
	 </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
    	$(document).ready(function(){
    		$("#navLinks li:nth-child(2) a").addClass('active');
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
