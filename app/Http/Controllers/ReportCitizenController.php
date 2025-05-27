<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Mail\ReportMail;
use Illuminate\Support\Facades\Mail;

class ReportCitizenController extends Controller
{
    public function send_report(Request $request)
    {
        // Usuario autenticado
        $user = $request->user();
        $email = $user->email;

        $cities = City::with('citizens')->orderBy('name')->get();

        Mail::to($email)->send(new ReportMail($cities));
        logger('Enviando correo a: ' . $email);

        // Redireccionar con mensaje
        return back()->with('success', 'Reporte enviado exitosamente.');
    }
}
