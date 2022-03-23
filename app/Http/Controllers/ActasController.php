<?php

namespace App\Http\Controllers;

use App\Imports\ActasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;
use ZipArchive;
use File;



class ActasController extends Controller
{
    public function index()
    {
        return view('actas');
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'datos' => 'required|file|mimes:xlsx,xls',
            'plantilla' => 'required|file|mimes:doc,docx',
        ]);

        $pathExcel = $request->file('datos');
        $pathPlantilla = $request->file('plantilla');

        $encabezados = array();

        $excel = Excel::toArray([], $pathExcel);

        $encabezados = $excel[0][0];

        $fileName = 'actas' . '.zip';
        $zip = new ZipArchive;
        if ($zip->open(public_path($fileName), ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
            die("An error occurred creating your ZIP file.");
        }

        foreach ($excel as $hoja) {
            foreach ($hoja as $acta) {
                $templateProcessor = new TemplateProcessor($pathPlantilla);

                for ($i = 0; $i < count($encabezados); $i++) {
                    $templateProcessor->setValue($encabezados[$i], $acta[$i]);
                }

                $path = $templateProcessor->save('actas/' . $acta[0] . '.docx');

                $zip->addFile($path, 'actas/' . $acta[0] . '.docx');
            }
        }

        $zip->close();


        return response()->download(public_path($fileName));








        // return response()->download($resPath, $zipname);
    }
}