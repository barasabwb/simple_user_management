<?php
class Database
{
    private $dsn = "mysql:host=localhost;dbname=user_management";
    private $user = "root";
    private $pass = "barasa18";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);

        } catch (PDOException $e) {
            echo $e->getMessage();

        }
    }

    public function register($f_name, $l_name, $email, $pass){
        $pass = md5($pass);
        $check_user_sql = "SELECT user_id FROM users WHERE email= :email";
        $check_stmt = $this->conn->prepare($check_user_sql);
        $check_stmt->execute(['email'=>$email]);
        $result = $check_stmt->rowCount();
        if ($result == 0) {
            $sql = "INSERT INTO users (first_name,last_name,email,password) VALUES (:f_name, :l_name, :email, :pass)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['f_name'=>$f_name,'l_name'=>$l_name,'email'=>$email,'pass'=>$pass]);
            $_SESSION['register'] = true;
            $_SESSION['success_message'] = '<div class="alert alert-success">
  <strong>Success!</strong> You should <a href="#" class="alert-link">read this message</a>.
</div>';
            return "Successfully Registered";
        } else {
            return "Email Already Exists";
        }

          $sql = "INSERT INTO users (first_name,last_name,email,password) VALUES (:f_name, :l_name, :email, :pass)";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute(['f_name'=>$f_name,'l_name'=>$l_name,'email'=>$email,'pass'=>$pass]);
          return true;

  }
    public function login($email, $pass){
        $pass = md5($pass);
        $check_user_sql = "SELECT user_id FROM users WHERE email= :email AND password= :pass";
        $check_stmt = $this->conn->prepare($check_user_sql);
        $check_stmt->execute(['email'=>$email, 'pass'=>$pass]);
        $result = $check_stmt->rowCount();
        if ($result == 1) {
            $_SESSION['login'] = true;
            $_SESSION['email'] = $email;
            return true;
        } else {
            return false;
        }

        return true;

    }

    public function read(){
      $data = array();
      $sql = "SELECT * FROM users";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row){
          $data[] = $row;
      }
      return $data;

  }
    public function getById($id){

        $sql = "SELECT * FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }
    public function update($id,$f_name, $l_name, $email, $pass){
        $password=md5($pass);
        $sql = "UPDATE users SET first_name=:f_name,last_name=:l_name,email=:email,password=:password WHERE user_id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id,'f_name'=>$f_name,'l_name'=>$l_name,'email'=>$email,'password'=>$password]);
        return true;

    }
    public function delete($id){

        $sql = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;

    }
    public function totalRowCount(){
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;

    }

    public function session_login() {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
        return false;
    }
    public function session_register() {
        if (isset($_SESSION['register'])) {
            return $_SESSION['register'];
        }
        return false;
    }

    public function logout() {
        $_SESSION['login'] = false;
        session_destroy();
    }

}