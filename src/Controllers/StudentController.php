<?php

namespace App\Controllers;

use App\Models\Student;
use App\Controllers\BaseController;

class StudentController extends BaseController
{
    public function list()
    {
        $obj = new Student();
        $students = $obj->all();
        $total_students = count($students);

        $template = 'students';
        $data = [
            'items' => $students,
            'total_students' => $total_students
        ];

        $output = $this->render($template, $data);

        return $output;
    }
}