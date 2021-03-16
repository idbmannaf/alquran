<!doctype html>
<html lang="en">
<?php
require __DIR__ . '/vendor/autoload.php';
include BASE_PATH . "/header.php";
?>

<body>
    <?php
    include_once "navigation.php";

    use App\classes\Ayat;
    use App\classes\Session;

    $ayat = new Ayat();
    $ayats = $ayat->getAllAyat();

    $paginator = $ayat->ayatPagination;
    ?>
    <main class="container-fluid">
        <div class="surah">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">List of all Ayat</h5>
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
                            <th>SL</th>
                            <th>Surah</th>
                            <th>Verse</th>
                            <th>Bangla</th>
                            <th>English</th>
                            <th>Arabic</th>
                            <th>Start</th>
                            <th>End</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach ($ayats as $key => $singleAyat) { ?>
                                <tr>
                                    <td><?php echo $singleAyat['id']; ?></td>
                                    <td><?php echo $singleAyat['surah_id']; ?></td>
                                    <td><?php echo $singleAyat['verse']; ?></td>
                                    <td><?php echo $singleAyat['ayat_text_arabic']; ?></td>
                                    <td><?php echo $singleAyat['ayat_text_bangla']; ?></td>
                                    <td><?php echo $singleAyat['ayat_text_english']; ?></td>
                                    <td><?php echo $singleAyat['start']; ?></td>
                                    <td><?php echo $singleAyat['end']; ?></td>
                                    <td class="text-center" width="12%">
                                        <ul class="list-unstyled list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="ayat/edit.php?id=<?php echo $singleAyat['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                            </li>
                                            <li class="list-inline-item">
                                                <form method="post" action="ayat/delete.php">
                                                    <input type="hidden" name="id" value="<?php echo $singleAyat['id']; ?>">
                                                    <input type="hidden" name="delete_ayat" value="1">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php if ($paginator->getNumPages() > 1) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <?php if ($paginator->getPrevUrl()) : ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo $paginator->getPrevUrl(); ?>">&laquo; Previous</a></li>
                                <?php endif; ?>

                                <?php foreach ($paginator->getPages() as $page) : ?>
                                    <?php if ($page['url']) : ?>
                                        <li class="page-item <?php echo $page['isCurrent'] ? 'active' : '' ?>">
                                            <a class="page-link" href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?></a>
                                        </li>
                                    <?php else : ?>
                                        <li class="disabled page-item"><a class="page-link"><?php echo $page['num']; ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if ($paginator->getNextUrl()) : ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo $paginator->getNextUrl(); ?>">Next &raquo;</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include BASE_PATH . "/footer.php" ?>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>