<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    // Helper: Cek nilai 1 atau "X"
    private function isOneOrX($query, $column)
    {
        return $query->where(function ($q) use ($column) {
            $q->where($column, 1)->orWhere($column, 'X');
        });
    }

    public function index(Request $request)
    {
        try {
            $prof = $request->input('prof');
            $mar  = $request->input('mar');

            // Base query helper dengan filter
            $getBase = function ($table = 'pekerja') use ($prof, $mar) {
                $q = DB::table($table);
                if ($prof) $q->where('PROF', $prof);
                if ($mar)  $q->where('MAR', $mar);
                return $q;
            };

            // ==================== BARIS 1-5 ====================
            $jumlah_markaz  = $getBase()->distinct('MAR')->count('MAR') ?: 1;
            $jumlah_malam   = 1;
            $jumlah_zone    = '-';
            $jumlah_halaqoh = $getBase()->distinct('HAL')->count('HAL');
            $jumlah_masjid  = 872; // Hardcoded sesuai request awal

            // ==================== BARIS 6 ====================
            // Hitung jumlah NAM yang: (SUL=1/X) DAN (R1D/R1I/R1N = 1/X)
            $ulama_1thn_ipb = $getBase()
                ->where(function ($q) { $this->isOneOrX($q, 'SUL'); })
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'R1D'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'R1I'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'R1N'); });
                })->count();

            // ==================== BARIS 7-11 (LOGIKA DIKOREKSI) ====================
            // Pola: (SUL=1/X OR SUM=1/X) AND [KOLOM]=1/X

            // No.7: (SUL/SUM) AND R1I → Expected: 1
            $baris7 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R1I'); })
                ->count();

            // No.8: (SUL/SUM) AND R1D → Expected: 9
            $baris8 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R1D'); })
                ->count();

            // No.9: (SUL/SUM) AND R4N → Expected: 5
            $baris9 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R4N'); })
                ->count();

            // No.10: (SUL/SUM) AND R4I → Expected: 38
            $baris10 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R4I'); })
                ->count();

            // No.11: (SUL/SUM) AND R4D → Expected: 54
            $baris11 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R4D'); })
                ->count();

            // ==================== BARIS 12-17 (POLA SAMA) ====================
            // Mapping kolom berdasarkan asumsi umum, silakan sesuaikan jika nama kolom beda di DB

            // No.12: (SUL/SUM) AND R40N (Jalan Kaki?)
            $baris12 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R40N'); })
                ->count();

            // No.13: (SUL/SUM) AND R40D (Negeri Jiran?)
            $baris13 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R40D'); })
                ->count();

            // No.14: (SUL/SUM) AND R3H (40 Hari?)
            $baris14 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R3H'); })
                ->count();

            // No.15: (SUL/SUM) AND PLBR (40 Hari Jalan Kaki?)
            $baris15 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'PLBR'); })
                ->count();

            // No.16: (SUL/SUM) AND R3H (3 Hari)
            $baris16 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'R3H'); })
                ->count();

            // No.17: (SUL/SUM) AND PLBR (Liburan)
            $baris17 = $getBase()
                ->where(function ($q) {
                    $q->where(function($sub){ $this->isOneOrX($sub, 'SUL'); })
                      ->orWhere(function($sub){ $this->isOneOrX($sub, 'SUM'); });
                })
                ->where(function ($q) { $this->isOneOrX($q, 'PLBR'); })
                ->count();

            // ==================== BARIS 19-23 (MASIH KOSONG/0) ====================
            // Silakan isi kolom yang sesuai nanti
            $baris19 = 0; 
            $baris20 = 0; 
            $baris21 = 0; 
            $baris22 = 0; 
            $baris23 = 0; 

            // ==================== BARIS 25 ====================
            $baris25 = $getBase()->where(function ($q) { $this->isOneOrX($q, 'M2BI'); })->count();

            // ==================== BARIS 27-31 (Masturot & Amah) ====================
            $baris27 = $getBase()->where(function ($q) { $this->isOneOrX($q, 'M40N'); })->count();
            $baris28 = $getBase()->where(function ($q) { $this->isOneOrX($q, 'M40I'); })->count();
            $baris29 = $getBase()->where(function ($q) { $this->isOneOrX($q, 'M40D'); })->count();
            
            // No.30: Count distinct MAH dengan SEMUA 6 kolom aktif (AMMH, AMTM, AM25, AMJ1, AMJ2, AM3H)
            $baris30 = DB::table('pekerja')
                ->when($prof, fn($q) => $q->where('PROF', $prof))
                ->when($mar, fn($q) => $q->where('MAR', $mar))
                ->select('MAH')->groupBy('MAH')
                ->havingRaw("
                    SUM(CASE WHEN AMMH IN (1,'X') THEN 1 ELSE 0 END) > 0 AND
                    SUM(CASE WHEN AMTM IN (1,'X') THEN 1 ELSE 0 END) > 0 AND
                    SUM(CASE WHEN AM25 IN (1,'X') THEN 1 ELSE 0 END) > 0 AND
                    SUM(CASE WHEN AMJ1 IN (1,'X') THEN 1 ELSE 0 END) > 0 AND
                    SUM(CASE WHEN AMJ2 IN (1,'X') THEN 1 ELSE 0 END) > 0 AND
                    SUM(CASE WHEN AM3H IN (1,'X') THEN 1 ELSE 0 END) > 0
                ")->count();

            // No.31: Count distinct MAH dengan 4 dari 6 kolom aktif
            $baris31 = DB::table('pekerja')
                ->when($prof, fn($q) => $q->where('PROF', $prof))
                ->when($mar, fn($q) => $q->where('MAR', $mar))
                ->select('MAH')->groupBy('MAH')
                ->havingRaw("
                    (CASE WHEN SUM(CASE WHEN AMMH IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END) +
                    (CASE WHEN SUM(CASE WHEN AMTM IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END) +
                    (CASE WHEN SUM(CASE WHEN AM25 IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END) +
                    (CASE WHEN SUM(CASE WHEN AMJ1 IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END) +
                    (CASE WHEN SUM(CASE WHEN AMJ2 IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END) +
                    (CASE WHEN SUM(CASE WHEN AM3H IN (1,'X') THEN 1 ELSE 0 END) > 0 THEN 1 ELSE 0 END)
                    = 4
                ")->count();

            // No.32 & 33: Tempat/Rumah
            $baris32 = $getBase()->whereNotNull('ARMHL')->distinct('ARMHL')->count('ARMHL');
            $baris33 = $getBase()->whereNotNull('AMMH')->count(); // PERBAIKAN: AMHM -> AMMH

            // ==================== BARIS 35-39 (Masjid) ====================
            $baris35   = 0; 
            $baris36_4 = 0; 
            $baris36_3 = 0; 
            $baris36_2 = 0; 
            $baris36_1 = 0; 

            // ==================== DATA DROPDOWN ====================
            $profinsi = DB::table('pekerja')->select('PROF')->distinct()->orderBy('PROF')->get();
            $markas   = DB::table('pekerja')->select('MAR')->distinct()->orderBy('MAR')->get();

            // ==================== RETURN VIEW ====================
            return view('monitoring', compact(
                'jumlah_markaz', 'jumlah_malam', 'jumlah_zone', 'jumlah_halaqoh', 'jumlah_masjid',
                'ulama_1thn_ipb', 
                'baris7', 'baris8', 'baris9', 'baris10', 'baris11', 
                'baris12', 'baris13', 'baris14', 'baris15', 'baris16', 'baris17',
                'baris19', 'baris20', 'baris21', 'baris22', 'baris23', 'baris25', 
                'baris27', 'baris28', 'baris29', 'baris30', 'baris31', 
                'baris32', 'baris33', 'baris35', 'baris36_4', 'baris36_3', 'baris36_2', 'baris36_1',
                'profinsi', 'markas', 'prof', 'mar'
            ));

        } catch (\Exception $e) {
            \Log::error('Monitoring Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}