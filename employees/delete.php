<?php
session_start();
include_once "../is-authenticated.php";
require_once "../config/database.php";

if (isset($_POST['id'])) {
    $id = htmlspecialchars($_POST['id']);

    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_msg'] = "Employee Deleted";
    } else {
        $_SESSION['error_msg'] = "Employee Not Deleted";
    }

    header('Location: ./');

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
