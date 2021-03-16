<!doctype html>
<html lang="en">
<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "navigation.php";

    use App\classes\Register;

    $register = new Register;
    $errors = $register->errors;
    $isValid = $register->isValid;
    $isUserCreated = $register->isUserCreated;
    ?>
    <main class="container">
        <div class="register">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Registration</h5>

                    <?php if ($isValid && $isUserCreated) { ?>
                        <div class="alert alert-success" role="alert">
                            <small>Registration Successful.</small>
                        </div>
                    <?php } ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control <?php echo $errors['name'] ? 'is-invalid' : ''; ?>" id="name" aria-describedby="name">
                            <?php
                            if ($errors['name']) {
                            ?>
                                <div class="invalid-feedback">
                                    <?php
                                    echo $errors["name"];
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
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
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo $errors['confirm_password'] ? 'is-invalid' : ''; ?>" id="confirm_password">
                            <?php
                            if ($errors['confirm_password']) {
                            ?>
                                <div class="invalid-feedback">
                                    <?php
                                    echo $errors["confirm_password"];
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