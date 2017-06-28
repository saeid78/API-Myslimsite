<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET All Servers

$app->get('/api/citweb',function (Request $request , Response $response){

        $sql = "SELECT * FROM servers";

        try{

            // Get DB Object

              $db = new db();

              //connect
            $db = $db->connect();

            $stmt = $db->query($sql);
            $servers = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo json_encode($servers);

         } catch (PDOException $e){
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
});

// GET single Server

$app->get('/api/citweb/{id}',function (Request $request , Response $response){

    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM servers WHERE id = $id ";

    try{

        // Get DB Object

        $db = new db();

        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $server = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($server);

    } catch (PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// ADD Server

$app->post('/api/citweb/add',function (Request $request , Response $response){

    $country = $request->getparam('country');
    $city = $request->getparam('city');
    $manufacturer = $request->getparam('manufacturer');
    $cpu = $request->getparam('cpu');
    $ram = $request->getparam('ram');
    $hdd_capacity = $request->getparam('hdd_capacity');
    $storage_type = $request->getparam('storage_type');
    $raid = $request->getparam('raid');
    $bandwidth = $request->getparam('bandwidth');
    $network_speed = $request->getparam('network_speed');

    $sql = "INSERT  INTO  servers (country,city,manufacturer,cpu,ram,hdd_capacity,storage_type,raid,bandwidth,network_speed) VALUES
    (:country,:city,:manufacturer,:cpu,:ram,:hdd_capacity,:storage_type,:raid,:bandwidth,:network_speed)";

    try{

        // Get DB Object

        $db = new db();

        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':country',       $country);
        $stmt->bindParam(':city',          $city);
        $stmt->bindParam(':manufacturer',  $manufacturer);
        $stmt->bindParam(':cpu',           $cpu);
        $stmt->bindParam(':ram',           $ram);
        $stmt->bindParam(':hdd_capacity',  $hdd_capacity);
        $stmt->bindParam(':storage_type',  $storage_type);
        $stmt->bindParam(':raid',          $raid);
        $stmt->bindParam(':bandwidth',     $bandwidth);
        $stmt->bindParam(':network_speed', $network_speed);

        $stmt->execute();
        echo '{"notice": {"text:" "Server Added"}';

    } catch (PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Server

$app->put('/api/citweb/update/{id}',function (Request $request , Response $response){
    $id = $request->getAttribute('id');

    $ram = $request->getparam('ram');


    $sql = "UPDATE  servers SET
            
            ram =  :ram
           
            WHERE id=$id";


    try{

        // Get DB Object

        $db = new db();

        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

       // $stmt->bindParam(':country',       $country);
       // $stmt->bindParam(':city',          $city);
       // $stmt->bindParam(':manufacturer',  $manufacturer);
       // $stmt->bindParam(':cpu',           $cpu);
        $stmt->bindParam(':ram',           $ram);
       // $stmt->bindParam(':hdd_capacity',  $hdd_capacity);
        //$stmt->bindParam(':storage_type',  $storage_type);
       // $stmt->bindParam(':raid',          $raid);
       //$stmt->bindParam(':bandwidth',     $bandwidth);

        $stmt->execute();
        echo '{\"notice\": {\"text:\" \"Server Updated\"}';

    } catch (PDOException $e){
        echo '{\"error\": {\"text\": '.$e->getMessage().'}';
    }
});

// Delete  Server

$app->delete('/api/citweb/delete/{id}',function (Request $request , Response $response){

    $id = $request->getAttribute('id');
    $sql = "DELETE  FROM servers WHERE id = $id ";

    try{

        // Get DB Object

        $db = new db();

        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{\"notice\": {\"text:\" \"Server Deleted\"}';

    } catch (PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});