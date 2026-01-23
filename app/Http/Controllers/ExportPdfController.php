<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class ExportPdfController extends Controller
{
    public function usersExportPdf()
    {
        $users = User::all();
        return Pdf::loadView('admin.exports.users_pdf', compact('users'))->download('users_' . date('d-m-Y') . '.pdf');
    }

    // public function usersImportPdf()
    // {
    //     $users =
    // }
}
