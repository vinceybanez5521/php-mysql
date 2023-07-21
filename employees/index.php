<?php
session_start();
include_once "../is-authenticated.php";
include_once "../includes/header.inc.php";
require_once "../config/database.php";

$sql = "SELECT e.*, p.name as position FROM employees e INNER JOIN positions p ON e.position_id = p.id";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);
// print_r($employees);
mysqli_stmt_close($stmt);
mysqli_close($conn);
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

        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?? null; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Employees</h1>
                <a href="create.php" class="btn btn-primary">Add New Employee</a>
            </div>
            <div class="card-body">
                <?php if (empty($employees)) : ?>
                    <p class="lead text-center">No employees yet</p>
                <?php endif; ?>

                <?php if (!empty($employees)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee) : ?>
                                    <tr>
                                        <td><?= $employee['first_name'] . " " . $employee['last_name'] ?></td>
                                        <td><?= ucfirst($employee['gender']) ?> </td>
                                        <td><?= $employee['position'] ?> </td>
                                        <td><?= number_format($employee['salary'], 2) ?> </td>
                                        <td>
                                            <a href="show.php?id=<?= $employee['id'] ?>" class="btn btn-info">View</a>
                                            <a href="edit.php?id=<?= $employee['id'] ?>" class="btn btn-success">Edit</a>
                                            <form action="delete.php" method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?= $employee['id'] ?>">
                                                <button class="btn btn-danger delete-employee">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.inc.php"; ?>