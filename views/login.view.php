<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include "components/links.php" ?>

        <title>Bango - Login</title>
    </head>
    <body>
        <?php include "components/navbar.php" ?>

        <div class="container py-5 text-center">
            <div class="card mx-auto text-left w-100 p-3" style="max-width: 500px">
                <div class="text-center">
                    <h2 class="mb-3">Login</h2>
                </div>

                <form action="/login" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <br>
                        <input
                            class="form-control"
                            type="email"
                            name="email"
                            <?php if (isset($_POST["email"])): ?>
                                value="<?= $_POST["email"] ?>"
                            <?php endif ?>
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <br>
                        <input
                            class="form-control"
                            type="password"
                            name="password"
                            <?php if (isset($_POST["password"])): ?>
                                value="<?= $_POST["password"] ?>"
                            <?php endif ?>
                            required
                        />
                    </div>
                    <div class="py-3 form-group">
                        Don't have an account? <a href="/register" class="text-warning">Register</a>
                    </div>
                    <?php if (isset($message)): ?>
                        <div role="alert" class="fade alert alert-danger show">
                            <?= $message ?>
                        </div>
                    <?php endif ?>
                    <div class="text-center">
                        <button
                            class="btn btn-warning rounded"
                            type="submit"
                            action="submit"
                            name="register"
                        >
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php include "components/scripts.php" ?>
    </body>
</html>
