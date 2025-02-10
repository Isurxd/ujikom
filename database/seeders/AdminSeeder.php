<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_pegawai'   => 'Admin',
            'email'          => 'admin@gmail.com',
            'password'       => Hash::make('12345678'),
            'is_admin'       => 1,
            'status_pegawai' => 1,
        ]);
    }
}
