<?php
$conn = pg_connect("host=" . getenv("DB_HOST") . " dbname=" . getenv("DB_NAME") . " user=" . getenv("DB_USER") . " password=" . getenv("DB_PASSWORD") . " port=5432 sslmode=require");
?>