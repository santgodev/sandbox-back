<?php

namespace App\Controllers\Sinapptic;

use App\Controllers\BaseController;
use App\Models\Sinapptic\ComponentModel;
use App\Models\Sinapptic\ModuleModel;

class ModuleController extends BaseController
{
    private $moduleModel;
    private $componentModel;

    public function __construct()
    {
        $this->moduleModel = new ModuleModel();
        $this->componentModel = new ComponentModel();
    }

    public function listModules()
    {
        $modules = $this->moduleModel->listModules();
        return $this->response->setJSON($modules);
    }

    public function listModules_Components()
    {
        $modules = $this->moduleModel->listModules();
        $modulesArray = [];
        
        foreach ($modules as $module) {
            $componentsArray = $this->componentModel->listComponentsByModuleId($module['ID_MODULO']);
            $modulesArray[] = [
                'ID_MODULO' => $module['ID_MODULO'],
                'TITULO' => $module['TITULO'],
                'ICONO' => $module['ICONO'],
                'COMPONENTS' => $componentsArray
            ];
        }

        return $this->response->setJSON($modulesArray);
    }

    public function listAuthorizedModules()
    {
        $userId = $this->request->getJSON('ID');
        $components = $this->moduleModel->listAuthorizedModules($userId);
        if ($components) {
            return $this->response->setJSON($components);
        } else {
            return $this->response->setJSON(['error' => 'No se encontraron componentes autorizados']);
        }
    }
}
