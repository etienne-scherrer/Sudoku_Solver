<?php
include('skeleton/definitions.php');
include('skeleton/head.php');
echo '<div id="content">';
include('skeleton/header.php');
if (!file_exists('./view/' . $content . '.php')) {
    include('view/error.php');
} else {
    include('view/' . $content . '.php');
}
include('skeleton/footer.php');
