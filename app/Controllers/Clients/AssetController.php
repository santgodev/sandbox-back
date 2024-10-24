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

    public function getAssetsByClientId()
    {
        $id = $this->request->getJSON('ID_CLIENTE');
        $data = $this->assetModel->getAssetsByClientId($id);
        return $this->response->setJSON($data);
    }

    public function insertAsset()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_CLIENTE' => $request->ID_CLIENTE,
            'NOMBRE_ACTIVO' => $request->NOMBRE_ACTIVO,
            'CATEGORIA' => $request->CATEGORIA,
            'SERIAL' => $request->SERIAL,
            'ACCESORIOS' => $request->ACCESORIOS,
            'INFORMACION' => $request->INFORMACION,
        ];
        $responseModel = $this->assetModel->insertAsset($data);
        return $this->response->setJSON($responseModel);
    }

    public function updateAsset()
    {
        $request = $this->request->getJSON();
        $data = [
            'ID_ACTIVO' => $request->ID_ACTIVO,
            'ID_CLIENTE' => $request->ID_CLIENTE,
            'NOMBRE_ACTIVO' => $request->NOMBRE_ACTIVO,
            'CATEGORIA' => $request->CATEGORIA,
            'SERIAL' => $request->SERIAL,
            'ACCESORIOS' => $request->ACCESORIOS,
            'INFORMACION' => $request->INFORMACION,
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
}
