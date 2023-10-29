<?php 
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') { 
    	include "../DB_connection.php";
    	include "data/student.php";
    	include "data/class.php";
    	include "data/grade.php";
    	include "data/section.php";
    	include "data/subject.php";

    	if (!isset($_GET['class_id'])) {
		    header("location: students.php");
		    exit;
    	}
    	$class_id = $_GET['class_id'];
		if(isset($_REQUEST['ssubject_id']) && $_REQUEST['ssubject_id'] > 1){
			$ssubject_id = $_REQUEST['ssubject_id'];
			$students = getAllStudentsbyattendance($conn, $ssubject_id);
		} else {
			$ssubject_id = 1;
			$students = getAllStudentsbyattendance($conn, $ssubject_id);
		}
    	$class 	  = getclassesById($class_id,$conn);
    	$subjects = getSubjectsByGrade($class_id, $conn);
		$btn_text = 0;#
		//echo $ssubject_id;
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";	
		if ($students != 0) {
			$check = 0;
	 ?>

	<?php $i = 0; foreach ($students as $student) {
		
		$g = getGradeById($class['grade'], $conn);
		$s = getSectionById($class['section'], $conn);
		if ($g['grade_id'] == $student['grade'] && $s['section_id'] == $student['section']) {$i++;
		if ($i == 1) {
			$check++;
			$counter=0;
		?>
		 <div class="container mt-5">
		 <form name="frmCat" action="req/add-student-attendance.php" method="post">	

		 	 <input type="hidden" name="staff_id" value="<?= $_SESSION['staff_id'] ?>">
        	 <input type="hidden" name="class_id" value="<?= $class_id ?>">

				<select class="form-control" 
						name="ssubject_id" onchange="javascript: frmCat.submit();">
					        <?php foreach($subjects as $subject) { ?>
					            <option value="<?= $subject['subject_id'] ?>" <?php print((($subject['subject_id'] == $ssubject_id)?'selected':''));  ?> >
					                <?= $subject['subject_code'] ?>
					            </option>
					        <?php } ?>
			    </select>	
			<?php if (isset($_GET['error'])) { ?>
			<div class="alert alert-danger" role="alert">
		  		<?=$_GET['error']?>
			</div>
			<?php } ?>
			<?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
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
				      <th scope="col">Attandance status</th>
				    </tr>
				  </thead>
				  <tbody>	
				<?php } ?>		  		
				    <tr>
				      <th scope="row"><?=$i?></th>
				      <td><?=$student['student_id']?></td>
				      <input type="hidden" name="student_id[]" value="<?=$student['student_id']?>">
				      <td><?=$student['fname']?></td>
				      <td><?=$student['lname']?></td>
				      <td>
						<div class="mb-3">
						    <input type="radio"
						    	   value="Present"
						    	   name="attandance_status[<?=$student['student_id']?>]" <?php print((($student['attendance_status'] == 'Present')?'checked':'')); ?>> Present
						    	   &nbsp;&nbsp;&nbsp;
						    <input type="radio"
						    	   value="Absent"
						    	   name="attandance_status[<?=$student['student_id']?>]" <?php print((($student['attendance_status'] == 'Absent')?'checked':'')); ?>> Absent
					  	</div>				      	
				      </td>
					  <input type="hidden" name="attendance_id[]" value="<?php print($student['attendance_id']); ?>">
			    </tr>
			  	<?php $btn_text = $student['attendance_id']; } } ?>
			  </tbody>
			</table>
			<div class="d-flex justify-content-between mt-3">
			    <button type="submit" class="btn btn-primary" name="btn_submit" > <?php print((($btn_text > 0)?'Update':'Add')); ?></button>
			</div>
			</form>
	 	</div>
	 <?php }else{ ?>
	 	<div class="alert alert-info .w-450 m-5" role="alert">
		  Empty!.
		</div>
	 <?php }?>
	 </div>
	<?php if ($check == 0) {
		header("location: students.php");
		exit;
	} ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
    	$(document).ready(function(){
    		$("#navLinks li:nth-child(5) a").addClass('active');
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
