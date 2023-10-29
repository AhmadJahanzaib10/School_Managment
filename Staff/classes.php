<?php 
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') { 
    	include "../DB_connection.php";
    	include "data/class.php";
    	include "data/grade.php";
    	include "data/section.php";
    	include "data/teacher.php";
    	include "data/subject.php";

    	$staff_id = $_SESSION['staff_id'];

    	$staff 	= getTeachersById($staff_id, $conn);
    	$classes = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";
		if ($classes != 0) {
	 ?>
	 <div class="container mt-5">
								 	
	 	<div class="table-responsive">
	 		<table class="table table-bordered mt-3 n-table">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Class</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $i = 0; foreach ($classes as $class) { ?>
			      	<?php 
			      		$classesx = str_split(trim($staff['class']));
			      		$grade = getGradeById($class['grade'], $conn);
			      		$section = getSectionById($class['section'], $conn);
			      		$c = $grade['grade'].'-'.$grade['grade_code'].' '.$section['section'];
			      		foreach ($classesx as $class_id){
			      			if ($class_id == $class['class_id']) 
			      			{ $i++; ?>
							  <tr>
						      <th scope="row"><?=$i?></th>
						      <td>			      				
			      				<?php  echo $c;  ?>

						      </td>
							  </tr>			      				
			      			<?php 
			      			}
			      		}
			      	 ?>
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
