<?php
require 'vendor/autoload.php'; 
$taskId = $_GET['id'];
$stmt = $pdo->prepare("SELECT description FROM tasks WHERE id = :id");
$stmt->execute(['id' => $taskId]);
$task = $stmt->fetch();
$parsedown = new Parsedown();
$htmlDescription = $parsedown->text($task['description']);
echo $htmlDescription;
?>
