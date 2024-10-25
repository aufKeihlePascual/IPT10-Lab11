<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    public $student_code;

    public function all()
    {
        $sql = "SELECT s.student_code, CONCAT(first_name, ' ', last_name) AS name,
                email, DATE_FORMAT(date_of_birth, '%M %d, %Y') AS birthdate, sex, GROUP_CONCAT(c.course_code ORDER BY c.course_code SEPARATOR ', ') AS course_codes
                FROM students s LEFT JOIN course_enrollments ce
                ON s.student_code = ce.student_code
                LEFT JOIN courses c
                ON ce.course_code = c.course_code
                GROUP BY s.id";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    public function getStudentCode() {
        return $this->student_code;
    }

    public function setStudentCode($student_code) {
        $this->student_code = $student_code;
    }

    public function find($id) {
        $sql = "SELECT * FROM students WHERE student_id = ?";
        $statement = $this->db->prepare($sql);
        $statement -> bindParam(':student_id', $id, PDO::PARAM_INT);
        $statement -> execute();

        return $statement -> fetchObject('App\Models\Student');
    }

}