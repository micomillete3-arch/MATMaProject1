<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('course_student')) {
            return;
        }

        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $database = DB::getDatabaseName();

        $uniqueExists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'course_student')
            ->where('index_name', 'course_student_student_id_course_id_unique')
            ->exists();

        $studentForeignExists = DB::table('information_schema.key_column_usage')
            ->where('table_schema', $database)
            ->where('table_name', 'course_student')
            ->where('constraint_name', 'course_student_student_id_foreign')
            ->exists();

        $courseForeignExists = DB::table('information_schema.key_column_usage')
            ->where('table_schema', $database)
            ->where('table_name', 'course_student')
            ->where('constraint_name', 'course_student_course_id_foreign')
            ->exists();

        Schema::table('course_student', function (Blueprint $table) use ($uniqueExists, $studentForeignExists, $courseForeignExists) {
            if (! $uniqueExists) {
                $table->unique(['student_id', 'course_id']);
            }

            if (! $studentForeignExists) {
                $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            }

            if (! $courseForeignExists) {
                $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('course_student')) {
            return;
        }

        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        Schema::table('course_student', function (Blueprint $table) {
            $table->dropUnique('course_student_student_id_course_id_unique');
            $table->dropForeign(['student_id']);
            $table->dropForeign(['course_id']);
        });
    }
};
