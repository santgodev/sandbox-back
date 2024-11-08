<?php

namespace App\Models\Clients;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table = 'activos';
    protected $primaryKey = 'ID_ACTIVO';
    protected $allowedFields = ['ID_ACTIVO', 'ID_USUARIO_CLIENTE', 'NOMBRE_ACTIVO', 'CATEGORIA', 'MARCA', 'REFERENCIA', 'SERIAL', 'ESTADO', 'NOVEDADES'];

    public function listAssets()
    {
        $query = $this->db->table('activos')
            ->select('*')
            ->orderBy('ID_ACTIVO')
            ->get();
        return $query->getResultArray();
    }
    public function listAssetsByUserClientId($id)
    {
        try {
            $query = $this->db->table('activos')->select('*')->where('ID_USUARIO_CLIENTE', $id)->get()->getResultArray();
            if ($query) {
                return $query;
            } else
                return [];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
    public function listAssetsByClientId($id)
    {

        $query = $this->db->table('activos')            
            ->select('*')
            ->join('usuarios_clientes','usuarios_clientes.ID_USUARIO_CLIENTE = activos.ID_USUARIO_CLIENTE')
            ->join('clientes','clientes.ID_CLIENTE = usuarios_clientes.ID_CLIENTE')
            ->where('clientes.ID_CLIENTE',$id)
            ->orderBy('activos.ID_ACTIVO')
            ->get();
        return $query->getResultArray();
    }
  

    public function listFreeAssets()
    {
        $query = $this->db->table('activos')
            ->select('*')
            ->where('ID_USUARIO_CLIENTE',null)
            ->orderBy('ID_ACTIVO')
            ->get();
        return $query->getResultArray();
    }

    public function listAuthorizedComponents($userId)
    {
        $query = $this
            ->select(['componente.NOMBRE_COMPONENTE', 'componente.ICONO AS ICONO_COMPONENTE', 'componente.RUTA', 'modulo.ID_MODULO'])
            ->join('modulo', 'modulo.ID_MODULO = componente.ID_MODULO')
            ->join('permisos_componentes', 'permisos_componentes.ID_componente = componente.ID_componente')
            ->join('rol', 'permisos_componentes.ID_ROL = rol.ID_ROL')
            ->join('usuario', 'rol.ID_ROL = usuario.ID_ROL')
            ->where('permisos_componentes.VISTA', 1)
            ->where('usuario.ID', $userId)
            ->get();
        return $query->getResult();
    }



    public function insertAsset($data)
    {
        $query = $this->db->table('activos')->insert($data);
        if ($query) {
            return $this->listAssets();;
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
            $query = $this->listAssets();
            return $query;
        } else {
            return ['message' => 'Asset not found'];
        }
    }
    public function assingUser($data)
    {
        try {
            $query = $this->db->table('activos')->update($data, ['ID_ACTIVO' => $data['ID_ACTIVO']]);
            if ($query) {
                return $this->listAssetsByUserClientId($data['ID_USUARIO_CLIENTE']);
            }
            return false;
        } catch (\Exception $e) {
            return $e;     
        }
    }
    public function undessingUser($data)
    {
        try {
            $query = $this->db->table('activos')->update($data, ['ID_ACTIVO' => $data['ID_ACTIVO']]);
            if ($query) {
                return $this->listFreeAssets();
            }
            return false;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
