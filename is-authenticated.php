<?php
if(!isset($_SESSION['is_authenticated'])) {
    header('Location: /php-mysql/login.php');
}