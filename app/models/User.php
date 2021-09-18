<?php
class User
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function register($data)
    {
        $this->db->query("INSERT INTO users(name, email, pass) VALUES (:name, :email, :password)");
        //Bind value
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function login($name, $password)
    {
        $this->db->query("SELECT * FROM users WHERE name =:name");
        //Bind value
        $this->db->bind(':name', $name);
        $row = $this->db->single();
        if ($row) {
            $hashedPassword = $row->pass;
            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");
        $result = $this->db->resultSet();
        return $result;
    }
    //Find user by email. Email is passed in the Controller
    public function findUserByEmail($email)
    {
        //Prerared statement
        $this->db->query("SELECT email FROM users WHERE email =:email");
        //Email param will be bindes with email variable
        $this->db->bind(':email', $email);
        //check if email is already registeres
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
