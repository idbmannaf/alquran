<?php
require __DIR__ . '/vendor/autoload.php';

use App\classes\Session;
?>

<nav class="navbar navbar-expand-md islamic-bg mb-5">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" href="index.php">
            <img class="" src="<?php // echo PROJECT_PATH . 'assets/logo.png'; ?>" width="80px" alt="Quran">
        </a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mb-2 mb-md-0" style="margin-left: 10rem;">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo PROJECT_PATH . "index.php" ?>">Home</a>
                </li>
                <?php if (Session::getSessionData("loggedin")) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo PROJECT_PATH . "dashboard.php" ?>">Dashboard</a>
                    </li>
                <?php }
                if (Session::getSessionData("loggedin") && Session::getSessionData("isAdmin")) {
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Ayat</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="<?php echo PROJECT_PATH . "ayat.php" ?>">All Ayat List</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo PROJECT_PATH . "ayat/add_ayat.php" ?>">Add Ayat</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Surah</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="<?php echo PROJECT_PATH . "surah.php" ?>">All Surah List</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo PROJECT_PATH . "surah/add_surah.php" ?>">Add Surah</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!Session::getSessionData("loggedin")) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PROJECT_PATH . "login.php" ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PROJECT_PATH . "register.php" ?>">Register</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PROJECT_PATH . "logout.php" ?>">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>