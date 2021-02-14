<?php

$db_host = 'localhost:3306';
$db_user = 'root';
$db_password = '';
$db_schema = 'test';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_schema);

if ($mysqli->connect_error) {
    die('DB connect error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
}
