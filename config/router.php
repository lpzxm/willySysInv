<?php

$logged = (isset($_SESSION['key'])) ? TRUE : FALSE;
$view = (isset($_GET['view'])) ? $_GET['view'] : '';

if ($view == '') {
    include("./views/public.php");
} else if ($view == 'login') {
    include("./views/login.php");
}

?>