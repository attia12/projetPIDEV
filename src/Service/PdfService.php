<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;
    public function __construct()
    {
        $this->domPdf=new Dompdf();
        $pdfoption=new Options();
        $pdfoption->set('defaultFont ','Garamond');
        $this->domPdf->setOptions($pdfoption);
    }
    public function showpdf($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf",[
            'Attachement'=>false
        ]);




    }
    public function generateBinaryPdf($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();

    }

}