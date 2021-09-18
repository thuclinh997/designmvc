<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header("location:" . URLROOT . 'pages/');
        } else {
            $data = [
                'title' => 'Login page',
                'name' => '',
                'password' => '',
                'userNameError' => '',
                'passwordError' => ''
            ];
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'name' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'userNameError' => '',
                    'passwordError' => ''
                ];
                //validate user name
                if (empty($data['name'])) {
                    $data['userNameError'] = "Please enter a user name.";
                }
                if (empty($data['password'])) {
                    $data['passwordError'] = "please enter a password";
                }
                if (empty($data['userNameError']) && empty($data['passwordError'])) {
                    $loggedInUser = $this->userModel->login($data['name'], $data['password']);
                    if ($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['passwordError'] = "Password or user name is incorrect. Please try again.";
                        $this->view('users/login', $data);
                    }
                }
                header("location:" . URLROOT . 'pages/');
            } else {
                $data = [
                    'title' => 'Login page',
                    'name' => '',
                    'password' => '',
                    'userNameError' => '',
                    'passwordError' => ''
                ];
            }
            $this->view("users/login", $data);
        }
    }
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
    }
    public function register()
    {
        $data = [
            'title' => 'Register page',
            'userNameError' => '',
            'passwordError' => '',
            'emailError' => '',
            'confirmPasswordError' => '',
            'name' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => ''
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //santize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'userNameError' => '',
                'passwordError' => '',
                'emailError' => '',
                'confirmPasswordError' => '',
                'name' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword'])
            ];
            $nameValidatation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";
            //validate username on letters/ number
            if (empty($data['name'])) {
                $data['userNameError'] = "Please enter user name.";
            } elseif (!preg_match($nameValidatation, $data['name'])) {
                $data['userNameError'] = "Name can only contain letters and number.";
            }
            //validate email
            if (empty($data['email'])) {
                $data['emailError'] = "Please enter email.";
            } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = "Please enter the correct format.";
            } else {
                //Check if email exists.
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['emailError'] = "Email is already taken.";
                }
            }
            //validate password on length and numeric values
            if (empty($data['password'])) {
                $data['passwordError'] = "Please enter password";
            } else if (strlen($data['password'] < 6)) {
                $data['passwordError'] = "Password must be at least 8 characters.";
            } else if (preg_match($passwordValidation, $data['password'])) {
                $data['passwordError'] = "Password must have at least one numeric value.";
            }
            //Validate confirm password
            if (empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = "Please enter confirm password";
            } else {
                if ($data['password'] != $data['confirmPassword']) {
                    $data['confirmPasswordError'] = "Password do not match, please try again";
                }
            }
            //Make sure that errors are empty
            if (
                empty($data['userNameError'])
                && empty($data['emailError'])
                && empty($data['passwordError'])
                && empty($data['confirmPasswordError'])
            ) {
                //Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //Register user form model function
                if ($this->userModel->register($data)) {
                    //Redirect to the login page
                    header("location: " . URLROOT . "/users/login");
                } else {
                    die("Something went wrong");
                }
            }
        }
        $this->view('users/register', $data);
    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header("location:" . URLROOT . "users/login");
    }
}
