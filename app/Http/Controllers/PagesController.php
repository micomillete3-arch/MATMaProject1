<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function maintenance()
    {
        return view('maintenance');
    }

    public function add()
    {
        $a = 1;
        $b = 2;
        $sum = $a + $b;

        return "this is ur sum ".$sum;
    }

    public function userProfile()
    {
        $user = User::with('profile')->first();

        if (! $user) {
            return response('No bio yet.');
        }

        $profile = $user->profile()->firstOrCreate([]);
        $bio = $profile->bio ?: 'No bio yet.';

        return response($bio);
    }

    public function userPosts()
    {
        $user = User::with('posts')->first();

        if (! $user || $user->posts->isEmpty()) {
            return response('No posts found.');
        }

        $posts = $user->posts
            ->map(function ($post) {
                return e($post->title).' - '.e($post->content);
            })
            ->implode('<br>');

        return response($posts);
    }

    public function studentCourses()
    {
        $courseStudents = DB::table('course_student')
            ->join('students', 'students.id', '=', 'course_student.student_id')
            ->join('courses', 'courses.id', '=', 'course_student.course_id')
            ->orderBy('students.lname')
            ->orderBy('students.fname')
            ->orderBy('courses.course_name')
            ->select('students.fname', 'students.lname', 'courses.course_name')
            ->get()
            ->map(function ($row) {
                return (object) [
                    'student_name' => trim($row->fname.' '.$row->lname),
                    'course_name' => $row->course_name,
                ];
            });

        return view('studentCourses', compact('courseStudents'));
    }
}
