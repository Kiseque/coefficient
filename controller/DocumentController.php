<?php

namespace App\Controller;

use App\service\Constants;
use App\service\document\DocumentService;
use Error;
use Exception;

class DocumentController
{
    private DocumentService $documentService;
    public function __construct()
    {
        $this->documentService = new DocumentService();
    }


    public function xlsxGet()
    {
        try {
            $this->documentService->xlsxGet();
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }

    public function importColumnDataToDatabase()
    {
        try {
            $this->documentService->importColumnDataToDatabase();
        } catch (Exception $e) {
            outputJson(false, $e->getMessage(), $e->getCode());
        } catch (Error $e) {
            outputJson(false, Constants::BAD_REQUEST_MESSAGE, Constants::BAD_REQUEST_CODE);
        }
    }
}