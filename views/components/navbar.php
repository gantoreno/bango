<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/assets/svg/logo.svg" height="33" class="d-inline-block align-top" alt="" loading="lazy">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php if (isset($user)): ?>
                <form class="form-inline ml-auto" action="/logout" method="POST">
                    <button class="w-100 btn btn-warning my-2 my-sm-0 rounded" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a class="p-2 nav-link text-secondary <?php if ($_GET["url"] === "login") echo "active" ?>" href="/login">Login</a>
                <a class="p-2 nav-link text-secondary <?php if ($_GET["url"] === "register") echo "active" ?>" href="/register">Register</a>
            <?php endif ?>
        </div>
    </div>
</nav>
