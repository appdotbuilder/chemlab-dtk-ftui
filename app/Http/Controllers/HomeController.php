<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Lab;
use App\Models\LoanRequest;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the landing page with statistics.
     */
    public function index()
    {
        $stats = [
            'totalLabs' => Lab::active()->count(),
            'totalEquipment' => Equipment::active()->count(),
            'activeLoans' => LoanRequest::whereIn('status', [
                LoanRequest::STATUS_APPROVED,
                LoanRequest::STATUS_CHECKED_OUT
            ])->count(),
            'totalUsers' => User::active()->count(),
        ];

        return Inertia::render('welcome', [
            'stats' => $stats
        ]);
    }
}