<?php

$env = parse_ini_file('../.env');

$conn = mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}