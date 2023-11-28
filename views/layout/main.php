<?php use app\core\Application; ?>
<!--  -->
<!DOCTYPE html>
<html lang="ar >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
</head>

<body>

    <ul>
        <?php if (Application::$app->UserInfo()): ?>
            <li>
                <?= Application::$app->UserInfo()['username'] ?>
            </li>
            <li><a href="/cp/dashboard"><i class="fa fa-user"></i> Dashboard</a></li>
        <?php else: ?>
            <li><a href="/login"><i class="fa fa-user"></i> Login</a></li>
        <?php endif; ?>
    </ul>
    {content}

</body>

</html>