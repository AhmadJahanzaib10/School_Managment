<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['grade_code']) &&
            isset($_POST['grade'])      &&
            isset($_POST['grade_id'])
        ) {

            include '../../DB_connection.php';
            include "../data/grade.php";

            $grade_code = $_POST['grade_code'];
            $grade      = $_POST['grade'];
            $grade_id   = $_POST['grade_id'];

            $data = 'grade_code=' . $grade_code.'&grade=' . $grade;

            if (empty($grade_code)) {
                $em = "Grade Code is required";
                header("Location: ../grade-edit.php?error=$em&$data");
                exit;
            } else if (empty($grade)) {
                $em = "Grade is required";
                header("Location: ../grade-edit.php?error=$em&$data");
                exit;
            }else {
                // Prepare the SQL statement
                $sql = "UPDATE grades SET grade_code=?, grade=? WHERE grade_id=?";

                $stmt = $conn->prepare($sql);
                $stmt->execute([$grade_code,$grade,$grade_id]);
        $sm = "Grade Updated successfully!.";
        header("location: ../grade-add.php?success=$sm");
        exit;  
            }
        } else {
            $em = "An error Occurred";
            header("Location: ../grade.php?error=$em&$data");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>
