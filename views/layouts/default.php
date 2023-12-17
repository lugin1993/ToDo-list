<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../../public/js/jquery-3.6.4.min.js"></script>
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title><?= $title; ?></title>
</head>
<nav class=" navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <div class="container-fluid align-content-center">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/') echo 'active'; ?>"
                           href="/">Задачи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/task/add') echo 'active'; ?>"
                           href="/task/add">Добавить задачу</a>
                    </li>
                    <?php if ($authorized): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/user/logout">Выйти</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SERVER['REQUEST_URI'] == '/user/login') echo 'active'; ?>"
                               href="/user/login">Войти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container py-1">
    <div class="card shadow">
        <div class="card-body p-5">
			<?php if(isset($message)): ?>
                <div class="alert alert-success" role="alert">
					<?= $message; ?>
                </div>
			<?php endif; ?>
			<?php if(isset($error)): ?>
                <div class="alert alert-danger" role="alert">
					<?= $error; ?>
                </div>
			<?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</div>
<script src="../../public/js/bootstrap.bundle.min.js"></script>
</body>
</html>