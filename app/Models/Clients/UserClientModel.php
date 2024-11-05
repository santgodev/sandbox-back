<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class UserClientModel extends Model
{
    protected $table = 'usuarios_clientes'; 
    protected $primaryKey = 'ID_USUARIO_CLIENTE';
    protected $allowedFields = ['ID_CLIENTE', 'NOMBRE', 'APELLIDO', 'CORREO', 'TELEFONO', 'ID_ROL']; 

    public function userClientList()
    {
        try {
            $query = $this->select('usuarios_clientes.*, clientes.NOMBRE_CLIENTE EMPRESA')
                ->join('clientes', 'clientes.ID_CLIENTE = usuarios_clientes.ID_CLIENTE')
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
                ->where('ID_USUARIO_CLIENTE', $id)
                ->get();

            return $query->getRowArray();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function userClientInsert($data)
    {
        try {
            $this->db->table('usuarios_clientes')->insert($data); 
            return $this->userClientList();
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function userClientUpdate($data)
    {
        try {
            $query=$this->db->table('usuarios_clientes')->update($data, ['ID_USUARIO_CLIENTE' => $data['ID_USUARIO_CLIENTE']]); 
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
