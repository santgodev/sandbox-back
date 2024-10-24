<?php

namespace App\Controllers\Sinapptic;

use App\Controllers\BaseController;
use App\Models\sinapptic\rolModel;

class rolController extends BaseController
{
    private $rolModel;
    public function __construct()
    {
        $this->rolModel = new rolModel();
    }

    public function listarRoles()
    {
        $data = $this->rolModel->listarRoles();
        return  $this->response->setJSON($data);
    }
    public function listarRolId()
    {
        $id = $this->request->getJSON('ID_ROL');
        $data = $this->rolModel->listarRolId($id);
        return  $this->response->setJSON($data);
    }



    public function insertarRol()
    {
        helper('secure_password_helpers');

        $request = $this->request->getJSON();

        $data = [
            'ID_ROL' => null,
            'NOMBRE_ROL' => $request->NOMBRE_ROL,
            'DESCRIPCION' => $request->DESCRIPCION,
        ];
        $responseModel = $this->rolModel->insertarRol($data);
        return  $this->response->setJSON($responseModel);
    }
    public function actualizarRol()
    {
        helper('secure_password_helpers');

        $request = $this->request->getJSON();
        $data = [
            'ID_ROL' => $request->ID_ROL,
            'NOMBRE_ROL' => $request->NOMBRE_ROL,
            'DESCRIPCION' => $request->DESCRIPCION,
        ];
        $responseModel = $this->rolModel->actualizarRol($data);
        return  $this->response->setJSON($responseModel);
    }
    public function eliminarRol()
    {
        $ID = $this->request->getJSON('ID_ROL');
        $responseModel = $this->rolModel->eliminarRol($ID);
        if ($responseModel) {
            return $this->response->setJSON($responseModel);
        } else {
            return $this->response->setJSON(false);
        }
    }
}
