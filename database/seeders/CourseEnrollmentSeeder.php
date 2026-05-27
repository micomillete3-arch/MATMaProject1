<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $courses = collect([
            'Programming 1',
            'Database Management',
            'Web Development',
            'Office Administration',
            'Teaching Strategies',
            'Technical Livelihood Education',
        ])->mapWithKeys(function (string $courseName): array {
            $course = Course::firstOrCreate(['course_name' => $courseName]);

            return [$courseName => $course->id];
        });

        $enrollments = [
            'alyssa.dcruz@matma.test' => [
                'Programming 1',
                'Database Management',
                'Web Development',
            ],
            'marco.reyes@matma.test' => [
                'Office Administration',
                'Database Management',
            ],
            'jessa.santos@matma.test' => [
                'Teaching Strategies',
                'Programming 1',
            ],
            'kevin.mendoza@matma.test' => [
                'Technical Livelihood Education',
                'Web Development',
            ],
            'trisha.flores@matma.test' => [
                'Programming 1',
                'Database Management',
            ],
        ];

        $students = Student::with('userAccount')->get()
            ->keyBy(fn (Student $student): ?string => $student->userAccount?->email);

        $timestamp = now();
        $rows = [];

        foreach ($enrollments as $email => $courseNames) {
            $student = $students->get($email);

            if (! $student) {
                continue;
            }

            foreach ($courseNames as $courseName) {
                $rows[] = [
                    'student_id' => $student->id,
                    'course_id' => $courses[$courseName],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        DB::table('course_student')->insertOrIgnore($rows);
    }
}
