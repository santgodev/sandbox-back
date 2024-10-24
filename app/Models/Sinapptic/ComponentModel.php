<?php

namespace App\Models\Sinapptic;

use CodeIgniter\Model;

class ComponentModel extends Model
{
    protected $table = 'componente';
    protected $primaryKey = 'ID_componente';
    protected $allowedFields = ['TITULO', 'ICONO'];
    
    public function listComponents()
    {
        $query = $this->select('*')
            ->get()
            ->getResultArray();
        return $query;
    }

    public function listComponentsByModuleId($moduleId)
    {
        $query = $this->select('*')
            ->where('ID_MODULO', $moduleId)
            ->get()
            ->getResultArray();
        return $query;
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

    public function listComponentById($id)
    {
        $query = $this->select(['NOMBRE_COMPONENTE', 'ICONO', 'RUTA'])
            ->where('ID_COMPONENTE', $id)
            ->get()
            ->getResult();
        return $query;
    }
}
