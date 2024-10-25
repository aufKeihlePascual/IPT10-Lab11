<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    
    public $course_code, $course_name;

    public function all()
    {
        $sql = "SELECT * FROM courses";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    public function find($course_code)
    {
        $sql = "SELECT * FROM courses WHERE course_code=?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$course_code]);
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.student_code AS student_code, CONCAT(s.first_name, ' ', s.last_name) AS name, s.email
                FROM course_enrollments ce
                LEFT JOIN students s ON (s.student_code = ce.student_code)
                WHERE ce.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code
        ]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function getCourseCode() {
        return $this->course_code;
    }

    public function getCourseName() {
        return $this->course_name;
    }

}