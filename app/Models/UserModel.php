<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // SESUAIKAN DENGAN NAMA TABEL DI DATABASE
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'nama']; // SESUAIKAN DENGAN NAMA KOLOM DI DATABASE

    protected $useTimestamps = true; // Jika tabel users punya created_at/updated_at
    protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // Otomatis hash password sebelum insert/update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}