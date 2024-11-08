<?php

namespace App\Models\Auth;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'ID_USUARIO';
    protected $allowedFields = ['username', 'password', 'email', 'created_at', 'updated_at'];

    public function registerUser() {}


    public function getUserByEmail($email)
    {
        $query = $this->db->table('usuarios')
            ->select('CONTRASEÑA')
            ->where('CORREO', $email)
            ->get();
        return $query->getRowArray();
    }

    public function login($email, $password)
    {
        $userPassword = $this->getUserByEmail($email);
        if (!$userPassword) {
            return ['messaje' => 'user not found'];
        }
        if ($userPassword['CONTRASEÑA'] === $password) {
            $query = $this->db->table('usuarios')
                ->select('usuarios.*, rol.DESCRIPCION as ROL_DESCRIPCION')
                ->join('rol', 'rol.ID_ROL = usuarios.ID_ROL', 'left')
                ->where('usuarios.CORREO', $email)
                ->get()
                ->getRowArray();
            return $query;
        }
        return ['messaje' => 'incorrect password'];
    }

    public function loginUserClient() {}

    public function validateCredentials() {}


    public function getUserById() {}


    public function updateUser() {}


    public function deleteUser() {}


    public function changePassword() {}


    public function isUserActive() {}
}
