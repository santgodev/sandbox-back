<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table = 'activos';
    protected $primaryKey = 'ID_CLIENTE';
    protected $allowedFields = ['ID_ACTIVO', 'ID_CLIENTE', 'NOMBRE_ACTIVO', 'CATEGORIA', 'SERIAL', 'ACCESORIOS', 'INFORMACION'];

    public function listAssets()
    {
        $query = $this->select('*')
            ->get();
        return $query->getResult();
    }

    public function listAssetsByCustomerId($id)
    {
        $query = $this->select('activos.*, CONCAT(usuarios_clientes.NOMBRE, " ", usuarios_clientes.APELLIDO) as USUARIO')
            ->join('usuarios_clientes', 'usuarios_clientes.ID_USUARIO_CLIENTE = activos.ID_USUARIO')
            ->where('activos.ID_CLIENTE', $id)
            ->get();

        return $query->getResultArray();
    }

    public function insertAsset($data)
    {
        $query = $this->db->table('activos')->insert($data);
        if ($query) {
            return true;
        } else {
            return ['message' => 'Could not complete the insert'];
        }
    }

    public function updateAsset($data)
    {
        $query = $this->db->table('activos')->update($data, ['ID_ACTIVO' => $data['ID_ACTIVO']]);

        if ($query) {
            $assetData = $this->db->table('activos')
                ->select("*")
                ->get()
                ->getResultArray();
            return $assetData;
        } else {
            return ['message' => 'Could not complete the update'];
        }
    }

    public function deleteAsset($id)
    {
        $query = $this->select('*')
            ->where('ID_ACTIVO', $id)
            ->get();
        $deletedAsset = $query->getRowArray();
        if ($deletedAsset) {
            $this->db->table('activos')->delete(['ID_ACTIVO' => $id]);
            $query = $this->table("activos")->select("*")
                ->where('ID_CLIENTE', $deletedAsset["ID_CLIENTE"])
                ->get()
                ->getResultArray();
            return $query;
        } else {
            return ['message' => 'Asset not found'];
        }
    }
}
