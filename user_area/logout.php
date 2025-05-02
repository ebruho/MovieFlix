<?php
session_start();

// Премахване на всички сесийни променливи
$_SESSION = [];

// Унищожаване на сесията
session_destroy();

// Пренасочване към началната страница или login
header("Location: ../index.php");
exit;

?>