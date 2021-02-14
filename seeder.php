<?php

// Insert test data in DB (available image sizes)

require_once('db_connect.php');

$sql = "CREATE TABLE IF NOT EXISTS img_sizes (`name` VARCHAR(3) NOT NULL PRIMARY KEY,
                                              `size` VARCHAR(10) NOT NULL
                                              ) ENGINE=INNODB";
$result = $mysqli->query($sql);

$sql = "INSERT INTO img_sizes (`name`,`size`) VALUES ('big', '800 * 600'),
                                                     ('med', '640 * 480'),
                                                     ('min', '320 * 240'),
                                                     ('mic', '150 * 150')";
$result = $mysqli->query($sql);

if ($mysqli->affected_rows > 0) {
	echo "Successfully updated ".$mysqli->affected_rows." rows!";
} else {
	echo "Table and records already exist!";
}

$mysqli->close();
