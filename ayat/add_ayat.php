<!doctype html>
<html lang="en">

<?php
require __DIR__ . '../../vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "../navigation.php";

    use App\classes\Ayat;
    use App\classes\Session;

    $ayat = new Ayat();
    $surahs = $ayat->getAllSurahs();

    $errors = $ayat->errors;
    ?>
    <main class="container-fluid">
        <div class="edit-surah">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Add Ayat</h5>
                    <?php if (Session::checkSession('flash_message')) { ?>
                        <div class="alert alert-info" role="alert">
                            <small>
                                <?php
                                echo Session::getFlashData('flash_message');
                                ?>
                            </small>
                        </div>
                    <?php } ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="insert_ayat" value="1">
                        <div class="mb-2">
                            <label for="surah_id" class="form-label">Select Surah</label>
                            <select name="surah_id" id="surah_id" class="form-control">
                                <?php
                                foreach ($surahs as $surah) {
                                    $surahId = $surah['id'];
                                    $surahName = $surah['bangla'];
                                    echo "<option value='$surahId'>$surahName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="verse" class="form-label">Verse</label>
                            <input type="number" name="verse" class="form-control" id="verse" aria-describedby="verse">
                        </div>
                        <div class="mb-2">
                            <label for="ayat_text_arabic" class="form-label">Arabic Text</label>
                            <textarea name="ayat_text_arabic" id="ayat_text_arabic" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="ayat_text_english" class="form-label">English Text</label>
                            <textarea name="ayat_text_english" id="ayat_text_english" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="ayat_text_bangla" class="form-label">Bangla Text</label>
                            <textarea name="ayat_text_bangla" id="ayat_text_bangla" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="start" class="form-label">Start</label>
                            <input type="text" name="start" id="start" class="form-control" value="">
                        </div>

                        <div class="mb-2">
                            <label for="end" class="form-label">End</label>
                            <input type="text" name="end" id="end" class="form-control" value="">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Add Ayat</button>
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