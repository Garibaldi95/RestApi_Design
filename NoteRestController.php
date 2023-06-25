<?php

class NoteRestController
{
    public PDO $pdo;
    public function __construct(){
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO("mysql:host=test-mysql;
        db_name=note_db;charset=utf8","root","admin",$options);
    }

    public function process($id = null){
       $method = $_SERVER['REQUEST_METHOD'];

       $data = [];
       if ($id){
           if ($method == "GET"){
               $data = $this->retrieve($id);
           }elseif ($method == 'PUT'){
               $data = $this->update($id);
           }elseif ($method == 'DELETE'){
               $data = $this->remove($id);
           }
       } else {
           if ($method == 'GET'){
               $data = $this->list();
           }elseif($method == 'POST'){
               $data = $this->create();
           }
       }

//       header('Conten-type: application/json');
       return $data;
    }
    public function list(){
        $query = $this->pdo->query("SELECT * FROM note_db.note");
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }
    public function create(){
       $json = file_get_contents('php://input');
       $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

       $company = $data['company'] ?? '';
       $full_name = $data['full_name'] ?? '';
       $phone = $data['phone'] ?? '';
       $email = $data['email'] ?? '';
       $birth_date = $data['birth_date'] ?? '';
       $photo = $data['photo'] ?? '';

       $query = $this->pdo->prepare("
       INSERT INTO note_db.note(company, full_name, phone, email, birth_date, photo)
       VALUES (:company, :full_name, :phone, :email, :birth_date, :photo)
       ");
       $query->bindValue("company", $company);
       $query->bindValue("full_name", $full_name);
       $query->bindValue("phone", $phone);
       $query->bindValue("email", $email);
       $query->bindValue("birth_date", $birth_date);
       $query->bindValue("photo", $photo);
       $query->execute();
        $id = $this->pdo->lastInsertId();

       return $data['company'];
    }
    public function retrieve($id){
        $query = $this->pdo->prepare("SELECT * FROM note_db.note WHERE id= :id");
        $query->bindValue("id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $query = $this->pdo->prepare("SELECT * FROM note_db.note WHERE id= :id");
        $query->bindValue("id", $id);
        $query->execute();

        $unit = $query->fetch(PDO::FETCH_ASSOC);

        $query = $this->pdo->prepare("
        UPDATE note_db.note
        SET company=:company, full_name=:full_name, phone=:phone, email=:email, birth_date=:birth_date, photo=:photo
        WHERE id=:id
        ");
        $query->bindValue("id", $id);
        $query->bindValue("company", $data['company'] ?? $unit['company']);
        $query->bindValue("full_name", $data['full_name'] ?? $unit['full_name']);
        $query->bindValue("phone", $data['phone'] ?? $unit['phone']);
        $query->bindValue("email", $data['email'] ?? $unit['email']);
        $query->bindValue("birth_date", $data['birth_date'] ?? $unit['birth_date']);
        $query->bindValue("photo", $data['photo'] ?? $unit['photo']);
        $query->execute();

    }
    public function remove($id){
        $query = $this->pdo->prepare("DELETE  FROM note_db.note WHERE id= :id");
        $query->bindValue("id", $id);
        $query->execute();
    }
}