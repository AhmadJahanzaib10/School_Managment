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
    include "data/student.php";

    $student = getStudentById($_SESSION['student_id'], $conn);
    //print_r($student);


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Student - Annoucement</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../img/logo.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
      <?php include "inc/navbar.php"; ?>
      <div class="d-flex justify-content-center align-items-center flex-column pt-4">
        <div class="table-responsive " style="width: 90%; max-width: 1000px;">
          <table class="table table-bordered mt-1 mb-5 n-table">
            <caption style="caption-side:top"><strong>Annoucement</strong> </caption>
            <thead>
              <tr>
                <th scope="col" width="70">Sr. No.</th>
                <th scope="col">Tutor</th>
                <th scope="col">Grade</th>
                <th scope="col">Section</th>
                <th scope="col">Subject</th>
                <th scope="col">Message</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rs = $conn->query("SELECT annou.*, CONCAT(staff.fname, ' ', staff.lname) AS staff_name, CONCAT(gra.grade, ' - ', gra.grade_code) AS grade_name, sec.section, CONCAT(subj.subject,' ', subj.subject_code) AS subject_name FROM annoucement AS annou LEFT OUTER JOIN staff AS staff ON staff.staff_id = annou.staff_id LEFT OUTER JOIN grades AS gra ON gra.grade_id = annou.grade_id LEFT OUTER JOIN section AS sec ON sec.section_id = annou.section_id LEFT OUTER JOIN subjects AS subj ON subj.subject_id = annou.subject_id WHERE annou.grade_id = '" . $student['grade'] . "' AND annou.section_id = '" . $student['section'] . "' AND anno_end_date BETWEEN '".date('Y-m-d')."' AND anno_end_date ORDER BY anno_start_date ASC");
              if ($rs->rowCount() > 0) {
                $count=0;
                while ($rw = $rs->fetch(PDO::FETCH_OBJ)) {
                  $count++;
                  ?>
                  <tr>
                    <td scope="col"><?php print($count); ?></td>
                    <td scope="col"><?php print($rw->staff_name);?></td>
                    <td scope="col"><?php print($rw->grade_name);?></td>
                    <td scope="col"><?php print($rw->section);?></td>
                    <td scope="col"><?php print($rw->subject_name);?></td>
                    <td scope="col"><?php print($rw->anno_message);?></td>
                  </tr>
              <?php }
              } else {
                print('<tr><td colspan="100%" align="center">No record found!</td></tr>');
            }
              ?>
            </tbody>
          </table>



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