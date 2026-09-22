<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;

class QuotationController extends Controller
{
    public function pdf(Quotation $quotation)
    {
        $quotation->load([
            'customer',
            'quotationItems.product',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 1. Generate the quotation PDF
        |--------------------------------------------------------------------------
        */

        $quotationPdf = Pdf::loadView('quotations.pdf', [
            'quotation' => $quotation,
        ]);

        $quotationPdf->setPaper('a4', 'portrait');

        /*
        |--------------------------------------------------------------------------
        | 2. Save the generated quotation PDF temporarily
        |--------------------------------------------------------------------------
        */

        $quotationTempFile = tempnam(
            sys_get_temp_dir(),
            'quotation_'
        );

        file_put_contents(
            $quotationTempFile,
            $quotationPdf->output()
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Locate the Terms & Conditions PDF
        |--------------------------------------------------------------------------
        */

        $termsPdf = storage_path(
            'app/private/documents/terms-and-conditions.pdf'
        );

        /*
        |--------------------------------------------------------------------------
        | 4. Create a new PDF and merge both files
        |--------------------------------------------------------------------------
        */

        $finalPdf = new Fpdi();

        /*
        |--------------------------------------------------------------------------
        | 5. Add quotation pages
        |--------------------------------------------------------------------------
        */

        $pageCount = $finalPdf->setSourceFile($quotationTempFile);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

            $template = $finalPdf->importPage($pageNo);

            $size = $finalPdf->getTemplateSize($template);

            $finalPdf->AddPage(
                $size['orientation'],
                [$size['width'], $size['height']]
            );

            $finalPdf->useTemplate($template);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Add Terms & Conditions pages
        |--------------------------------------------------------------------------
        */

        $termsPageCount = $finalPdf->setSourceFile($termsPdf);

        for ($pageNo = 1; $pageNo <= $termsPageCount; $pageNo++) {

            $template = $finalPdf->importPage($pageNo);

            $size = $finalPdf->getTemplateSize($template);

            $finalPdf->AddPage(
                $size['orientation'],
                [$size['width'], $size['height']]
            );

            $finalPdf->useTemplate($template);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Remove temporary quotation PDF
        |--------------------------------------------------------------------------
        */

        unlink($quotationTempFile);

        /*
        |--------------------------------------------------------------------------
        | 8. Send the merged PDF to the browser
        |--------------------------------------------------------------------------
        */

        return response(
            $finalPdf->Output(
                'S',
                'quotation-' . $quotation->quotation_number . '.pdf'
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'inline; filename="quotation-' .
                    $quotation->quotation_number .
                    '.pdf"',
            ]
        );
    }
}