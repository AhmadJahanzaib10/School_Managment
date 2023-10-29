<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['uname']) &&
            isset($_POST['student_id']) &&
            isset($_POST['pnumber']) &&
            isset($_POST['email_address']) &&
            isset($_POST['address']) &&
            isset($_POST['date_of_birth']) &&
            isset($_POST['gender']) &&
            isset($_POST['parent_first_name']) &&
            isset($_POST['parent_last_name']) &&
            isset($_POST['parent_phone_number']) &&
            isset($_POST['section']) &&
            isset($_POST['grades'])
        ) {

            include '../../DB_connection.php';
            include "../data/student.php";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $uname = $_POST['uname'];
            $student_id = $_POST['student_id'];
            $pnumber = $_POST['pnumber'];
            $email_address = $_POST['email_address'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $parent_first_name = $_POST['parent_first_name'];
            $parent_last_name = $_POST['parent_last_name'];
            $parent_phone_number = $_POST['parent_phone_number'];
            $grades = $_POST['grades'];
            $section = $_POST['section'];

            $data = 'student_id=' . $student_id;

            if (empty($fname)) {
                $em = "First Name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (empty($lname)) {
                $em = "Last Name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (empty($uname)) {
                $em = "Username is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (empty($student_id)) {
                $em = "ID is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (empty($pnumber)) {
                $em = "Phone Number is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (!IdIsUnique($student_id, $conn, $student_id)) {
                $em = "ID is taken, Please try again!.";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else if (empty($address)) {
                $em = "Address is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($date_of_birth)) {
                $em = "Date of birth is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($gender)) {
                $em = "Gender is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($email_address)) {
                $em = "Email address is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($parent_first_name)) {
                $em = "Parent first name is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($parent_last_name)) {
                $em = "Parent last name number is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else if (empty($parent_phone_number)) {
                $em = "Parent phone number of birth is required";
                header("Location: ../teacher-edit.php?error=$em&$data");
                exit;
            } else {
                // Prepare the SQL statement
                $sql = "UPDATE students SET fname=?, lname=?, username=?,phone=?, grade=?, address=?, parent_fname=?, date_of_birth=?, parent_lname=?, gender=?, email_address=?, parent_phone_number=?, section=? WHERE student_id=?";

                $stmt = $conn->prepare($sql);

                // Bind the parameters
                $stmt->bindParam(1, $fname);
                $stmt->bindParam(2, $lname);
                $stmt->bindParam(3, $uname);
                $stmt->bindParam(4, $pnumber);
                $stmt->bindParam(5, $grades);
                $stmt->bindParam(6, $address);
                $stmt->bindParam(7, $parent_first_name);
                $stmt->bindParam(8, $date_of_birth);
                $stmt->bindParam(9, $parent_last_name);
                $stmt->bindParam(10, $gender);
                $stmt->bindParam(11, $email_address);
                $stmt->bindParam(12, $parent_phone_number);
                $stmt->bindParam(13, $section);
                $stmt->bindParam(14, $student_id);

                // Execute the statement
                if ($stmt->execute()) {
                    $sm = "Successfully updated!.";
                    header("Location: ../student-edit.php?success=$sm&$data");
                    exit;
                } else {
                    $em = "Error updating student information.";
                    header("Location: ../student-edit.php?error=$em&$data");
                    exit;
                }
            }
        } else {
            $em = "An error Occurred";
            header("Location: ../student.php?error=$em&$data");
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
