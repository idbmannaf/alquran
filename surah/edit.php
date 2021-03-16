<!doctype html>
<html lang="en">

<?php
require __DIR__ . '../../vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "../navigation.php";

    use App\classes\Surah;
    use App\classes\Session;

    $surah = new Surah();
    $singleSurah = $surah->getSurah($_GET['id']);
    $errors = $surah->errors;
    ?>
    <main class="container-fluid">
        <div class="edit-surah">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Edit Surah</h5>
                    <?php if (Session::checkSession('flash_message')) { ?>
                        <div class="alert alert-info" role="alert">
                            <small>
                                <?php
                                echo Session::getFlashData('flash_message');
                                ?>
                            </small>
                        </div>
                    <?php } ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $singleSurah['id']; ?>">
                        <input type="hidden" name="update_surah" value="1">
                        <div class="mb-2">
                            <label for="arabic" class="form-label">Arabic</label>
                            <input type="text" name="arabic" class="form-control" id="arabic" aria-describedby="arabic" value="<?php echo $singleSurah['arabic']; ?>">
                        </div>
                        <div class="mb-2">
                            <label for="bangla" class="form-label">Bangla</label>
                            <input type="text" name="bangla" class="form-control" id="bangla" aria-describedby="bangla" value="<?php echo $singleSurah['bangla']; ?>">
                        </div>
                        <div class="mb-2">
                            <label for="english" class="form-label">English</label>
                            <input type="text" name="english" class="form-control" id="english" aria-describedby="english" value="<?php echo $singleSurah['english']; ?>">
                        </div>

                        <div class="mb-2">
                            <label for="start" class="form-label">Start</label>
                            <input type="text" name="start" class="form-control" id="start" aria-describedby="start" value="<?php echo $singleSurah['start']; ?>">
                        </div>
                        <div class="mb-2">
                            <label for="end" class="form-label">End</label>
                            <input type="text" name="end" class="form-control" id="end" aria-describedby="end" value="<?php echo $singleSurah['end']; ?>">
                        </div>
                        <div class="mb-2">
                            <label for="file" class="form-label">Audio File</label>
                            <input type="file" name="file" class="form-control" id="file" aria-describedby="file">
                            <small class="text-muted"><?php echo $singleSurah['file']; ?></small>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>