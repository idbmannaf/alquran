<?php

namespace App\classes;

use App\classes\Database;
use App\classes\Session;
use JasonGrimes\Paginator;

class Ayat {
    public $surahId = null;
    public $verse = null;
    public $ayatTextArabic = null;
    public $ayatTextBangla = null;
    public $ayatTextEnglish = null;
    public $start = null;
    public $end = null;
    public $isValid = false;
    public $isAyatCreated = false;
    public $isAyatUpdated = false;
    public $isAyatDeleted = false;
    public $errors = [];
    public $loggedIn = false;
    public $isAdmin = false;
    public $db = null;
    public $ayatPagination;
    public $itemsPerPage = 12;
    public $currentPage = 1;

    function __construct()
    {
        $this->errors['surah_id'] = null;
        $this->errors['verse'] = null;
        $this->errors['ayat_text_arabic'] = null;
        $this->errors['ayat_text_bangla'] = null;
        $this->errors['ayat_text_english'] = null;
        $this->errors['start'] = null;
        $this->errors['end'] = null;

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $this->currentPage = $_GET['page'];
        }

        $loggedIn = Session::getSessionData("loggedin");
        $isAdmin = Session::getSessionData("isAdmin");

        if ($loggedIn && $isAdmin) {
            $this->db = new Database;

            if (isset($_POST['update_ayat']) && $_POST['update_ayat'] == 1) {
                $this->updateAyat();
            }

            if (isset($_POST['insert_ayat']) && $_POST['insert_ayat'] == 1) {
                $this->insertAyat();
            }

            if (isset($_POST['delete_ayat']) && $_POST['delete_ayat'] == 1) {
                $this->deleteAyat();
            }
        } else {
            header("Location: ".PROJECT_PATH."index.php");
        }
    }

    function validate()
    {
        if (empty($this->surahId)) {
            $this->errors["surah_id"] = "Please fillup Surah.";
            $this->isValid = false;
        } else if (empty($this->verse)) {
            $this->errors["verse"] = "Please fillup verse.";
            $this->isValid = false;
        } else if (empty($this->ayatTextArabic)) {
            $this->errors["ayat_text_arabic"] = "Please fillup arabic text.";
            $this->isValid = false;
        } else if (empty($this->ayatTextEnglish)) {
            $this->errors["ayat_text_english"] = "Please fillup english text.";
            $this->isValid = false;
        } else if (empty($this->ayatTextBangla)) {
            $this->errors["ayat_text_bangla"] = "Please fillup bangla text.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }
    }

    function getAllAyat()
    {
        $query = "select * from ayat;";

        $queryResult = $this->db->rawQuery($query);
        $ayats = $queryResult->fetch_all(MYSQLI_ASSOC);

        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $ayatResult = array_slice($ayats, $offset, $this->itemsPerPage);

        $totalItems = count($ayats);
        $itemsPerPage = $this->itemsPerPage;
        $currentPage = $this->currentPage;
        $urlPattern = PROJECT_PATH.'ayat.php?page=(:num)';

        $this->ayatPagination = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $ayatResult;
    }

    function insertAyat()
    {
        if ($_POST) {
            $this->english = $_POST['surah_id'];
            $this->bangla = $_POST['verse'];
            $this->arabic = $_POST['ayat_text_arabic'];
            $this->arabic = $_POST['ayat_text_bangla'];
            $this->arabic = $_POST['ayat_text_english'];
            $this->start = $_POST['start'];
            $this->end = $_POST['end'];

            $this->validate();

            if ($this->isValid) {
                $createdAt = date('Y-m-d H:i:s');
                $query = "INSERT INTO ayat (`surah_id`,`verse`,`ayat_text_arabic`,`ayat_text_bangla`,`ayat_text_english`,`start`,`end`,`created_at`) 
                            VALUES ('$this->surahId','$this->verse','$this->ayatTextArabic','$this->ayatTextBangla',
                            '$this->ayatTextEnglish','$this->start','$this->end','$createdAt')";

                $this->isAyatCreated = $this->db->rawQuery($query);
            }
        }
    }

    function getAllSurahs()
    {
        $query = "select * from surahs;";

        $queryResult = $this->db->rawQuery($query);
        return $queryResult->fetch_all(MYSQLI_ASSOC);
    }

    function getAyat($ayatId)
    {
        $ayat = null;
        $query = "select * from ayat where id = '$ayatId' limit 1";
        $queryResult = $this->db->rawQuery($query);

        if($queryResult->num_rows == 1) {
            $ayat = $queryResult->fetch_assoc();
        }

        return $ayat;
    }

    function updateAyat()
    {
        $this->surahId = $_POST['surah_id'];
        $this->verse = $_POST['verse'];
        $this->ayatTextArabic = $_POST['ayat_text_arabic'];
        $this->ayatTextBangla = $_POST['ayat_text_bangla'];
        $this->ayatTextEnglish = $_POST['ayat_text_english'];
        $this->start = $_POST['start'];
        $this->end = $_POST['end'];
        $id = $_POST['id'];

        $this->validate();

        if ($this->isValid) {
            $updatedAt = date('Y-m-d H:i:s');
            $query = "UPDATE ayat SET `surah_id`='$this->surahId',`verse`='$this->verse',
                `ayat_text_arabic`='$this->ayatTextArabic',
                `ayat_text_bangla`='$this->ayatTextBangla',`ayat_text_english`='$this->ayatTextEnglish',
                `start`='$this->start',`end`='$this->end',
                `updated_at`='$updatedAt' WHERE id='$id'";
            $this->isAyatUpdated = $this->db->rawQuery($query);
            // var_dump($this->isAyatUpdated);
            // exit();

            if ($this->isAyatUpdated) {
                Session::setSessionData('flash_message', 'Ayat Updated');
            } else {
                Session::setSessionData('flash_message', 'Error on Update');
            }

            $redirectUrl = PROJECT_PATH.'ayat/edit.php?id='.$id;
            // echo $redirectUrl;
            // exit();

            header("Location: {$redirectUrl}");
        }
    }

    function deleteAyat()
    {
        $ayatId = (int)$_POST['id'];
        $query = "DELETE FROM ayat WHERE id = $ayatId";

        if ($this->db->rawQuery($query)) {
            Session::setSessionData('flash_message', 'Ayat Deleted');
        } else {
            Session::setSessionData('flash_message', 'Error');
        }

        $redirectUrl = PROJECT_PATH.'ayat.php';

        header("Location: {$redirectUrl}");
    }
}
?>