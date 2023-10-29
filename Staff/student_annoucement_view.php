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

    	
    	$students = getAllStudents($conn);
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
			$check = 1;
	 ?>
		 <div class="container mt-5">	
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
			 <table class="table table-bordered mt-1 mb-5 n-table">
            <caption style="caption-side:top"><strong>Annoucement</strong> </caption>
			<div class="d-flex justify-content-between mt-3">
			    <a href="annoucement.php" class="btn btn-success">Add</a>
			</div>
            <thead>
              <tr>
                <th scope="col" width="70">Sr. No.</th>
                <th scope="col">Grade</th>
                <th scope="col">Section</th>
                <th scope="col">Subject</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Message</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rs = $conn->query("SELECT annou.*, CONCAT(gra.grade, ' - ', gra.grade_code) AS grade_name, sec.section, CONCAT(subj.subject,' ', subj.subject_code) AS subject_name FROM annoucement AS annou LEFT OUTER JOIN grades AS gra ON gra.grade_id = annou.grade_id LEFT OUTER JOIN section AS sec ON sec.section_id = annou.section_id LEFT OUTER JOIN subjects AS subj ON subj.subject_id = annou.subject_id WHERE annou.staff_id = '" . $_SESSION['staff_id'] . "' AND annou.grade_id = '".$_REQUEST['grade_id']."' AND annou.section_id = '".$_REQUEST['section_id']."' ORDER BY anno_start_date ASC");
              if ($rs->rowCount() > 0) {
                $count=0;
                while ($rw = $rs->fetch(PDO::FETCH_OBJ)) {
                  $count++;
                  ?>
                  <tr>
                    <td scope="col"><?php print($count); ?></td>
                    <td scope="col"><?php print($rw->grade_name);?></td>
                    <td scope="col"><?php print($rw->section);?></td>
                    <td scope="col"><?php print($rw->subject_name);?></td>
                    <td scope="col"><?php print(date('D F j, Y h:i:A', strtotime($rw->anno_start_date)));?></td>
                    <td scope="col"><?php print(date('D F j, Y', strtotime($rw->anno_end_date)));?></td>
                    <td scope="col"><?php print($rw->anno_message);?></td>
                  </tr>
              <?php }
              } else {
                print('<tr><td colspan="100%" align="center">No record found!</td></tr>');
            }
              ?>
            </tbody>
          </table>
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
