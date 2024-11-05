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

    public function userClientList()
    {
        $users = $this->userModel->userClientList();
        return $this->response->setJSON($users);
    }

    public function userClientGetById()
    {
        $id = $this->request->getJSON('ID_USUARIO_CLIENTE');
        $data = $this->userModel->userClientGetById($id);
        return $this->response->setJSON($data);
    }

    public function userClientInsert()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_CLIENTE' => $request->ID_CLIENTE, 
            'NOMBRE' => $request->NOMBRE,
            'APELLIDO' => $request->APELLIDO,
            'CARGO' => $request->CARGO,
            'USUARIO_DOMINIO' => $request->USUARIO_DOMINIO,
            'CORREO' => $request->CORREO,
            'CC' => $request->CC,
            'TELEFONO' => $request->TELEFONO,
            'PASSWORD' => $request->PASSWORD,
        ];
        $responseModel = $this->userModel->userClientInsert($data);
        return $this->response->setJSON($responseModel);
    }

    public function userClientUpdate()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_USUARIO_CLIENTE' => $request->ID_USUARIO_CLIENTE, 
            'ID_CLIENTE'=> $request->ID_CLIENTE,
            'NOMBRE' => $request->NOMBRE ?? null,
            'APELLIDO' => $request->APELLIDO ?? null,
            'CORREO' => $request->CORREO ?? null,
            'TELEFONO' => $request->TELEFONO ?? null,
            'CARGO' => $request->CARGO ?? null,
            'USUARIO_DOMINIO' => $request->USUARIO_DOMINIO ?? null,
            'CC' => $request->CC ?? null,
            'PASSWORD' => $request->PASSWORD ?? null,
        ];
        $responseModel = $this->userModel->userClientUpdate($data);
        return $this->response->setJSON($responseModel);
    }

    public function userClientDelete()
    {
        $id = $this->request->getJSON('ID_USUARIO_CLIENTE');
        $responseModel=$this->userModel->userClientDelete($id);
        return $this->response->setJSON($responseModel);
    }
}