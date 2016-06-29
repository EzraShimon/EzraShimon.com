<?php

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$URI = "https://webster.cs.washington.edu/cse154/babynames.php?type=";

switch ($_GET["type"]) {
    case "list":
        $URI .= "list";
        $output = file_get_contents($URI, false, stream_context_create($arrContextOptions));
        break;
    case "meaning":
        $URI .= "meaning&name=" . $_GET["name"];
        $output = file_get_contents($URI, false, stream_context_create($arrContextOptions));
        break;
    case "rank":
        $URI .= "rank&name=" . $_GET["name"] . "&gender=" . $_GET["gender"];
        $output = file_get_contents($URI, false, stream_context_create($arrContextOptions));
        break;
    case "celebs":
        $json =
'{
    "actors": [
        ';
            require_once("../bacon/password.php");
            $db = new PDO("mysql:dbname=imdb", "hw5", $password);
            $query = "
            SELECT first_name, last_name
            FROM actors
            WHERE first_name = :first_name;
            ";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":first_name", $_GET["name"], PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $actors[] = '{"firstname": "' . $row["first_name"] . '", "lastname": "' . $row["last_name"] . '", "filmcount": "?"}';
            }
            if (empty($actors)) {
                $actorString = '';
            }
            else {
                $actorString = implode(",
        ", $actors);
            }
            $json .= $actorString .
'
    ]   
}';
        
        
        $output = $json;
}
echo $output;   

 ?>