<?php
session_start();
if (
  isset($_SESSION['student_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Student') {
    include "../DB_connection.php";
    include "data/score.php";
    include "data/subject.php";
    include "data/attendance.php";

    //$subject = getSubjectsById($_REQUEST['subject_id'], $conn);
    $subject = getAttendancebysubjects($_SESSION['student_id'], $conn);
    $record = 0; 

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Student - Attendance Summary</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../img/logo.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
      <?php include "inc/navbar.php"; ?>
      <div class="d-flex justify-content-center align-items-center flex-column pt-4">
        <?php foreach($subject AS $subjectbyAttendance) { $record = 1; ?>
        <div class="table-responsive " style="width: 90%; max-width: 1000px;">
          <table class="table table-bordered mt-1 mb-5 n-table">
            <caption style="caption-side:top"><strong>Subject: <?php print($subjectbyAttendance['subject']." ( ".$subjectbyAttendance['subject_code']." )"); ?></strong> </caption>
            <thead>
              <tr>
                <th scope="col" width="70">Sr. No.</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rs = $conn->query("SELECT * FROM attendance WHERE student_id = '" . $_SESSION['student_id'] . "' AND subject_id = '" . $subjectbyAttendance['subject_id'] . "' ORDER BY date DESC");
              if ($rs->rowCount() > 0) {
                $count=0;
                while ($rw = $rs->fetch(PDO::FETCH_OBJ)) {
                  $count++;
                  ?>
                  <tr>
                    <td scope="col"><?php print($count); ?></td>
                    <td scope="col"><?php print(date('D F j, Y h:i:A', strtotime($rw->date)));?></td>
                    <td scope="col"><?php print($rw->attendance_status); ?></td>
                  </tr>
              <?php }
              } else {
                print('<tr><td colspan="100%" align="center">No record found!</td></tr>');
            }
              ?>
            </tbody>
          </table>
        </div>
        <?php } if($record == 0){
          print('<table><tr><td colspan="100%" align="center">No record found!</td></tr></table>');
        } ?>

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
          <script>
            $(document).ready(function() {
              $("#navLinks li:nth-child(3) a").addClass('active');
            });
          </script>
    </body>

    </html>
<?php

  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>