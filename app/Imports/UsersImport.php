<?php
namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToModel
{
    use Importable;

    private $importedUsers = [];

    public function model(array $row)
    {
        $userData = [
            'name' => $row[0],
            'email' => $row[1],
            'password' => $row[2],
            'level' => $row[3] ?? null,
        ];

        // Menyimpan data pengguna yang diimpor untuk validasi
        $this->importedUsers[] = $userData;

        // Tidak menyimpan ke database di sini karena akan divalidasi di controller
        return null;
    }

    public function getImportedUsers()
    {
        return $this->importedUsers;
    }
}
