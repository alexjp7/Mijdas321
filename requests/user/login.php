<?php
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once("../../config/database.php");
    include_once(DOCUMENT_ROOT."/config/database.php");
    include_once(DOCUMENT_ROOT."/models/user.php");

    $database = new Database();
    $connection = $database->getConnection();
    $user = new User($connection);

    $data = json_decode(file_get_contents("php://input"));


    $user->username = $data->username;
    $providedUsername = $data->username;
    $providedPassword = $data->password;

    //Validate Login Credentials
    if(!empty($providedUsername)  && !empty($providedPassword))
    {
        
        $stmt = $user->readOne($providedUsername);
        $num = $stmt->rowCount();
        if($num === 1)
        {   
            extract($stmt->fetch(PDO::FETCH_ASSOC));

            if($username === $providedUsername && $password === $providedPassword)
            {
                //Login Credentials Corrrect
                http_response_code(201);
                echo json_encode(array("message:"=>"Login Succes!"));
            }
            else
            {   //Incorrect Login- user not found
                http_response_code(404);
                echo json_encode(array("message:"=>"Incorrect Username or Password"));
            }
        }
        else
        {
            //Incorect Login - user not found
            http_response_code(404);
            echo json_encode(array("message:"=>"Incorrect Username or Password"));
        }
    }
    else 
    {
        //Bad Request 400
        http_response_code(400);
        echo json_encode(array("message:"=>"Please provide the appropriate fields"));

    }
     


?>