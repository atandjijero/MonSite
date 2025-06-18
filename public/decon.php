<?php
session_start();
session_destroy(); 
header("Location: accuille.html"); 
exit();
?>