<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;

class CourseController extends BaseController
{
    public function list()
    {
        $obj = new Course();
        $courses = $obj->all();

        $template = 'courses';
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrolees = $courseObj->getEnrolees($course_code);
        $total_enrolees = count($enrolees);

        $template = 'single-course';
        $data = [
            'course' => $course,
            'enrolees' => $enrolees,
            'total_enrolees' => $total_enrolees
        ];

        $output = $this->render($template, $data);

        return $output;
    }
}
