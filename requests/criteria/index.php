<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    //PROVIDES HTTP RESPONSE BEHAVIOURS 
    include_once("../../config/responses.php"); 

    $data = json_decode(file_get_contents("php://input"));

    $request  = isset($data->request) 
                ? $data->request
                : badFormatRequest();


/***************************************************
 * Defines Accessible routes based on request value
*****************************************************/
    switch($request)
    {
        case "VIEW_CRITERIA":  //DONE!
            include("viewCriteria.php");
            break;

        case "CREATE_CRITERIA":  
            include("createCriteria.php");
            break;

        case "EDIT_CRITERIA":  
            include("editCriteria.php");
            break;

        default:
            invalidMethod();
            break;
    }

?>