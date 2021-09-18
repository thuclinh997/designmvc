<?php
class Pages extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        if (!isset($_SESSION['user_id'])) {
            header("location:" . URLROOT . "users/login");
        }
    }
    public function index()
    {
        $users = $this->userModel->getUsers();
        $data = [
            'title' => 'Home page',
            'users' => $users
        ];
        $this->view('pages/index', $data);
    }
    public function about()
    {
        $this->view('pages/about');
    }
}
