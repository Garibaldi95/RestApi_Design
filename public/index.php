<?php

require_once "../NoteRestController.php";

$url = $_SERVER['REQUEST_URI'];
$matches = [];

if(preg_match('#/api/v1/notebook/?(\d+)?#', $url, $matches)){
    $id = $matches[1] ?? null;
    $controller = new NoteRestController();
    $data = $controller->process($id);
    echo json_encode($data);

}

