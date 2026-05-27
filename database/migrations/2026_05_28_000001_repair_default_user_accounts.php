<?php

use App\Models\UserAccounts;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('user_accounts')) {
            return;
        }

        $timestamp = now();

        foreach ($this->defaultAccounts() as $account) {
            $existingId = DB::table('user_accounts')
                ->where('username', $account['username'])
                ->orWhere('email', $account['email'])
                ->value('id');

            $values = [
                'username' => $account['username'],
                'email' => $account['email'],
                'password' => Hash::make($account['password']),
                'role' => $account['role'],
                'is_active' => 1,
                'must_change_password' => false,
                'updated_at' => $timestamp,
            ];

            if ($existingId) {
                DB::table('user_accounts')
                    ->where('id', $existingId)
                    ->update($values);

                continue;
            }

            DB::table('user_accounts')->insert($values + [
                'created_at' => $timestamp,
            ]);
        }
    }

    public function down(): void
    {
        //
    }

    /**
     * @return array<int, array{username: string, email: string, password: string, role: string}>
     */
    private function defaultAccounts(): array
    {
        return [
            [
                'username' => 'admin01',
                'email' => 'admin01@matma.test',
                'password' => 'Admin12345',
                'role' => UserAccounts::ROLE_ADMIN,
            ],
            [
                'username' => 'admin02',
                'email' => 'admin02@matma.test',
                'password' => 'Admin12345',
                'role' => UserAccounts::ROLE_ADMIN,
            ],
            [
                'username' => 'paulnigelabalos',
                'email' => 'paul.nigel.abalos@matma.test',
                'password' => 'Teacher12345',
                'role' => UserAccounts::ROLE_TEACHER,
            ],
            [
                'username' => 'rheneaviray',
                'email' => 'rhenea.viray@matma.test',
                'password' => 'Teacher12345',
                'role' => UserAccounts::ROLE_TEACHER,
            ],
            [
                'username' => 'cmarkaquino',
                'email' => 'cmark.aquino@matma.test',
                'password' => 'Teacher12345',
                'role' => UserAccounts::ROLE_TEACHER,
            ],
            [
                'username' => 'alyssadcruz',
                'email' => 'alyssa.dcruz@matma.test',
                'password' => 'Student12345',
                'role' => UserAccounts::ROLE_STUDENT,
            ],
            [
                'username' => 'marcoreyes',
                'email' => 'marco.reyes@matma.test',
                'password' => 'Student12345',
                'role' => UserAccounts::ROLE_STUDENT,
            ],
            [
                'username' => 'jessasantos',
                'email' => 'jessa.santos@matma.test',
                'password' => 'Student12345',
                'role' => UserAccounts::ROLE_STUDENT,
            ],
            [
                'username' => 'kevinmendoza',
                'email' => 'kevin.mendoza@matma.test',
                'password' => 'Student12345',
                'role' => UserAccounts::ROLE_STUDENT,
            ],
            [
                'username' => 'trishaflores',
                'email' => 'trisha.flores@matma.test',
                'password' => 'Student12345',
                'role' => UserAccounts::ROLE_STUDENT,
            ],
        ];
    }
};
