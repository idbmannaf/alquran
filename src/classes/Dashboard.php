<?php


namespace App\classes;

use App\classes\Database;


class Dashboard
{
    public $searchResult = [];
    public $postValue = [];

    function __construct()
    {
        $loggedIn = Session::getSessionData("loggedin");

        if (!$loggedIn) {
            header("Location: ".PROJECT_PATH."index.php");
        } else {
            $this->postValue = array(
                'ayat_from' => '',
                'ayat_to' => '',
                'ayat_language' => '',
                'ayat_type' => '',
                'surah_bangla_id' => '',
                'surah_english_id' => '',
                'surah_arabic_id' => '',
            );
            $this->db = new Database;
            $surahs = $this->getAllSurahs();

            if ($_POST) {
                $this->searchResult();
                $this->postValue = $_POST;
            }
        }
    }

    function getAllSurahs()
    {
        $query = "select * from surahs;";

        $queryResult = $this->db->rawQuery($query);
        return $queryResult->fetch_all(MYSQLI_ASSOC);
    }

    function searchResult()
    {
        $surahId = null;
        $ayatType = $_POST['ayat_type'];
        $ayatVerseFrom = (int)$_POST['ayat_from'];
        $ayatVerseTo = (int)$_POST['ayat_to'];
        $ayatLanguage = $_POST['ayat_language'];
        $query = "";

        if ($_POST['surah_bangla_id']) {
            $surahId = (int)$_POST['surah_bangla_id'];
        } elseif ($_POST['surah_english_id']) {
            $surahId = (int)$_POST['surah_english_id'];
        } elseif ($_POST['surah_arabic_id']) {
            $surahId = (int)$_POST['surah_arabic_id'];
        }

        if ($ayatType) {
            $query = "SELECT ayat.id,ayat.surah_id,ayat.verse,ayat.ayat_text_arabic,ayat.ayat_text_bangla,ayat.ayat_text_english,
                        surahs.arabic surah_arabic,surahs.bangla surah_bangla,surahs.english surah_english
                        FROM ayat 
                        INNER JOIN surahs on surahs.id = ayat.surah_id
                        WHERE ayat.surah_id = {$surahId} AND ayat.verse BETWEEN $ayatVerseFrom AND $ayatVerseTo";
        } else {
            $query = "SELECT ayat.id,ayat.surah_id,ayat.verse,ayat.ayat_text_arabic,ayat.ayat_text_bangla,ayat.ayat_text_english,
                        surahs.arabic surah_arabic,surahs.bangla surah_bangla,surahs.english surah_english
                        FROM ayat
                        INNER JOIN surahs on surahs.id = ayat.surah_id
                        WHERE ayat.surah_id = {$surahId}";
        }

        $executeQuery = $this->db->rawQuery($query);
        $queryResult = $executeQuery->fetch_all(MYSQLI_ASSOC);

        foreach ($queryResult as $key => $result) {
            $ayatText = "";
            if ($ayatLanguage == 'bangla') {
                $ayatText = $result['ayat_text_bangla'];
            } elseif ($ayatLanguage == 'english') {
                $ayatText = $result['ayat_text_english'];
            } elseif ($ayatLanguage == 'arabic') {
                $ayatText = $result['ayat_text_arabic'];
            }

            $this->searchResult['surah'] = array(
                'id' => $result['surah_id'],
                'arabic' => $result['surah_arabic'],
                'bangla' => $result['surah_bangla'],
                'english' => $result['surah_english']
            );

            $this->searchResult['ayats'][] = array(
                'id' => $result['id'],
                'surah_id' => $result['surah_id'],
                'verse' => $result['verse'],
                'ayat_text' => $ayatText,
                'bangla' => $result['ayat_text_bangla'],
                'arabic' => $result['ayat_text_arabic'],
                'english' => $result['ayat_text_english']
            );
        }

        // var_dump($this->searchResult);
    }
}