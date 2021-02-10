<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([

            ]);
        }
        return view('documents.parseXlsx');
    }
}
