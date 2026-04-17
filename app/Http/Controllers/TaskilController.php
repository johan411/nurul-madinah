<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskilController extends Controller
{
    /**
     * Form tambah taskil
     */
    public function create()
    {
        $pekerja = DB::table('pekerja')->orderBy('NAM', 'asc')->get();

        $bulan = date('m');
        $tahun = date('Y');

        $lastId = DB::table('taskil')
            ->where('NOJ', 'like', "$bulan/%/PBUN-JKH/$tahun")
            ->max('id');

        $nextNumber = $lastId ? ($lastId + 1) : 1;
        $formatNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $noj = "$bulan/$formatNumber/PBUN-JKH/$tahun";

        return view('taskil_tambah', compact('pekerja', 'noj'));
    }

    /**
     * Simpan data taskil
     */
    public function store(Request $request)
    {
        \Log::info('🚀 STORE: Proses dimulai');
        try {
            $cart = $request->input('cart', []);
            if (empty($cart)) return back()->with('error', 'Keranjang kosong!');

            $noj = $request->noj;
            $cb = fn($checked) => $checked ? 1 : 0;

            $bulanAngka = (int)substr($noj, 0, 2);
            $namaBulan = [
                '',
                'JANUARI',
                'FEBRUARI',
                'MARET',
                'APRIL',
                'MEI',
                'JUNI',
                'JULI',
                'AGUSTUS',
                'SEPTEMBER',
                'OKTOBER',
                'NOVEMBER',
                'DESEMBER'
            ];
            $waktu = $namaBulan[$bulanAngka] ?? '';

            $headerData = [
                'NOJ' => $noj,
                'TGL' => date('d/m/Y'),
                'HDY' => $request->hdy ?? null,
                'TGH' => $request->tgh ?? null,
                'AMIR' => $request->amir ?? null,
                'RUTE' => $request->rute ?? null,
                'WAKTU' => $waktu,
                'TAHUN' => date('Y'),
                'UL' => $cb($request->has('ul')),
                'UM' => $cb($request->has('um')),
                'MS' => $cb($request->has('ms')),
                'PS' => $cb($request->has('ps')),
                '3H' => $cb($request->has('r3h')),
                '40BS' => $cb($request->has('r40bs')),
                '40JK' => $cb($request->has('r40jk')),
                '40NJ' => $cb($request->has('r40nj')),
                '40IPB' => $cb($request->has('r4blpb')),
                '4BLBS' => $cb($request->has('r4blbs')),
                '4BLJK' => $cb($request->has('r4bljk')),
                '4BLIPB' => $cb($request->has('r4blpb')),
                '4BLNJ' => $cb($request->has('r4blnj')),
                '1TDN' => $cb($request->has('r1tdn')),
                '1TIPB' => $cb($request->has('r1tipb')),
                '10D' => $cb($request->has('m10d')),
                '10N' => $cb($request->has('m10n')),
                '40D' => $cb($request->has('m40d')),
                '40I' => $cb($request->has('m40i')),
                '40N' => $cb($request->has('m40n')),
                '2BLD' => $cb($request->has('m2bld')),
                '2BLI' => $cb($request->has('m2bli')),
                '2BLN' => $cb($request->has('m2bln')),
                'LBR' => (int)($request->input('lbr') ?? 0),
                '2XBL' => (int)($request->input('2xbl') ?? 0),
            ];

            $dataToInsert = [];
            foreach ($cart as $k) {
                $pekerjaData = DB::table('pekerja')->where('NAM', $k['nam'])->first();
                $pengRijal = [];
                $pengMasturot = [];

                if ($pekerjaData) {
                    foreach (['R3H' => '3H', 'R40D' => '40D', 'R40N' => '40N', 'R4D' => '4D', 'R4I' => '4I', 'R4N' => '4N', 'R1D' => '1D', 'R1I' => '1I', 'R1N' => '1N'] as $col => $label)
                        if (!empty($pekerjaData->$col)) $pengRijal[] = $label;
                    foreach (['M3H' => '3H', 'M10D' => '10D', 'M10N' => '10N', 'M40D' => '40D', 'M40I' => '40I', 'M40N' => '40N', 'M2BD' => '2BLD', 'M2BI' => '2BLI', 'M2BN' => '2BLN'] as $col => $label)
                        if (!empty($pekerjaData->$col)) $pengMasturot[] = $label;
                }

                $dataToInsert[] = array_merge($headerData, [
                    'NAMA' => $k['nam'],
                    'PROP' => !empty($pekerjaData->PROF) ? $pekerjaData->PROF : ($k['prop'] ?? '-'),
                    'MAR' => !empty($pekerjaData->MAR) ? $pekerjaData->MAR : '-',
                    'HAL' => !empty($k['hal']) ? $k['hal'] : '-',
                    'MAH' => !empty($pekerjaData->MAH) ? $pekerjaData->MAH : '-',
                    'PENGR' => !empty($pengRijal) ? implode(', ', $pengRijal) : '-',
                    'PENGM' => !empty($pengMasturot) ? implode(', ', $pengMasturot) : '-',
                ]);
            }

            // 1. Insert ke database
            DB::table('taskil')->insert($dataToInsert);
            \Log::info('✅ Data berhasil disimpan ke database');

            // 2. Ambil ID terakhir yang masuk
            $lastId = DB::table('taskil')->latest('id')->value('id');
            \Log::info('🔄 Redirect ke cetak dengan ID: ' . $lastId);

            // 3. Redirect ke halaman cetak
            return redirect()->route('taskil.cetakById', ['id' => $lastId]);
        } catch (\Exception $e) {
            // Jika error, log detailnya & kembali ke form
            \Log::error('❌ STORE GAGAL: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function cetakById($id)
    {
        try {
            $info = DB::table('taskil')->where('id', $id)->first();
            if (!$info) return redirect('/taskil')->with('error', 'Data tidak ditemukan!');

            $peserta = DB::table('taskil')->where('NOJ', $info->NOJ)->get();

            // Render view cetak
            return view('taskil_cetak', compact('peserta', 'info'));
        } catch (\Exception $e) {
            \Log::error('❌ CETAK GAGAL: ' . $e->getMessage());
            return redirect('/taskil')->with('error', 'Gagal cetak: ' . $e->getMessage());
        }
    }

    /**
     * Halaman list/dashboard taskil
     */
    public function index()
    {
        try {
            // Ambil semua data taskil
            $allTaskil = DB::table('taskil')
                ->orderBy('id', 'desc')
                ->get();

            // Group manual berdasarkan NOJ
            $groupedByNoj = $allTaskil->groupBy('NOJ');

            // Ambil yang terbaru dari setiap NOJ + hitung jumlah peserta
            $taskilList = $groupedByNoj->map(function ($peserta, $noj) {
                // Ambil data peserta pertama (yang terbaru karena sudah order by id desc)
                $latest = $peserta->first();
                // Tambahkan properti jumlah_peserta
                $latest->jumlah_peserta = $peserta->count();
                return $latest;
            });

            // Convert ke collection dan paginate manual
            $taskilList = $taskilList->values();
            $currentPage = request()->get('page', 1);
            $perPage = 20;
            $paginated = $taskilList->forPage($currentPage, $perPage);

            return view('taskil_list', [
                'taskilList' => $paginated,
                'total' => $taskilList->count(),
                'currentPage' => $currentPage,
                'perPage' => $perPage
            ]);
        } catch (\Exception $e) {
            \Log::error('Error index: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    /**
     * Cetak surat jalan by NOJ (legacy - jika masih diperlukan)
     */
    public function cetak($noj)
    {
        try {
            $decodedNoj = urldecode($noj);

            $peserta = DB::table('taskil')
                ->where('NOJ', $decodedNoj)
                ->orderBy('id', 'asc')
                ->get();

            if ($peserta->isEmpty()) {
                return redirect('/taskil')->with('error', 'Data tidak ditemukan!');
            }

            $info = $peserta->first();
            return view('taskil_cetak', compact('peserta', 'info'));
        } catch (\Exception $e) {
            \Log::error('Error cetak: ' . $e->getMessage());
            return redirect('/taskil')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
