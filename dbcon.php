<?php
$xmldata = simplexml_load_file("configHOME.xml") or die("Failed to load");
    $host = $xmldata->data->servername;
    $user = $xmldata->data->username; 
    $password = $xmldata->data->password;
    $dbname = $xmldata->data->dbname;

$con= mysqli_connect($host,$user,$password,$dbname);
if (!$con)
{
    die("Unable to connect to the database". mysqli_connect_error());
}
