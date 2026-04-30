<?php 
require_once("Models/database.php");
require_once("Models/ProductRepository.php"); 
require_once("Models/CategoryRepository.php");

$db = new Database();

$q = $_GET['q'] ?? ""; 

/* SKAPA FUKTION "searchBooks" i ProductRepository.php */
$result = $db->searchBooks($q);
?> 