<?php
    /************************************************
     Author:  Alex Perceval 
     Group:   Mijdas(kw01)
     Purpose:  Allows client side applications to 
               submit a student mark of an assessment
    ************************************************/
    include_once("../../config/database.php");
    include_once("../../config/reciepts.php");
    include_once("../../models/student.php");
    include_once("../../models/institution.php");

    $database = new Database();
    $connection = $database->getConnection();
    $student = new Student($connection);
    $institution = new Institution($connection);

    $student->assessment  = isset($data->assessment_id) ? $data->assessment_id : badFormatRequest("VARIABLE: 'assessment_id' not set");
    $student->studentId = isset($data->student) ? $data->student : badFormatRequest("VARIABLE: 'student' not set");
    $student->results = isset($data->results) ? $data->results : badFormatRequest("VARIABLE: 'results' not set");


    if($student->submitMark())
    {   
        //Send email to the student who's mark was just submitted
        $domain = $institution->getDomainByAssessment($student->assessment);
        $studentEmail = $student->studentId. "@". $domain;
        emailStudentReciept($studentEmail);

        success();
        echo json_encode(array("MESSAGE"=>"Student mark submitted succesfully"));
    }
    else
        conflictFound("No student data updated");
?>