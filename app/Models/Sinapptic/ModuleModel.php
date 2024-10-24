<?php

namespace App\Models\Sinapptic;

use CodeIgniter\Model;

class ModuleModel extends Model
{
    protected $table = 'modulo';
    protected $primaryKey = 'ID_MODULO';
    protected $allowedFields = ['TITULO', 'ICONO'];

    public function listModules()
    {
        $query = $this->select(['ID_MODULO', 'TITULO', 'ICONO'])
            ->get();
        return $query->getResultArray();
    }

    public function listAuthorizedModules($userId)
    {
        $query = $this
            ->select(['modulo.TITULO', 'modulo.ICONO', 'modulo.ID_MODULO'])
            ->join('componente', 'modulo.ID_MODULO = componente.ID_MODULO')
            ->join('permisos_componentes', 'permisos_componentes.ID_componente = componente.ID_componente')
            ->join('rol', 'permisos_componentes.ID_ROL = rol.ID_ROL')
            ->join('usuario', 'rol.ID_ROL = usuario.ID_ROL')
            ->where('permisos_componentes.VISTA', 1)
            ->where('usuario.ID', $userId)
            ->groupBy('ID_MODULO')
            ->get();
        return $query->getResult();
    }
}
