<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/php-mysql/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md bg-primary navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/php-mysql">PHP MySQL</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['is_authenticated'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-mysql">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-mysql/employees/">Employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-mysql/positions/">Positions</a>
                        </li>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['is_authenticated'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-mysql/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-mysql/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <section class="content">
        <div class="container pb-5">