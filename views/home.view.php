<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include "components/links.php" ?>

        <title>Bango - Home</title>
    </head>
    <body>
        <?php include "components/navbar.php" ?>

        <div class="container py-5">
            <h1>Home</h1>

            <?php if (isset($user)): ?>
                <p>Welcome back, <code><?= $user->email ?></code>.</p>
            <?php else: ?>
                <p>User not authenticated</p>
            <?php endif ?>
        </div>

        <?php include "components/scripts.php" ?>
    </body>
</html>
