<?php
session_start();
include_once "../includes/header.inc.php";
require_once "../config/database.php";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT e.*, p.name as position FROM employees e INNER JOIN positions p ON e.position_id = p.id WHERE e.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $employee = mysqli_fetch_assoc($result);
    // print_r($employee);

    $hobbies = explode(',', $employee['hobbies']);
    $hobbies = array_map(function ($hobby) {
        if ($hobby == "games") {
            $hobby = "Video Games";
            return $hobby;
        }
        return ucfirst($hobby);
    }, $hobbies);
    $hobbies = implode(', ', $hobbies);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<div class="row">
    <div class="col-12">
        <?php if (isset($_SESSION['success_msg'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success_msg'] ?? null; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['success_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Employee Information</h1>
                <a href="./" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <p>First Name: <strong><?= $employee['first_name'] ?></strong></p>
                <p>Last Name: <strong><?= $employee['last_name'] ?></strong></p>
                <p>Gender: <strong><?= ucfirst($employee['gender']) ?></strong></p>
                <p>Hobbies: <strong><?= $hobbies ?></strong></p>
                <p>Position: <strong><?= $employee['position'] ?></strong></p>
                <p>Salary (PHP): <strong><?= number_format($employee['salary'], 2) ?></strong></p>
                <p>Date Added: <strong><?= date_format(date_create($employee['date_added']), 'F j, Y h:i:s a') ?></strong></p>
                <div class="d-flex">
                    <a href="edit.php?id=<?= $employee['id'] ?>" class="btn btn-success">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.inc.php"; ?>