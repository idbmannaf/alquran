<!doctype html>
<html lang="en">
<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "navigation.php";

    use App\classes\Session;
    use App\classes\Dashboard;

    $loggedIn = Session::getSessionData("loggedin");

    if (!$loggedIn) {
        header("Location:index.php");
    }

    /*$dashboard = new Dashboard();

        $surahs = $dashboard->getAllSurahs();
        $languages = array('bangla','english','arabic');
        $searchResult = $dashboard->searchResult;
        $postValue = $dashboard->postValue;*/
    ?>
    <main class="container">
        <?php echo "Welcome " . Session::getSessionData('fullname'); ?>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>