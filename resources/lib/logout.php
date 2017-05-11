<?php

session_start();
$_SESSION = [];
$currentUser = false;
session_destroy();
if (isset($_COOKIE['kajes_linkify'])) {
    setcookie('kajes_linkify', '', time(), '/');
}
header('Location: '.$_SERVER['HTTP_REFERER']);
die;
