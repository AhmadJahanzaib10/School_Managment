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

    	
		$students = getAllStudents($conn);
    	$grades = getAllGrades($conn);
    	$sections = getAllSections($conn);
    	$subjects = getAllsubjects($conn);
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Announcement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";	
			$check = 1;
	 ?>
		 <div class="d-flex align-items-center flex-column"> <br><br>
		 <div class="login shadow p-3">
		 <form action="req/add-student-annoucement.php" method="post">	

		 	 <b> Grade </b>
				<select class="form-control" 
						name="grade_id" required>
					        <?php foreach($grades as $grade) { ?>
					            <option value="<?= $grade['grade_id'] ?>">
					                <?= $grade['grade']." - ".$grade['grade_code'] ?>
					            </option>
					        <?php } ?>
			    </select><br>
				<b> Section </b>	   		 	
				<select class="form-control" 
						name="section_id" required>
					        <?php foreach($sections as $section) { ?>
					            <option value="<?= $section['section_id'] ?>">
					                <?= $section['section'] ?>
					            </option>
					        <?php } ?>
			    </select><br>
				<b> Subject </b>	   		 	
				<select class="form-control" 
						name="subject_id" required>
					        <?php foreach($subjects as $subject) { ?>
					            <option value="<?= $subject['subject_id'] ?>">
					                <?= $subject['subject']." ( ".$subject['subject_code']." ) " ?>
					            </option>
					        <?php } ?>
			    </select><br>
				<div class="input-date">
					<div class="date_input">
						<b>Start Date</b>
						<input class="form-control" type="date" name="anno_start_date" id="" value="<?php echo date('Y-m-d'); ?>" required>
					</div>
					<div class="date_input">
						<b>End Date</b>
						<input class="form-control" type="date" name="anno_end_date" id="" required>
					</div>
				</div><br>
					<div class="text_area">
							<b> Message </b>
		                  	<textarea class="form-control" name="anno_message" id="" cols="30" rows="10" required></textarea>
		            </div>
			<div class="d-flex justify-content-between mt-3">
			    <button type="submit" class="btn btn-primary">Add</button>
			</div>	   		 	
			</form>
	 	</div>
		 </div>
	 </div>
	<?php if ($check == 0) {
		header("location: students.php");
		exit;
	} ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
    	$(document).ready(function(){
    		$("#navLinks li:nth-child(6) a").addClass('active');
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
