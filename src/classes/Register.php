<?php

namespace App\classes;

use App\classes\Database;

class Register {
    public $name = "";
    public $email = "";
    public $password = "";
    public $confirmPassword = "";
    public $createdAt = null;
    public $errors = [];
    public $isValid = false;
    public $roleId = 1;
    public $isUserCreated = false;

    function __construct()
    {
        $this->errors['name'] = null;
        $this->errors['email'] = null;
        $this->errors['password'] = null;
        $this->errors['confirm_password'] = null;
        $this->createdAt = date("Y-m-d H:i:s");

        $loggedIn = Session::getSessionData("loggedin");

        if ($loggedIn) {
            header("Location: ".PROJECT_PATH."dashboard.php");
        }

        if ($_POST) {
            $this->name = $_POST["name"];
            $this->email = $_POST["email"];
            $this->password = $_POST["password"];
            $this->confirmPassword = $_POST["confirm_password"];
            $this->validate();

            if ($this->isValid) {
                $this->createUser();
            }
        }
    }

    function validate()
    {
        if (empty($this->name)) {
            $this->errors["name"] = "Please fillup the name.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }

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
        } elseif ($this->password != $this->confirmPassword) {
            $this->errors["confirm_password"] = "Confirm password not match.";
            $this->isValid = false;
        } elseif (strlen($this->password) < 8) {
            $this->errors["password"] = "Minimum Password length is 8.";
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }
    }

    public function createUser()
    {
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (`name`,`email`,`password`,`role_id`,`created_at`) VALUES ('$this->name','$this->email','$password',$this->roleId,'$this->createdAt');";

        $db = new Database;
        $this->isUserCreated = $db->rawQuery($insertQuery);
    }
}
?>