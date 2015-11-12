<?php
//disable PHP error output
//error_reporting(0);
//start session if it does not exists
if (!isset($_SESSION)) {
    session_start();
}
//get the page that will be shown
$content = isset($_GET['page']) ? $_GET['page'] : 'home';