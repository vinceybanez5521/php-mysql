<?php
session_start();
include_once "../is-authenticated.php";
include_once "../includes/header.inc.php";
require_once "../config/database.php";

$name = "";
$name_err = "";

if (isset($_POST['submit'])) {
    // Validate name
    if (empty($_POST['name'])) {
        $name_err = "Please enter name";
    } else {
        $name = htmlspecialchars($_POST['name']);
    }

    if (empty($name_err)) {
        $sql = "INSERT INTO positions(name) VALUES(?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);

        if (mysqli_stmt_execute($stmt)) {
            // echo mysqli_stmt_affected_rows($stmt);
            $_SESSION['success_msg'] = "Position Added";
            header('Location: ./');
        } else {
            $_SESSION['error_msg'] = "Position Not Added";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?? null; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Add New Position</h1>
                <a href="./" class="btn btn-primary">Positions</a>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control <?= $name_err ? 'is-invalid' : null; ?>" id="name" name="name" value="<?= $name ?>">
                        <span class="invalid-feedback">
                            <?= $name_err ?? null; ?>
                        </span>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.inc.php"; ?>