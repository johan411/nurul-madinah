<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $menuItems = [
            [
                'id' => 'home',
                'name' => 'Beranda',
                'icon' => '🏠',
                'url' => '/dashboard/home',
                'color' => '#00d4ff'
            ],
            [
                'id' => 'taskil',
                'name' => 'Surat Jalan Taskil',
                'icon' => '📋',
                'url' => '/taskil',
                'color' => '#00ff88'
            ],
            [
                'id' => 'pekerja',
                'name' => 'Upgrade Data Karkun',
                'icon' => '⚡',
                'url' => '/pekerja',
                'color' => '#ff6b6b'
            ],
            [
                'id' => 'monitoring',
                'name' => 'Monitoring Potensi',
                'icon' => '📊',
                'url' => '/monitoring',
                'color' => '#ffd93d'
            ],
            [
                'id' => 'cetak-simple',
                'name' => 'Cetak Simple',
                'icon' => '🖨️',
                'url' => '/taskil/cetak/04/136/PBUN-JKH/2026',
                'color' => '#c084fc'
            ]
        ];

        return view('dashboard', compact('menuItems'));
    }

    public function home()
    {
        return view('dashboard-home');
    }
}