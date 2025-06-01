<?php
$mysqli = new mysqli("localhost", "root", "", "kantin2");

$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $item) {
    $mysqli->query("UPDATE smutes SET stok = stok - 1 WHERE id = {$item['id']}");
}
?>
