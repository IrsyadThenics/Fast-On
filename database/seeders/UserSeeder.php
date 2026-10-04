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

            if (in_array($role->role_code, ['VENDOR_TIANG', 'VENDOR_TIANG2'], true)) {
                Vendor::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nama' => $role->name, 'jenis' => 'TIANG']
                );
            }
            if (in_array($role->role_code, ['VENDOR_KONSTRUKSI', 'VENDOR_KONSTRUKSI2'], true)) {
                Vendor::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nama' => $role->name, 'jenis' => 'KONSTRUKSI']
                );
            }
        }

        $this->command->info('Akun dibuat/diperbarui. Password semua akun: password');
    }
}
