<?php

namespace App\Controllers\Clients;

use App\Controllers\BaseController;
use App\Models\Clients\ClientModel;

class ClientController extends BaseController
{
    private $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function listClients()
    {
        $clients = $this->clientModel->listClients();
        return $this->response->setJSON($clients);
    }

    public function getClientById()
    {
        $id = $this->request->getJSON('ID_CLIENTE');
        $data = $this->clientModel->getClientById($id);
        return $this->response->setJSON($data);
    }

    public function insertClient()
    {
        $request = $this->request->getJSON();
        $data = [
            'NOMBRE_CLIENTE' => $request->NOMBRE_CLIENTE,
            'NIT' => $request->NIT,
            'TELEFONO' => $request->TELEFONO,
            'DIRECCION' => $request->DIRECCION,
            'INFORMACION' => $request->INFORMACION,
        ];
        $responseModel = $this->clientModel->insertClient($data);
        return $this->response->setJSON($responseModel);
    }

    public function updateClient()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_CLIENTE' => $request->ID_CLIENTE,
            'NOMBRE_CLIENTE' => $request->NOMBRE_CLIENTE ?? null,
            'NIT' => $request->NIT ?? null,
            'TELEFONO' => $request->TELEFONO ?? null,
            'DIRECCION' => $request->DIRECCION ?? null,     
            'INFORMACION' => $request->INFORMACION ?? null,
        ];
        $responseModel = $this->clientModel->updateClient($data);
        return $this->response->setJSON($responseModel);
    }

    public function deleteClient()
    {
        $id = $this->request->getJSON('ID_CLIENTE');
        $clients = $this->clientModel->deleteClient($id);
        if ($clients) {
            return $this->response->setJSON($clients);
        } else {
            return $this->response->setJSON(false);
        }
    }
}
