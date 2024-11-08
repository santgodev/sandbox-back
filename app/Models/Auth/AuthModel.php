<?php

namespace App\Models\Auth;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'ID_USUARIO';
    protected $allowedFields = [
        'NOMBRE',
        'APELLIDO',
        'CARGO',
        'USUARIO_DOMINIO',
        'CORREO',
        'CC',
        'TELEFONO',
    ];
    public function registerUser() {}


    public function getUserByEmail($email)
    {
        $query = $this->db->table('usuarios')
            ->select(['CONTRASEÑA', 'ID_USUARIO', 'ID_ROL'])
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
            $DATA_USER = $this->db->table('usuarios')->select([
                'NOMBRE',
                'APELLIDO',
                'CARGO',
                'USUARIO_DOMINIO',
                'CORREO',
                'CC',
                'TELEFONO',])
                ->where('ID_USUARIO', $userPassword['ID_USUARIO'])
                ->get()
                ->getRowArray();
            $MAIN_DATA = $this->db->table('usuarios')->select(['ID_USUARIO', 'ID_ROL', 'ID_CLIENTE'])
                ->where('ID_USUARIO', $userPassword['ID_USUARIO'])
                ->get()
                ->getRowArray();
            $PERMISSIONS = $this->db->table('permisos_componentes')
                ->select(['componente.NOMBRE_COMPONENTE AS COMPONENTE',
                'permisos_componentes.ID_COMPONENTE','permisos_componentes.VISTA',
                 'permisos_componentes.CREAR', 'permisos_componentes.EDITAR',
                  'permisos_componentes.ELIMINAR'])
                ->join('rol', 'rol.ID_ROL = permisos_componentes.ID_ROL')
                ->join('componente', 'componente.ID_COMPONENTE = permisos_componentes.ID_COMPONENTE')
                ->where('permisos_componentes.ID_ROL', $userPassword['ID_ROL'])
                ->get()
                ->getResultArray();

            return [
                'DATA_USER' => $DATA_USER,
                'MAIN_DATA' => $MAIN_DATA,
                'PERMISSIONS' => $PERMISSIONS
            ];
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
