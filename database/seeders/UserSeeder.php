<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Role::orderBy('id')->get() as $role) {
            $user = User::updateOrCreate(
                ['user_id' => $role->role_code],
                [
                    'password' => Hash::make('password'),
                    'role_id'  => $role->id,
                    'aktif'    => true,
                ]
            );

            if (in_array($role->role_code, ['5180T1', '5180T2', '5180T3', '5180T4', '5180T5', '5180T6', '5180T7', '5180T8', '5180T9'], true)) {
                Vendor::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nama' => $role->name, 'jenis' => 'TIANG']
                );
            }
            if (in_array($role->role_code, ['5180K1', '5180K2'], true)) {
                Vendor::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nama' => $role->name, 'jenis' => 'KONSTRUKSI']
                );
            }
        }

        $this->command->info('Akun dibuat/diperbarui. Password semua akun: password');
    }
}
