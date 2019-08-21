<?php
  
    include_once("../../config/database.php");
    include_once(DOCUMENT_ROOT."/config/database.php");
    include_once(DOCUMENT_ROOT."/models/assessment.php");

    $subject_id = isset($data->subject_id)
                    ? $data->subject_id
                    : badFormatRequest(); 

    $database = new Database();
    $connection = $database->getConnection();
    $assessment = new Assessment($connection);
    $stmt = $assessment->getBySubject($subject_id);

    $row = $stmt->rowCount();

    if($row > 0 )
    {   
        $records["records"] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $assessment = array(
                "id"=>$id,
                "a_number" => $a_number,
                "name"=>$name
            );    

            array_push($records["records"], $assessment);

        }
        success();
        echo json_encode($records);

    }
    else
    {
        notFound("assessment");
    }


?>