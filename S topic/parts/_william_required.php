<?php

if (!isset($_SESSION)) {
    session_start();
    }

if (!isset($_SESSION['william'])) {
    header('Location: vendor-list.php');
    exit;
    }
