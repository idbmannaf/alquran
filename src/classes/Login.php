<?php

namespace App\classes;

use App\classes\Database;
use App\classes\Session;

class Login {
    public $email = null;
    public $password = null;
    public $isValid = false;
    public $isLoggedIn = false;
    public $errors = [];

    function __construct()
    {
        $this->errors['email'] = null;
        $this->errors['password'] = null;

        $loggedIn = Session::getSessionData("loggedin");

        if ($loggedIn) {
            header("Location: ".PROJECT_PATH."dashboard.php");
        }

        if ($_POST) {
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];

            $this->validate();

            if ($this->isValid) {
                $this->loginUser();
            }
        }
    }

    function validate()
    {
        if (empty($this->email)) {
            $this->errors["email"] = "Please fillup the email.";
            $this->isValid = false;
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Please fillup valid email.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }

        if (empty($this->password)) {
            $this->errors["password"] = "Please fillup the password.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }
    }

    function loginUser()
    {
        $db = new Database;
        $query = "select * from users where email = '$this->email' limit 1";

        $queryResult = $db->rawQuery($query);

        if($queryResult->num_rows == 1) {
            $record = $queryResult->fetch_assoc();

            if(password_verify($this->password,$record['password'])) {
                $isAdmin = $record['role_id'] == 2 ? true : false;
                Session::setSessionData("loggedin",true);
                Session::setSessionData("isAdmin", $isAdmin);
                Session::setSessionData("email", $record['email']);
                Session::setSessionData("id", $record['id']);
                Session::setSessionData("fullname", $record['name']);

                $this->isLoggedIn = true;
            }
        }
    }

    public static function logout()
    {
        Session::clearSession();
    }
}
?>