<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once("db_connection/db.php");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: application/json');
        die();
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_FILES['image'])){
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid().".".$extension;
            move_uploaded_file($_FILES['image']['tmp_name'], "images/".$filename);
            $sql = "INSERT INTO incident_img (img_name) VALUES (?)";
            $stmt= $db->prepare($sql);
            $stmt->execute([$filename]);

            echo json_encode(['status'=>200,'img_id'=>$db->lastInsertId()]);
            die();
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        try{
            $sql = "INSERT INTO board (img_id,lat, lon, incident_text) VALUES (?,?,?,?)";
            $stmt= $db->prepare($sql);
            $stmt->execute([$data['picture_id'],$data['lat'], $data['lon'], $data['info']]);

            echo json_encode(['status'=>200,'msg'=>"інцедент доданий"]);
        }
        catch(Exception $e){
            echo json_encode(["error"=>$e->getMessage()]);
        }
        
    }