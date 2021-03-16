<!doctype html>
<html lang="en">

<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "navigation.php";

    use App\classes\Home;

    $home = new Home();

    $surahs = $home->getAllSurahs();
    $languages = array('bangla', 'english', 'arabic');
    $searchResult = $home->searchResult;
    $postValue = $home->postValue;
    ?>
    <main class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="card" style="background-color: #f3f3f3">
                    <div class="card-body ">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="row">
                                <?php if ($home->errors) { ?>
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger" role="alert">
                                            <ul class="list-unstyled">
                                                <?php foreach ($home->errors as $error) { ?>
                                                    <li><?php echo $error; ?></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <div class="card" style="background-color: #6f9425">
                                        <div class="card-header fw-bold">
                                            Select Surah
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <label for="surah_bangla_id">Bangla</label>
                                                <select name="surah_bangla_id" id="surah_bangla_id" class="form-control form-control-sm">
                                                    <option value="">Select One</option>
                                                    <?php foreach ($surahs as $surah) { ?>
                                                        <option <?php echo $postValue['surah_bangla_id'] == $surah['id'] ? 'selected' : '' ?> value="<?php echo $surah['id']; ?>"><?php echo $surah['bangla']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="surah_english_id">English</label>
                                                <select name="surah_english_id" id="surah_english_id" class="form-control form-control-sm">
                                                    <option value="">Select One</option>
                                                    <?php foreach ($surahs as $surah) { ?>
                                                        <option <?php echo $postValue['surah_english_id'] == $surah['id'] ? 'selected' : '' ?> value="<?php echo $surah['id']; ?>"><?php echo $surah['english']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="surah_arabic_id">Arabic</label>
                                                <select name="surah_arabic_id" id="surah_arabic_id" class="form-control form-control-sm">
                                                    <option value="">Select One</option>
                                                    <?php foreach ($surahs as $surah) { ?>
                                                        <option <?php echo $postValue['surah_arabic_id'] == $surah['id'] ? 'selected' : '' ?> value="<?php echo $surah['id']; ?>"><?php echo $surah['arabic']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card" style="background-color:#6f9425">
                                        <div class="card-header fw-bold">
                                            Select Ayat
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ayat_type" id="all_ayat" value="0" <?php echo !$postValue['ayat_type'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="all_ayat">
                                                        Full Surah
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ayat_type" id="ayat" value="1" <?php echo $postValue['ayat_type'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="ayat">
                                                        Ayat
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label for="ayat_from">From</label>
                                                <input type="text" name="ayat_from" id="ayat_from" class="form-control form-control-sm" value="<?php echo $postValue['ayat_from']; ?>">
                                            </div>
                                            <div class="mb-2">
                                                <label for="ayat_to">To</label>
                                                <input type="text" name="ayat_to" id="ayat_to" class="form-control form-control-sm" value="<?php echo $postValue['ayat_to']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card" style="background-color:#6f9425">
                                        <div class="card-header fw-bold">
                                            Select Language
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <select name="ayat_language" id="ayat_language" class="form-control form-control-sm">
                                                    <option value="">Select Language</option>
                                                    <?php foreach ($languages as $language) { ?>
                                                        <option <?php echo $postValue['ayat_language'] == $language ? 'selected' : '' ?> value="<?php echo $language ?>"><?php echo ucfirst($language) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3 text-center">
                                    <button class="btn btn-md " type="submit" style="background: #6f9425">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card ">
                    <div class=" card-header fw-bold" style="background: #6f9425;">
                        Quranic Audio Player
                    </div>

                    <div class=" card-body" style="background-color: #f3f3f3;">
                        <form>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pintu_vai" value="all_language" checked>
                                <label class="form-check-label" for="all_ayat">
                                    All Language
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pintu_vai" value="bangla">
                                <label class="form-check-label" for="all_ayat">
                                    Bangla
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pintu_vai" value="english">
                                <label class="form-check-label" for="all_ayat">
                                    English
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pintu_vai" value="arabic">
                                <label class="form-check-label" for="all_ayat">
                                    Arabic
                                </label>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-sm" type="submit" style="background: #6f9425;">search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($searchResult) { ?>
            <div class="clearfix"></div>
            <div class="search-result mb-5">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="card text-white bg-success mb-3 mt-5">
                            <div class="card-body" style="background-color: #3f6004;">
                                <h4 class="mb-0 text-center fw-bold">
                                    <?php echo $searchResult['surah']['bangla'] . " - " . $searchResult['surah']['english'] . " - " . $searchResult['surah']['arabic'] ?>
                                </h4>
                                <p class="mb-0 text-center">
                                    (Selected Ayat 1-<?php echo count($searchResult['ayats']); ?>)
                                </p>
                            </div>
                        </div>

                        <hr>

                        <?php if (count($searchResult)) { ?>
                            <div class="card text-dark bg-light mb-3">
                                <div class="card-header fw-bolder">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="audio-container" audioId="ayataudio-<?php echo $searchResult['surah']['id']; ?>">
                                                <audio id="ayataudio-<?php echo $searchResult['surah']['id']; ?>" start="<?php echo $searchResult['surah']['start']; ?>" end="<?php echo $searchResult['surah']['end']; ?>" src="<?php echo PROJECT_PATH . 'assets/audio/' . $searchResult['surah']['file']; ?>" type="audio/ogg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                                <button class="btn btn-sm btn-primary play-button">
                                                    <i class="fa fa-play" aria-hidden="true"></i> Play
                                                </button>
                                                <button class="btn btn-dark btn-sm stop-button">
                                                    <i class="fa fa-stop" aria-hidden="true"></i> Stop
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-end">
                                            <span class="badge bg-primary fs-5">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-title text-end">
                                        <h5 class="bg-secondary p-2 text-white d-inline-block rounded-2">
                                            بِسْمِ ٱللَّٰهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                                        </h5>
                                    </div>
                                    <div class="card-text">
                                        <?php if (empty($postValue['ayat_language'])) { ?>
                                            <p>বিসমিল্লাহির রাহমানির রাহীম</p>
                                            <p>Bismillahir-Rahmanir-Rahim</p>
                                            <p>بِسْمِ ٱللَّٰهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</p>
                                        <?php } else if ($postValue['ayat_language'] == 'bangla') { ?>
                                            <p>বিসমিল্লাহির রাহমানির রাহীম</p>
                                        <?php } else if ($postValue['ayat_language'] == 'english') { ?>
                                            <p>Bismillahir-Rahmanir-Rahim</p>
                                        <?php } else if ($postValue['ayat_language'] == 'arabic') { ?>
                                            <p>بِسْمِ ٱللَّٰهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php foreach ($searchResult['ayats'] as $ayat) { ?>
                            <div class="card text-dark bg-light mb-3">
                                <div class="card-header fw-bolder">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="audio-container" audioId="ayataudio-<?php echo $searchResult['surah']['id'] . '-' . $ayat['id']; ?>">
                                                <audio id="ayataudio-<?php echo $searchResult['surah']['id'] . '-' . $ayat['id']; ?>" start="<?php echo $ayat['start']; ?>" end="<?php echo $ayat['end']; ?>" src="<?php echo PROJECT_PATH . 'assets/audio/' . $searchResult['surah']['file']; ?>" type="audio/ogg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                                <button class="btn btn-sm btn-primary play-button">
                                                    <i class="fa fa-play" aria-hidden="true"></i> Play
                                                </button>
                                                <button class="btn btn-dark btn-sm stop-button">
                                                    <i class="fa fa-stop" aria-hidden="true"></i> Stop
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-end">
                                            <span class="badge bg-primary fs-5">
                                                <?php echo $ayat['surah_id'] . ":" . $ayat['verse']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-title text-end">
                                        <h5 class="bg-secondary p-2 text-white d-inline-block rounded-2">
                                            <?php echo $ayat['arabic'] ?>
                                        </h5>
                                    </div>
                                    <div class="card-text">
                                        <?php if (empty($postValue['ayat_language'])) { ?>
                                            <p><?php echo $ayat['bangla'] ?></p>
                                            <p><?php echo $ayat['english'] ?></p>
                                            <p><?php echo $ayat['arabic'] ?></p>
                                        <?php } else { ?>
                                            <p><?php echo $ayat['ayat_text']; ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>


    <script src="assets/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js?v=<?php echo time(); ?>"></script>
    <script>
        $(".play-button").click(function(e) {
            e.preventDefault();

            var container = $(this).closest(".audio-container");
            $player = document.getElementById(container.attr("audioId"));

            $starttime = $player.getAttribute('start');
            $endtime = $player.getAttribute('end');

            $player.currentTime = $starttime;
            $player.play();

            $player.addEventListener('timeupdate', (event) => {
                if ($player.currentTime > $endtime) $player.pause();
            });
        });


        $(".stop-button").click(function(e) {
            e.preventDefault();

            var container = $(this).closest(".audio-container");
            $player = document.getElementById(container.attr("audioId"));
            $player.pause();
        });
    </script>
</body>

</html>