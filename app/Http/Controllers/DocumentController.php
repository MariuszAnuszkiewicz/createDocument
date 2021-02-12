<?php

namespace App\Http\Controllers;

use App\Services\ParseXlsx;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $parseXlsx = app(ParseXlsx::class);
        $sourceFile = $parseXlsx->loadFile('documents');
        $readFile = $parseXlsx->readFile($sourceFile);
        if ($request->ajax()) {
            if ($sourceFile !== null) {
                return response()->json([
                    'criteria' => $readFile,
                ]);
            } else {
                return response()->json(['message' => 'File not exist.']);
            }
        }
        return view('documents.parseXlsx');
    }
}
