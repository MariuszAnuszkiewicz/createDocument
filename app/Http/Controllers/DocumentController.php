<?php

namespace App\Http\Controllers;

use App\Services\ParseXlsx;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $sourceFile = public_path() . '/documents/fields.xlsx';
        $parseXlsx = app(ParseXlsx::class);
        $readFile = $parseXlsx->readFile($sourceFile);
        //dd($readFile);
        if ($request->ajax()) {
            return response()->json([
                'criteria' => isset($readFile) ? $readFile : null,
            ]);
        }
        return view('documents.parseXlsx');
    }
}
