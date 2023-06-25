<?php

namespace App\Controller;

use App\service\document\DocumentService;

class DocumentController
{
    private DocumentService $documentService;
    public function __construct()
    {
        $this->documentService = new DocumentService();
    }


    public function xlsxGet()
    {
        $this->documentService->xlsxGet();
    }

    public function importColumnDataToDatabase()
    {
        $this->documentService->importColumnDataToDatabase();
    }
}