<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Lab;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Prepare user data for frontend
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoles(),
            'is_verified' => $user->is_verified ?? true,
        ];

        // Get role-based statistics
        $stats = $this->getRoleBasedStats($user);
        
        // Get recent activity (placeholder for now)
        $recentActivity = [];

        return Inertia::render('dashboard', [
            'user' => $userData,
            'stats' => $stats,
            'recentActivity' => $recentActivity,
        ]);
    }

    /**
     * Get statistics based on user role.
     */
    protected function getRoleBasedStats($user): array
    {
        $stats = [];

        if ($user->hasRole('admin')) {
            $stats = [
                'totalLabs' => Lab::active()->count(),
                'totalEquipment' => Equipment::active()->count(),
                'unverifiedStudents' => User::where('is_verified', false)->where('email', 'like', '%@ui.ac.id')->count(),
                'pendingRequests' => LoanRequest::where('status', LoanRequest::STATUS_PENDING)->count(),
                'overdueLoans' => LoanRequest::where('status', LoanRequest::STATUS_OVERDUE)->count(),
            ];
        } elseif ($user->hasRole(['laboran', 'kepala_lab'])) {
            $labId = $user->lab_id;
            $equipmentIds = Equipment::where('lab_id', $labId)->pluck('id');

            $stats = [
                'pendingRequests' => LoanRequest::whereIn('equipment_id', $equipmentIds)
                    ->where('status', LoanRequest::STATUS_PENDING)
                    ->count(),
                'overdueLoans' => LoanRequest::whereIn('equipment_id', $equipmentIds)
                    ->where('status', LoanRequest::STATUS_OVERDUE)
                    ->count(),
                'totalEquipment' => Equipment::where('lab_id', $labId)->active()->count(),
            ];
        } elseif ($user->hasRole(['dosen', 'mahasiswa'])) {
            $stats = [
                'myLoans' => LoanRequest::where('user_id', $user->id)
                    ->whereIn('status', [
                        LoanRequest::STATUS_APPROVED,
                        LoanRequest::STATUS_CHECKED_OUT
                    ])
                    ->count(),
            ];
        }

        return $stats;
    }
}