<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesCoursesTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_courses_page_handles_missing_courses(): void
    {
        $response = $this->get('/student_courses');

        $response->assertOk();
        $response->assertSee('No courses found.');
    }

    public function test_student_courses_page_shows_all_students_with_course_names(): void
    {
        $firstStudent = Student::create([
            'fname' => 'Mico',
            'lname' => 'Millete',
            'email' => 'mico@example.com',
            'contactno' => '09123456789',
        ]);

        $secondStudent = Student::create([
            'fname' => 'Jane',
            'lname' => 'Doe',
            'email' => 'jane@example.com',
            'contactno' => '09987654321',
        ]);

        $firstCourse = Course::create([
            'course_name' => 'Web Development',
        ]);

        $secondCourse = Course::create([
            'course_name' => 'Database Systems',
        ]);

        $firstStudent->courses()->attach([$firstCourse->id, $secondCourse->id]);
        $secondStudent->courses()->attach([$firstCourse->id]);

        $response = $this->get('/student_courses');

        $response->assertOk();
        $response->assertSeeInOrder([
            'Mico Millete is taking Web Development',
            'Mico Millete is taking Database Systems',
            'Jane Doe is taking Web Development',
        ]);
    }
}
