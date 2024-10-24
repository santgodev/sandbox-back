<?php

namespace App\Controllers\Clients;

use App\Controllers\BaseController;
use App\Models\Clients\UserClientModel;

class UserClientController extends BaseController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserClientModel();
    }

    public function listClients()
    {
        $clients = $this->userModel->listClients();
        return $this->response->setJSON($clients);
    }

    public function getClientById()
    {
        $id = $this->request->getJSON('ID_CLIENTE');
        $data = $this->userModel->getClientById($id);
        return $this->response->setJSON($data);
    }

    public function insertClient()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_CLIENTE' => null,
            'NOMBRE_CLIENTE' => $request->NOMBRE_CLIENTE,
            'NIT' => $request->NIT,
            'TELEFONO' => $request->TELEFONO,
            'DIRECCION' => $request->DIRECCION,
            'INFORMACION' => $request->INFORMACION,
        ];
        $responseModel = $this->userModel->insertClient($data);
        return $this->response->setJSON($responseModel);
    }

    public function updateClient()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_CLIENTE' => null,
            'NOMBRE_CLIENTE' => $request->NOMBRE_CLIENTE,
            'NIT' => $request->NIT,
            'TELEFONO' => $request->TELEFONO,
            'DIRECCION' => $request->DIRECCION,
            'INFORMACION' => $request->INFORMACION,
        ];
        $responseModel = $this->userModel->updateClient($data);
        return $this->response->setJSON($responseModel);
    }

    public function deleteClient()
    {
        $id = $this->request->getJSON('ID');
        if ($this->userModel->deleteClient($id)) {
            return $this->response->setJSON(true);
        } else {
            return $this->response->setJSON(false);
        }
    }
}
