<?php

namespace App\Controllers\Sinapptic;

use App\Controllers\BaseController;
use App\Models\sinapptic\componentModel;

class ComponentController extends BaseController
{
    private $componentModel;
    public function __construct()
    {
        $this->componentModel = new ComponentModel();
    }

    public function listComponents(){
        $components=$this->componentModel->listComponents();
        return $this->response->setJSON($components);
    }


    public function listAuthorizedComponents(){
        $request = $this->request->getJSON();
        $idUser=$request->ID;
        $components = $this->componentModel->listAuthorizedComponents($idUser);
        if ($components) {
            return $this->response->setJSON($components);
        } else {
            return $this->response->setJSON(['error' => 'No se encontraron componentes autorizados']);
        }
    }
}