<?php

namespace App\Models\Sinapptic;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'ID_ROL';
    protected $allowedFields = ['ID_ROL', 'NOMBRE_ROL', 'DESCRIPCION'];

    public function listRoleById($roleId)
    {
        $query = $this->select(['ID_ROL', 'NOMBRE_ROL', 'DESCRIPCION'])
            ->where('ID_ROL', $roleId)
            ->get();
        return $query->getResult();
    }

    public function listRoles()
    {
        $query = $this->db->table('rol')
            ->select(['ID_ROL', 'NOMBRE_ROL', 'DESCRIPCION'])
            ->get();

        return $query->getResult();
    }

    public function insertRole($data)
    {
        $query = $this->db->table('rol')->insert($data);
        if ($query) {
            $roleData = $this->db->table('rol')
                ->select("*")
                ->orderBy("ID_ROL")
                ->get()
                ->getResultArray();
            return $roleData;
        } else {
            return ['Message' => 'No se pudo completar el insert'];
        }
    }

    public function updateRole($data)
    {
        $query = $this->db->table('rol')->update($data, ['ID_ROL' => $data['ID_ROL']]);

        if ($query) {
            $roleData = $this->db->table('rol')
                ->select("*")
                ->where('ID_ROL', $data['ID_ROL'])
                ->get()
                ->getRowArray();
            return [
                'roleData' => $roleData
            ];
        } else {
            return ['message' => 'No se pudo completar el update'];
        }
    }

    public function deleteRole($roleId)
    {
        $query = $this->select('*')
            ->where('ID_ROL', $roleId)
            ->get();
        $roleToDelete = $query->getRowArray();
        if ($roleToDelete) {
            $this->db->table('rol')->delete(['ID_ROL' => $roleId]);
            return $this->db->table('rol')
                ->select("*")
                ->orderBy("ID_ROL")
                ->get()
                ->getResultArray();
        } else {
            return false;
        }
    }
}
