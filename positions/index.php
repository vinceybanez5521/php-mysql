<?php
session_start();
include_once "../is-authenticated.php";
include_once "../includes/header.inc.php";
require_once "../config/database.php";

$sql = "SELECT * FROM positions";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$positions = mysqli_fetch_all($result, MYSQLI_ASSOC);
// print_r($positions);
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
                <h1 class="card-title fw-light">Positions</h1>
                <a href="create.php" class="btn btn-primary">Add New Position</a>
            </div>
            <div class="card-body">
                <?php if (empty($positions)) : ?>
                    <p class="lead text-center">No positions yet</p>
                <?php endif; ?>

                <?php if (!empty($positions)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($positions as $position) : ?>
                                    <tr>
                                        <td><?= $position['name'] ?></td>
                                        <td><?= date_format(date_create($position['date_added']), 'F j, Y h:i:s a') ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a class="btn btn-success" href="edit.php?id=<?= $position['id'] ?>">Edit</a>

                                                <form action="delete.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $position['id'] ?>">
                                                    <button class="btn btn-danger delete-position">Delete</button>
                                                </form>
                                            </div>
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