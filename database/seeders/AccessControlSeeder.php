<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Student;
use App\Models\UserAccounts;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccessControlSeeder extends Seeder
{
    public function run(): void
    {
        $degreeIds = [
            'BSIT' => Degree::firstOrCreate(['name' => 'BSIT'])->id,
            'BSOA' => Degree::firstOrCreate(['name' => 'BSOA'])->id,
            'BEED' => Degree::firstOrCreate(['name' => 'BEED'])->id,
            'BTLED' => Degree::firstOrCreate(['name' => 'BTLED'])->id,
        ];

        $admins = [
            [
                'username' => 'admin01',
                'email' => 'admin01@matma.test',
                'password' => 'Admin12345',
            ],
            [
                'username' => 'admin02',
                'email' => 'admin02@matma.test',
                'password' => 'Admin12345',
            ],
        ];

        foreach ($admins as $admin) {
            UserAccounts::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'username' => $admin['username'],
                    'password' => Hash::make($admin['password']),
                    'role' => UserAccounts::ROLE_ADMIN,
                    'is_active' => 1,
                    'must_change_password' => true,
                ]
            );
        }

        $teachers = [
            [
                'username' => 'paulnigelabalos',
                'email' => 'paul.nigel.abalos@matma.test',
                'password' => 'Teacher12345',
            ],
            [
                'username' => 'rheneaviray',
                'email' => 'rhenea.viray@matma.test',
                'password' => 'Teacher12345',
            ],
            [
                'username' => 'cmarkaquino',
                'email' => 'cmark.aquino@matma.test',
                'password' => 'Teacher12345',
            ],
        ];

        foreach ($teachers as $teacher) {
            UserAccounts::updateOrCreate(
                ['email' => $teacher['email']],
                [
                    'username' => $teacher['username'],
                    'password' => Hash::make($teacher['password']),
                    'role' => UserAccounts::ROLE_TEACHER,
                    'is_active' => 1,
                    'must_change_password' => true,
                ]
            );
        }

        $students = [
            [
                'fname' => 'Alyssa',
                'lname' => 'Dela Cruz',
                'contactno' => '09170000001',
                'degree' => 'BSIT',
                'username' => 'alyssadcruz',
                'email' => 'alyssa.dcruz@matma.test',
            ],
            [
                'fname' => 'Marco',
                'lname' => 'Reyes',
                'contactno' => '09170000002',
                'degree' => 'BSOA',
                'username' => 'marcoreyes',
                'email' => 'marco.reyes@matma.test',
            ],
            [
                'fname' => 'Jessa',
                'lname' => 'Santos',
                'contactno' => '09170000003',
                'degree' => 'BEED',
                'username' => 'jessasantos',
                'email' => 'jessa.santos@matma.test',
            ],
            [
                'fname' => 'Kevin',
                'lname' => 'Mendoza',
                'contactno' => '09170000004',
                'degree' => 'BTLED',
                'username' => 'kevinmendoza',
                'email' => 'kevin.mendoza@matma.test',
            ],
            [
                'fname' => 'Trisha',
                'lname' => 'Flores',
                'contactno' => '09170000005',
                'degree' => 'BSIT',
                'username' => 'trishaflores',
                'email' => 'trisha.flores@matma.test',
            ],
        ];

        foreach ($students as $studentData) {
            $account = UserAccounts::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'username' => $studentData['username'],
                    'password' => Hash::make('Student12345'),
                    'role' => UserAccounts::ROLE_STUDENT,
                    'is_active' => 1,
                    'must_change_password' => true,
                ]
            );

            Student::updateOrCreate(
                ['user_account_id' => $account->id],
                [
                    'fname' => $studentData['fname'],
                    'lname' => $studentData['lname'],
                    'contactno' => $studentData['contactno'],
                    'degree_id' => $degreeIds[$studentData['degree']],
                ]
            );
        }
    }
}
