<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use Dompdf\Dompdf; // Impor namespace Dompdf\Dompdf
use Illuminate\Http\Request;

class PelaporController extends Controller
{
    public function pelapor()
    {
        // Ambil data aktivitas dari model Pelapor
        $activities = Pelapor::all();
        
        // Load view PDF dengan data aktivitas
        $pdf = new Dompdf();
        $pdf->loadHtml(view('Profile.pelaporpdf', compact('activities'))->render());
        
        // Render PDF
        $pdf->render();
        
        // Unduh PDF
        return $pdf->stream('laporan-aktivitas-pengguna.pdf');
    }
}
