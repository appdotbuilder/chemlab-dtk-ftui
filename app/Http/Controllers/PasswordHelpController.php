<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordHelpRequest;
use App\Models\PasswordHelpTicket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PasswordHelpController extends Controller
{
    /**
     * Show the password help form.
     */
    public function create(): Response
    {
        return Inertia::render('auth/password-help', [
            'title' => 'Bantuan Reset Password',
            'description' => 'Ajukan tiket bantuan untuk reset password. Tim admin akan memproses permintaan Anda.'
        ]);
    }

    /**
     * Store a new password help ticket.
     */
    public function store(PasswordHelpRequest $request): RedirectResponse
    {
        $ticket = PasswordHelpTicket::create([
            'ticket_number' => PasswordHelpTicket::generateTicketNumber(),
            'email' => $request->email,
            'name' => $request->name,
            'message' => $request->message,
            'status' => PasswordHelpTicket::STATUS_PENDING,
        ]);

        return redirect()->route('login')->with('status', 
            "Tiket bantuan password telah dibuat dengan nomor: {$ticket->ticket_number}. " .
            "Tim admin akan menghubungi Anda melalui email dalam 1-2 hari kerja."
        );
    }

    /**
     * Show ticket status (public access with ticket number).
     */
    public function show(string $ticketNumber): Response
    {
        $ticket = PasswordHelpTicket::where('ticket_number', $ticketNumber)->firstOrFail();

        return Inertia::render('auth/ticket-status', [
            'ticket' => $ticket
        ]);
    }
}