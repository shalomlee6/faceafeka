<?php

$connection;

function connect(){
    global $connection;
    $databaseServer = "localhost";
    $databaseUser = "root";
    $databasePassword = "";
    $databaseName = "afeka";

    $connection = mysqli_connect($databaseServer, $databaseUser, $databasePassword, $databaseName);

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


}
function close(){
    global  $connection;
    mysqli_close($connection);
}



