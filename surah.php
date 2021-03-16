<!doctype html>
<html lang="en">

<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "navigation.php";

    use App\classes\Surah;
    use App\classes\Session;

    $surah = new Surah();
    $surahs = $surah->getAllSurahs();

    // echo '<pre>', print_r($surahs), '</pre>';

    // echo Session::getFlashData('flash_message');
    ?>
    <main class="container-fluid">
        <div class="surah">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">List of all Surah</h5>
                    <?php if (Session::checkSession('flash_message')) { ?>
                        <div class="alert alert-info" role="alert">
                            <small>
                                <?php
                                echo Session::getFlashData('flash_message');
                                ?>
                            </small>
                        </div>
                    <?php } ?>
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <th></th>
                            <th>Bangla</th>
                            <th>English</th>
                            <th>Arabic</th>
                            <th>Duration</th>
                            <th>File</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach ($surahs as $key => $surah) { ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $surah['bangla']; ?></td>
                                    <td><?php echo $surah['english']; ?></td>
                                    <td><?php echo $surah['arabic']; ?></td>
                                    <td>
                                        <?php
                                        if ($surah['end'] > 0) {
                                            echo $surah['start'] . 's - ' . $surah['end'] . 's';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (file_exists(BASE_PATH . "/assets/audio/" . $surah['file'])) {
                                            echo $surah['file'];
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center" width="12%">
                                        <ul class="list-unstyled list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="surah/edit.php?id=<?php echo $surah['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post" action="surah/delete.php">
                                                    <input type="hidden" name="id" value="<?php echo $surah['id']; ?>">
                                                    <input type="hidden" name="delete_surah" value="1">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>