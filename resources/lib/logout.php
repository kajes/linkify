<?php

session_start();
$_SESSION = [];
$currentUser = false;
session_destroy();
header('Location: ../../');
die;
