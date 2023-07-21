<?php
session_start();
include_once "../is-authenticated.php";
require_once "../config/database.php";

if (isset($_POST['id'])) {
    $id = htmlspecialchars($_POST['id']);

    $sql = "DELETE FROM positions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_msg'] = "Position Deleted";
        header('Location: ./');
    } else {
        $_SESSION['error_msg'] = "Position Not Deleted";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
