<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class UserClientModel extends Model
{
    protected $table = 'usuarios'; 
    protected $primaryKey = 'ID_USUARIO';
    protected $allowedFields = ['ID_CLIENTE', 'NOMBRE', 'APELLIDO', 'CORREO', 'TELEFONO', 'ID_ROL']; 

    public function userClientList()
    {
        try {
            $query = $this->select('usuarios.ID_USUARIO, usuarios.ID_USUARIO, usuarios.ID_ROL, usuarios.ID_CLIENTE, usuarios.NOMBRE, usuarios.APELLIDO, usuarios.CARGO, usuarios.USUARIO_DOMINIO, usuarios.CORREO, usuarios.CC, usuarios.TELEFONO, clientes.NOMBRE_CLIENTE AS EMPRESA')
                ->join('clientes', 'clientes.ID_CLIENTE = usuarios.ID_CLIENTE')
                ->get();
    
            return $query->getResult();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
    

    public function userClientGetById($id)
    {
        try {
            $query = $this->select('*')
                ->where('ID_USUARIO', $id)
                ->get();

            return $query->getRowArray();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function getUserByClientId($id)
    {
        try {
            $query = $this->db->table('usuarios')
                ->select('usuarios.*,  clientes.NOMBRE_CLIENTE AS EMPRESA')
                ->join('clientes', 'clientes.ID_CLIENTE = usuarios.ID_CLIENTE')
                ->where('usuarios.ID_CLIENTE', $id)
                ->get();

            return $query->getResultArray();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function userClientInsert($data)
    {
        try {
            $this->db->table('usuarios')->insert($data); 
            return $this->userClientList();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function userClientUpdate($data)
    {
        try {
            $query=$this->db->table('usuarios')->update($data, ['ID_USUARIO' => $data['ID_USUARIO']]); 
            if($query){
                return $this->userClientList(); 
            }
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
    public function updateClient($data)
    {
        $query = $this->db->table('clientes')->update($data, ['ID_CLIENTE' => $data['ID_CLIENTE']]);

        if ($query) {
            $clientsData = $this->listClients();
            return $clientsData;
        } else {
            return ['message' => 'Could not complete the update'];
        }
    }

    public function userClientDelete($id)
    {
        try {
            $user = $this->userClientGetById($id);
            if ($user) {
                $this->delete($id); 
                return $this->userClientList();
            } else {
                return ['message' => 'User not found'];
            }
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function userClientListRoles()
    {
        try {
            $query = $this->db->table('rol')
                ->select(['ID_ROL', 'NOMBRE_ROL', 'DESCRIPCION'])
                ->get();

            return $query->getResult();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
