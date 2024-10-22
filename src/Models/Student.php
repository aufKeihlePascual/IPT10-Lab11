<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    public $student_code, $email, $first_name, $last_name, $id;

    public function all()
    {
        $sql = "SELECT id, student_code, CONCAT(first_name, ' ' , last_name) AS name FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    public function getStudentCode() {
        return $this->student_code;
    }

    public function setStudentCode($code) {
        $this->student_code = $code;
    }

    public function find($id) {
        $sql = "SELECT * FROM students WHERE student_id = :student_id";
        $statement = $this->db->prepare($sql);
        $statement -> bindParam(':student_id', $id, PDO::PARAM_INT);
        $statement -> execute();

        return $statement -> fetchObject('App\Models\Student');
    }

}