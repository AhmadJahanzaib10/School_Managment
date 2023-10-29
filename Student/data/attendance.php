<?php
function getAttendancebysubjects($subject_id, $conn){
    $sql = "SELECT DISTINCT(att.subject_id), sub.subject, sub.subject_code 
            FROM attendance AS att 
            LEFT OUTER JOIN subjects AS sub ON sub.subject_id = att.subject_id 
            WHERE att.student_id = :student_id";  // Use named placeholder :student_id here

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student_id', $subject_id, PDO::PARAM_STR);  // Bind the parameter using named placeholder

    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $subjects = $stmt->fetchAll();
        return $subjects;
    } else {
        return 0;
    }
}
?>
