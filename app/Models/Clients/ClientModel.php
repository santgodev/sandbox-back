<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'ID_CLIENTE';
    protected $allowedFields = ['NOMBRE_CLIENTE', 'NIT', 'TELEFONO', 'DIRECCION', 'INFORMACION'];

    public function listClients()
    {
        $query = $this->select("*")
            ->get();
        return $query->getResult();
    }

    public function listClientById($id)
    {
        $query = $this->select('*')
            ->where('ID_CLIENTE', $id)
            ->get();
        return $query->getRowArray();
    }

    public function insertClient($data)
    {
        try {
            $query = $this->db->table('clientes')->insert($data); 
            
            if ($query) {
                $clientData = $this
                    ->select("*")
                    ->orderBy('ID_CLIENTE')
                    ->get()
                    ->getResultArray();
                return $clientData;
            } else {
                return ['message' => 'Could not complete the insert'];
            }
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
    
    

    public function updateClient($data)
    {
        $query = $this->update($data, ['ID_CLIENTE' => $data['ID_CLIENTE']]);

        if ($query) {
            $clientData = $this
                ->select("*")
                ->get()
                ->getResultArray();
            return $clientData;
        } else {
            return ['message' => 'Could not complete the update'];
        }
    }

    public function deleteClient($id)
    {
        $query = $this->select('*')
            ->where('ID_CLIENTE', $id)
            ->get();
        $deletedClient = $query->getRowArray();
        if ($deletedClient) {
            $this->delete(['ID_CLIENTE' => $id]);
            $query = $this->table("clientes")->select("*")
                ->get()
                ->getResultArray();
            return $query;
        } else {
            return ['message' => 'Client not found'];
        }
    }
}
