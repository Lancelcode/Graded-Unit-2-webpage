<?php
$link = mysqli_connect('localhost','root','','gradedunit');
if (!$link) { 
    die('Could not connect to MySQL: ' . mysqli_connect_error()); 
} 

