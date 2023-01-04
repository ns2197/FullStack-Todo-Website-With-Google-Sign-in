<?php

session_start();
//usually the hostname, username and password are the same for default
//dbName will vary based on what you have named your database
$host = 'localhost';
$dbUsername = 'root';
$dBPassword = 'mysql';
$dBName = 'dbname_goes_here';

$conn = mysqli_connect ($host, $dBuserName, $dBPassword, $dBName);

if ($conn == false) {
    print "Connection Failed".mysqli_errorno();
}


?>