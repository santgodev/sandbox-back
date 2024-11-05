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
                $clientsData = $this->listClients();
                return $clientsData;
            } else {
                return ['message' => 'Could not complete the insert'];
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

    public function deleteClient($id)
    {
        try {
            $query = $this->select('*')
                ->where('ID_CLIENTE', $id)
                ->get()
                ->getRowArray();

            if ($query) {
                $this->db->table('clientes')->delete(['ID_CLIENTE' => $id]);
                return $this->listClients();
            } else {
                return ['message' => 'Client not found'];
            }
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
