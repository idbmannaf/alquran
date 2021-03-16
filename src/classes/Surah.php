<?php

namespace App\classes;

use App\classes\Database;
use App\classes\Session;

class Surah {
    public $arabic = null;
    public $bangla = null;
    public $english = null;
    public $start = null;
    public $end = null;
    public $file = null;
    public $isValid = false;
    public $isSurahCreated = false;
    public $isSurahUpdated = false;
    public $isSurahDeleted = false;
    public $errors = [];
    public $db = null;

    function __construct()
    {
        $this->errors['arabic'] = null;
        $this->errors['bangla'] = null;
        $this->errors['english'] = null;
        $this->errors['start'] = null;
        $this->errors['end'] = null;
        $this->errors['file'] = null;

        $loggedIn = Session::getSessionData("loggedin");
        $isAdmin = Session::getSessionData("isAdmin");

        if ($loggedIn && $isAdmin) {
            $this->db = new Database;

            if (isset($_POST['update_surah']) && $_POST['update_surah'] == 1) {
                $this->updateSurah();
            }

            if (isset($_POST['insert_surah']) && $_POST['insert_surah'] == 1) {
                $this->insertSurah();
            }

            if (isset($_POST['delete_surah']) && $_POST['delete_surah'] == 1) {
                $this->deleteSurah();
            }
        } else {
            header("Location: ".PROJECT_PATH."index.php");
        }
    }

    function validate()
    {
        if (empty($this->bangla)) {
            $this->errors["bangla"] = "Please fillup bangla text.";
            $this->isValid = false;
        } else if (empty($this->arabic)) {
            $this->errors["arabic"] = "Please fillup arabic text.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }
    }

    function getAllSurahs()
    {
        $query = "select * from surahs;";

        $queryResult = $this->db->rawQuery($query);
        return $queryResult->fetch_all(MYSQLI_ASSOC);
    }

    function insertSurah()
    {
        if ($_POST) {
            $this->english = $_POST['english'];
            $this->bangla = $_POST['bangla'];
            $this->arabic = $_POST['arabic'];
            $this->start = $_POST['start'];
            $this->end = $_POST['end'];
            $file = $_FILES['file'];

            $this->validate();

            if ($this->isValid) {
                $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $filename = "surah-" . time() . "." . $extension;
                $desination = BASE_PATH . "/assets/audio/" . $filename;
                $createdAt = date('Y-m-d H:i:s');

                if (move_uploaded_file($file["tmp_name"], $desination)) {
                    $this->file = $filename;
                    $query = "INSERT INTO surahs (`arabic`,`bangla`,`english`,`start`,`end`,`file`,`created_at`) VALUES ('$this->arabic','$this->bangla','$this->english','$this->start','$this->end','$this->file','$createdAt')";
                    $this->isSurahCreated = $this->db->rawQuery($query);
                }
                
                if($this->isSurahCreated) {
                    Session::setSessionData('flash_message', 'Surah Created');
                } else {
                    Session::setSessionData('flash_message', 'Error');
                }
            }

            $redirectUrl = PROJECT_PATH . 'surah.php';
            header("Location: {$redirectUrl}");
        }
    }

    function getSurah($surahId)
    {
        $surah = null;
        $query = "select * from surahs where id = '$surahId' limit 1";
        $queryResult = $this->db->rawQuery($query);

        if($queryResult->num_rows == 1) {
            $surah = $queryResult->fetch_assoc();
        }

        return $surah;
    }

    function updateSurah()
    {
        if ($_POST) {
            $this->english = $_POST['english'];
            $this->bangla = $_POST['bangla'];
            $this->arabic = $_POST['arabic'];
            $this->start = $_POST['start'];
            $this->end = $_POST['end'];
            $file = $_FILES['file'];
            $id = $_POST['id'];

            $this->validate();

            if ($this->isValid) {
                $surah = $this->getSurah($id);

                if($surah) {
                    $updatedAt = date('Y-m-d H:i:s');

                    if ($file['name']) {
                        $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                        $filename = "surah-" . time() . "." . $extension;
                        $desination = BASE_PATH . "/assets/audio/" . $filename;
                        if (move_uploaded_file($file["tmp_name"], $desination)) {
                            $this->file = $filename;

                            $previousSurahFile = BASE_PATH . "/assets/audio/" . $surah['file'];
                            unlink($previousSurahFile);

                            $query = "UPDATE surahs SET `arabic` = '$this->arabic',`bangla` = '$this->bangla',`english` = '$this->english',`start` = '$this->start',`end` = '$this->end',`file` = '$this->file',`updated_at` = '$updatedAt' WHERE id = '$id'";
                            $this->isSurahUpdated = $this->db->rawQuery($query);
                            Session::setSessionData('flash_message', 'Surah Updated');
                        } else {
                            Session::setSessionData('flash_message', 'Error on Update');
                        }
                    } else {
                        $query = "UPDATE surahs SET `arabic` = '$this->arabic',`bangla` = '$this->bangla',`english` = '$this->english',`start` = '$this->start',`end` = '$this->end',`updated_at` = '$updatedAt' WHERE id = '$id'";
                        $this->isSurahUpdated = $this->db->rawQuery($query);
                        Session::setSessionData('flash_message', 'Surah Updated');
                    }
                } else {
                    Session::setSessionData('flash_message', 'Surah not found.');
                }

                $redirectUrl = PROJECT_PATH . 'surah.php';

                header("Location: {$redirectUrl}");
            }
        }
    }

    function deleteSurah()
    {
        if ($_POST) {
            $surahId = $_POST['id'];
            $query = "DELETE FROM surahs WHERE id = $surahId";

            if ($this->db->rawQuery($query)) {
                Session::setSessionData('flash_message', 'Surah Deleted');
            } else {
                Session::setSessionData('flash_message', 'Error');
            }

            $redirectUrl = PROJECT_PATH.'surah.php';

            header("Location: {$redirectUrl}");
        }
    }
}
?>