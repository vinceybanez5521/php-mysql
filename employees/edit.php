<?php
session_start();
include_once "../is-authenticated.php";
include_once "../includes/header.inc.php";
require_once "../config/database.php";

$first_name = $last_name = $gender = $hobbies = $position = $salary = "";
$first_name_err = $last_name_err = $position_err = $salary_err = "";

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $employee = mysqli_fetch_assoc($result);
    // print_r($employee);
    mysqli_stmt_close($stmt);

    $first_name = $employee['first_name'];
    $last_name = $employee['last_name'];
    $gender = $employee['gender'];
    $hobbies = explode(',', $employee['hobbies']);
    $position = $employee['position_id'];
    $salary = $employee['salary'];
}

// Load positions
$sql = "SELECT * FROM positions";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$positions = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);

if (isset($_POST['submit'])) {
    // Validate first name
    if (empty($_POST['first_name'])) {
        $first_name_err = "Please enter first name";
    } else {
        $first_name = htmlspecialchars($_POST['first_name']);
    }

    // Validate last name
    if (empty($_POST['last_name'])) {
        $last_name_err = "Please enter last name";
    } else {
        $last_name = htmlspecialchars($_POST['last_name']);
    }

    $gender = $_POST['gender'];

    if (!empty($_POST['hobbies'])) {
        $hobbies = implode(',', $_POST['hobbies']);
    }

    // Validate position
    if (empty($_POST['position'])) {
        $position_err = "Please select position";
    } else {
        $position = $_POST['position'];
    }

    // Validate salary
    if (empty($_POST['salary'])) {
        $salary_err = "Please select salary";
    } else {
        $salary = htmlspecialchars($_POST['salary']);
    }

    if (empty($first_name_err) && empty($last_name_err) && empty($position_err) && empty($salary_err)) {
        $id = htmlspecialchars($_POST['id']);

        $sql = "UPDATE employees SET first_name = ?, last_name = ?, gender = ?, hobbies = ?, position_id = ?, salary = ? WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssisi", $first_name, $last_name, $gender, $hobbies, $position, $salary, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_msg'] = "Employee Updated";
            header('Location: show.php?id=' . $id);
        } else {
            $_SESSION['error_msg'] = "Employee Not Updated";
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
                <h1 class="card-title fw-light">Edit Employee</h1>
                <a href="./" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control <?= !empty($first_name_err) ? 'is-invalid' : null; ?>" id="first-name" name="first_name" value="<?= $first_name ?>">
                        <span class="invalid-feedback"><?= $first_name_err ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control <?= !empty($last_name_err) ? 'is-invalid' : null; ?>" id="last-name" name="last_name" value="<?= $last_name ?>">
                        <span class="invalid-feedback"><?= $last_name_err ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="male" id="male" <?= $gender == "male" ? 'checked' : null; ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="female" id="female" <?= $gender == "female" ? 'checked' : null; ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hobbies</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="sports" value="sports" <?= in_array("sports", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="sports">Sports</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="movies" value="movies" <?= in_array("movies", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="movies">Movies</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="games" value="games" <?= in_array("games", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="games">Video Games</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="cooking" value="cooking" <?= in_array("cooking", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="cooking">Cooking</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="travelling" value="travelling" <?= in_array("travelling", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="travelling">Travelling</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobbies[]" id="others" value="others" <?= in_array("others", $hobbies) ? 'checked' : null; ?>>
                            <label class="form-check-label" for="others">Others</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <select name="position" id="position" class="form-select <?= !empty($position_err) ? 'is-invalid' : null; ?>">
                            <option selected disabled value="">Select Position</option>
                            <?php foreach ($positions as $pos) : ?>
                                <option value="<?= $pos['id'] ?>" <?= $pos['id'] == $position ? 'selected' : null; ?>><?= $pos['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?= $position_err ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" name="salary" id="salary" class="form-control <?= !empty($salary_err) ? 'is-invalid' : null; ?>" value="<?= $salary ?>">
                        <span class="invalid-feedback"><?= $salary_err ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?? -1 ?>">
                    <button type="submit" name="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.inc.php"; ?>