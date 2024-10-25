<?php

namespace App\Controllers;

require 'vendor/autoload.php';
use App\Models\Course;
use App\Controllers\BaseController;
use Fpdf\Fpdf;

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

    public function exportPDF($course_code) {
        $obj = new Course();

        $courses = $obj->all();
        $enrolees = $obj->getEnrolees($course_code);

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Course Information', 0, 1, 'C');
    
        foreach ($courses as $course) {
            if ($course->course_code == $course_code) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(50, 10, 'Course Code: ' . $course->course_code, 0, 1);
                $pdf->Cell(50, 10, 'Course Name: ' . $course->course_name, 0, 1);
                $pdf->Cell(50, 10, 'Description:', 0, 1);
                $pdf->SetX(20);
                $pdf->MultiCell(0, 10, $course->description); 
                $pdf->Ln(2); 
                $pdf->Cell(50, 10, 'Credits: ' . $course->credits, 0, 1);
                $pdf->Ln(10); 
                break;
            }
        }
    
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 10, 'List of Enrollees', 0, 1, 'C');
    
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Full Name', 1);
        $pdf->Cell(100, 10, 'Email', 1);
        $pdf->Ln();
    
        $pdf->SetFont('Arial', '', 12);
        foreach ($enrolees as $enrollee) {
            $pdf->Cell(40, 10, $enrollee["student_code"], 1);
            $pdf->Cell(50, 10, $enrollee["name"], 1);
            $pdf->Cell(100, 10, $enrollee["email"], 1);
            $pdf->Ln();
        }
    
        $pdf->Output('D', 'course_'.$course_code.'_enrollees.pdf');
    }

}
