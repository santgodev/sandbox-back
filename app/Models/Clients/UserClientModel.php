<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class UserClientModel extends Model
{
    protected $table = 'usuarios_clientes';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['NOMBRE', 'APELLIDO', 'CORREO'];

    public function getUserByEmail($email)
    {
        $query = $this->db->table('usuario')
            ->select('usuario.*, rol.DESCRIPCION as ROL_DESCRIPCION')
            ->join('rol', 'rol.ID_ROL = usuario.ID_ROL', 'left')
            ->where('usuario.CORREO', $email)
            ->get();

        return $query->getRowArray();
    }

    public function listUserById($id)
    {
        $query = $this->select(['NOMBRE', 'APELLIDO', 'CORREO', 'IMG_URL'])
            ->where('ID', $id)
            ->get();

        return $query->getResult();
    }

    public function listUsers()
    {
        $query = $this->select(['ID', 'NOMBRE', 'APELLIDO', 'CORREO', 'TELEFONO', 'NOMBRE_ROL'])
            ->join('rol', 'usuario.ID_ROL = rol.ID_ROL')
            ->get();

        return $query->getResult();
    }

    public function insertUser($data)
    {
        $query = $this->db->table('usuario')->insert($data);
        if ($query) {
            $userData = $this->db->table('usuario')
                ->select(['ID', 'NOMBRE', 'APELLIDO', 'CORREO', 'TELEFONO', 'NOMBRE_ROL'])
                ->join('rol', 'usuario.ID_ROL = rol.ID_ROL')
                ->where('CORREO', $data['CORREO'])
                ->orderBy('ID_')
                ->get()
                ->getRowArray();
            return [
                'user' => $userData
            ];
        } else {
            return ['message' => 'Could not complete the insert'];
        }
    }

    public function updateUser($data)
    {
        $query = $this->db->table('usuario')->update($data, ['CORREO' => $data['CORREO']]);

        if ($query) {
            $userData = $this->db->table('usuario')
                ->select("*")
                ->where('CORREO', $data['CORREO'])
                ->get()
                ->getRowArray();
            return [
                'message' => 'Update successful',
                'userData' => $userData
            ];
        } else {
            return ['message' => 'Could not complete the update'];
        }
    }

    public function deleteUser($id)
    {
        $query = $this->select('*')
            ->where('ID', $id)
            ->get();
        $deletedUser = $query->getRowArray();
        if ($deletedUser) {
            $this->db->table('deleted_users')->insert($deletedUser);
            $this->db->table('usuario')->delete(['ID' => $id]);
            return true;
        } else {
            return false;
        }
    }

    public function listRoles()
    {
        $query = $this->db->table('rol')
            ->select(['ID_ROL', 'NOMBRE_ROL', 'DESCRIPCION'])
            ->get();

        return $query->getResult();
    }
}
