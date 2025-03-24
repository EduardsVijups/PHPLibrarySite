<?php
$dbPath = realpath(dirname(__FILE__) . '/../config/library.db');
$conn = new SQLite3($dbPath);
?>