<?php

require_once __DIR__ . '/../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfHelper
{
    public static function descargarDesdeHtml($html, $nombreArchivo = 'reporte.pdf')
    {
        $opciones = new Options();
        $opciones->set('isRemoteEnabled', true);
        $opciones->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($opciones);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
        exit();
    }
}
