<?php
//You can download the google_client_api folder from google website for PHP
//After you download place it in your project folder
require_once 'google_client_api/vendor/autoload.php';
//This can be obtained from google cloud--> pleas watch the instruction on google or google cloud on how to obtain these keys
$clientID = 'Enter Your Client ID Here';
$clientSecret = 'Enter Your Client Secret Here'

#Make sure to change the folder name with your folder

$redirectUri = "http:/localhost/FolderName/index.php";

$client = new google_client();
$client->setClientId();
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$clinet->addScope("email");
$client->addScope("profile");

?>