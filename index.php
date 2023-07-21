<?php
session_start();
include_once "is-authenticated.php";
include_once "includes/header.inc.php";
require_once "config/database.php";
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
            <div class="card-header">
                <h1 class="card-title fw-light">Home</h1>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['is_authenticated'])) : ?>
                    <p>You are logged in as <strong><?= $_SESSION['email'] ?></strong></p>
                    <a href="logout.php">Logout</a>
                <?php endif; ?>

                <div class="row mt-3 px-2 gap-3">
                    <div class="col-md-4 border rounded px-4 py-2">
                        <p class="fw-light fs-5">Employees</p>
                        <?php
                        $sql = "SELECT count(id) as total_employees FROM employees";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $data = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);
                        ?>
                        <p class="fs-3"><strong><?= $data['total_employees'] ?></strong></p>
                    </div>
                    <div class="col-md-4 border rounded px-4 py-2">
                        <p class="fw-light fs-5">Positions</p>
                        <?php
                        $sql = "SELECT count(id) as total_positions FROM positions";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $data = mysqli_fetch_assoc($result);

                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        ?>
                        <p class="fs-3"><strong><?= $data['total_positions'] ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.inc.php"; ?>