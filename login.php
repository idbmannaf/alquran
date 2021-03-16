<!doctype html>
<html lang="en">
<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include "navigation.php";

    use App\classes\Login;

    $login = new Login;
    $errors = $login->errors;
    $isValid = $login->isValid;
    $isLoggedIn = $login->isLoggedIn;

    if ($isLoggedIn) {
        header("Location:dashboard.php");
    }

    ?>
    <main class="container">
        <div class="login">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>

                    <?php if ($isValid && !$isLoggedIn) { ?>
                        <div class="alert alert-danger" role="alert">
                            <small>Login Failed, Invalid Email/Password.</small>
                        </div>
                    <?php } ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control <?php echo $errors['email'] ? 'is-invalid' : ''; ?>" id="email" aria-describedby="email">
                            <?php
                            if ($errors['email']) {
                            ?>
                                <div class="invalid-feedback">
                                    <?php
                                    echo $errors["email"];
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control <?php echo $errors['password'] ? 'is-invalid' : ''; ?>" id="password">
                            <?php
                            if ($errors['password']) {
                            ?>
                                <div class="invalid-feedback">
                                    <?php
                                    echo $errors["password"];
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>