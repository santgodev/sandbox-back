<?php

namespace App\Controllers\Clients;

use App\Controllers\BaseController;
use App\Models\Clients\AssetModel;

class AssetController extends BaseController
{
    private $assetModel;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
    }

    public function listAssets()
    {
        $assets = $this->assetModel->listAssets();
        return $this->response->setJSON($assets);
    }

    public function listFreeAssets()
    {
        $assets = $this->assetModel->listFreeAssets();
        return $this->response->setJSON($assets);
    }
    public function getAssetsByUserClientId()
    {
        $id = $this->request->getJSON('ID_USUARIO_CLIENTE');
        $data = $this->assetModel->listAssetsByUserClientId($id);
        return $this->response->setJSON($data);
    }

    public function insertAsset()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_USUARIO_CLIENTE' => $request->ID_USUARIO,
            'NOMBRE_ACTIVO' => $request->NOMBRE_ACTIVO,
            'CATEGORIA' => $request->CATEGORIA,
            'MARCA' => $request->MARCA,
            'REFERENCIA' => $request->REFERENCIA,
            'SERIAL' => $request->SERIAL,
            'ESTADO' => $request->ESTADO,
            'NOVEDADES' => $request->NOVEDADES,

        ];
        $responseModel = $this->assetModel->insertAsset($data);
        return $this->response->setJSON($responseModel);
    }

    public function updateAsset()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_ACTIVO' => $request->ID_ACTIVO,
            'ID_USUARIO_CLIENTE' => $request->ID_USUARIO ?? null,
            'NOMBRE_ACTIVO' => $request->NOMBRE_ACTIVO ?? null,
            'CATEGORIA' => $request->CATEGORIA ?? null,
            'MARCA' => $request->MARCA ?? null,
            'REFERENCIA' => $request->REFERENCIA ?? null,
            'SERIAL' => $request->SERIAL ?? null,
            'ESTADO' => $request->ESTADO ?? null,
            'NOVEDADES' => $request->NOVEDADES ?? null,
        ];
        $responseModel = $this->assetModel->updateAsset($data);
        return $this->response->setJSON($responseModel);
    }

    public function deleteAsset()
    {
        $id = $this->request->getJSON('ID_ACTIVO');
        $asset = $this->assetModel->deleteAsset($id);
        if ($asset) {
            return $this->response->setJSON($asset);
        } else {
            return $this->response->setJSON(false);
        }
    }
    
    public function assingUser()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_ACTIVO' => $request->ID_ACTIVO,
            'ID_USUARIO_CLIENTE' => $request->ID_USUARIO_CLIENTE,
        ];
        $responseModel = $this->assetModel->assingUser($data);
        return $this->response->setJSON($responseModel);
    }
    public function undessingUser()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_ACTIVO' => $request->ID_ACTIVO,
            'ID_USUARIO_CLIENTE' => null,
        ];
        $responseModel = $this->assetModel->undessingUser($data);
        return $this->response->setJSON($responseModel);
    }
}
