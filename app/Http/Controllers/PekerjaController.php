<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk akses database langsung



class PekerjaController extends Controller
{
    public function create()
    {
        // Ambil data lengkap untuk diproses JavaScript
        $data_wilayah = \DB::table('pekerja')
            ->select('PROF', 'MAR', 'HAL', 'MAH')
            ->distinct()
            ->get();

        // Data awal untuk Provinsi saja
        $list_prof = $data_wilayah->pluck('PROF')->unique();

        return view('pekerja_tambah', compact('data_wilayah', 'list_prof'));
    }

    public function store(Request $request)
    {
        try {
            $cart = $request->input('cart', []);

            if (empty($cart)) {
                return back()->with('error', 'Keranjang masih kosong!');
            }

            $noj = $request->noj;
            $cb = fn($checked) => $checked ? 1 : 0;

            // Ambil bulan untuk WAKTU
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
                'NOJ'   => $noj,
                'TGL'   => date('d/m/Y'),
                'HDY'   => $request->hdy ?? null,
                'TGH'   => $request->tgh ?? null,
                'AMIR'  => $request->amir ?? null,
                'RUTE'  => $request->rute ?? null,
                'WAKTU' => $waktu,
                'TAHUN' => date('Y'),
                'UL'    => $cb($request->has('ul')),
                'UM'    => $cb($request->has('um')),
                'MS'    => $cb($request->has('ms')),
                'PS'    => $cb($request->has('ps')),
                '3H'    => $cb($request->has('r3h')),
                '40BS'  => $cb($request->has('r40bs')),
                '40JK'  => $cb($request->has('r40jk')),
                '40NJ'  => $cb($request->has('r40nj')),
                '40IPB' => $cb($request->has('r4blpb')),
                '4BLBS' => $cb($request->has('r4blbs')),
                '4BLJK' => $cb($request->has('r4bljk')),
                '4BLIPB' => $cb($request->has('r4blpb')),
                '4BLNJ' => $cb($request->has('r4blnj')),
                '1TDN'  => $cb($request->has('r1tdn')),
                '1TIPB' => $cb($request->has('r1tipb')),
                '10D'   => $cb($request->has('m10d')),
                '10N'   => $cb($request->has('m10n')),
                '40D'   => $cb($request->has('m40d')),
                '40I'   => $cb($request->has('m40i')),
                '40N'   => $cb($request->has('m40n')),
                '2BLD'  => $cb($request->has('m2bld')),
                '2BLI'  => $cb($request->has('m2bli')),
                '2BLN'  => $cb($request->has('m2bln')),
                'LBR'   => (int)($request->input('lbr') ?? 0),
                '2XBL'  => (int)($request->input('2xbl') ?? 0),
            ];

            $dataToInsert = [];
            foreach ($cart as $k) {
                // Ambil data dari tabel pekerja
                $pekerjaData = DB::table('pekerja')->where('NAM', $k['nam'])->first();

                // Compile Pengalaman Rijal
                $pengRijal = [];
                if ($pekerjaData) {
                    $rijalCols = ['R3H' => '3H', 'R40D' => '40D', 'R40N' => '40N', 'R4D' => '4D', 'R4I' => '4I', 'R4N' => '4N', 'R1D' => '1D', 'R1I' => '1I', 'R1N' => '1N'];
                    foreach ($rijalCols as $col => $label) {
                        if (!empty($pekerjaData->$col)) $pengRijal[] = $label;
                    }
                }
                $pengrString = !empty($pengRijal) ? implode(', ', $pengRijal) : '-';

                // Compile Pengalaman Masturot
                $pengMasturot = [];
                if ($pekerjaData) {
                    $masturotCols = ['M3H' => '3H', 'M10D' => '10D', 'M10N' => '10N', 'M40D' => '40D', 'M40I' => '40I', 'M40N' => '40N', 'M2BD' => '2BLD', 'M2BI' => '2BLI', 'M2BN' => '2BLN'];
                    foreach ($masturotCols as $col => $label) {
                        if (!empty($pekerjaData->$col)) $pengMasturot[] = $label;
                    }
                }
                $pengmString = !empty($pengMasturot) ? implode(', ', $pengMasturot) : '-';

                $dataToInsert[] = array_merge($headerData, [
                    'NAMA'  => $k['nam'],
                    'PROP'  => !empty($pekerjaData->PROF) ? $pekerjaData->PROF : '-',  // ✅ PROF bukan PROP
                    'MAR'   => !empty($pekerjaData->MAR) ? $pekerjaData->MAR : '-',
                    'HAL'   => !empty($k['hal']) ? $k['hal'] : '-',
                    'MAH'   => !empty($pekerjaData->MAH) ? $pekerjaData->MAH : '-',
                    'PENGR' => $pengrString,
                    'PENGM' => $pengmString,
                ]);
            }

            DB::table('taskil')->insert($dataToInsert);

            \Log::info('✅ Insert berhasil, NOJ: ' . $noj);

            // Redirect dengan NOJ di-encode
            $encodedNoj = urlencode($noj);
            \Log::info('Redirect ke: /taskil/cetak/' . $encodedNoj);

            return redirect("/taskil/cetak/{$encodedNoj}");
        } catch (\Exception $e) {
            \Log::error('ERROR STORE: ' . $e->getMessage());
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

//<?php

//namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;

//class PekerjaController extends Controller
//{
    /**
     * Halaman utama upgrade data pekerja
     */
    public function index()
    {
        // Ambil semua PROF unik
        $profinsi = DB::table('pekerja')
            ->select('PROF')
            ->distinct()
            ->orderBy('PROF', 'asc')
            ->get();

        return view('pekerja_edit', compact('profinsi'));
    }

    /**
     * API: Get Markas berdasarkan PROF
     */
    public function getMarkas($prof)
    {
        $markas = DB::table('pekerja')
            ->select('MAR')
            ->where('PROF', $prof)
            ->distinct()
            ->orderBy('MAR', 'asc')
            ->get();

        return response()->json($markas);
    }

    /**
     * API: Get Halaqoh berdasarkan MAR
     */
    public function getHalaqoh($mar)
    {
        $halaqoh = DB::table('pekerja')
            ->select('HAL')
            ->where('MAR', $mar)
            ->distinct()
            ->orderBy('HAL', 'asc')
            ->get();

        return response()->json($halaqoh);
    }

    /**
     * API: Get Mahala berdasarkan HAL
     */
    public function getMahala($hal)
    {
        $mahala = DB::table('pekerja')
            ->select('MAH')
            ->where('HAL', $hal)
            ->distinct()
            ->orderBy('MAH', 'asc')
            ->get();

        return response()->json($mahala);
    }

    /**
     * Tampilkan data pekerja berdasarkan filter
     */
    public function getFilteredData(Request $request)
    {
        $query = DB::table('pekerja');

        if ($request->prof) $query->where('PROF', $request->prof);
        if ($request->mar) $query->where('MAR', $request->mar);
        if ($request->hal) $query->where('HAL', $request->hal);
        if ($request->mah) $query->where('MAH', $request->mah);

        $pekerja = $query->orderBy('NAM', 'asc')->get();

        return response()->json($pekerja);
    }

    /**
     * Update data pekerja
     */
    public function update(Request $request)
    {
        try {
            $updates = $request->input('updates', []);

            \Log::info('Data yang diterima:', $updates); // Debug log

            foreach ($updates as $id => $data) {
                // Filter hanya kolom yang boleh diupdate
                $allowedColumns = [
                    'SUL',
                    'SUM',
                    'SPS',
                    'R3H',
                    'R40D',
                    'R40N',
                    'R4D',
                    'R4I',
                    'R4N',
                    'R1D',
                    'R1I',
                    'R1N',
                    'PLBR',
                    '2XBL',
                    //'3HR',
                    'M3H',
                    'M10D',
                    'M40D',
                    'M40I',
                    'M40N',
                    'M2BD',
                    'M2BI',
                    'M2BN',
                    'M2BNJ',
                    'AMMH',
                    'AMTM',
                    'AM25',
                    'AMJ1',
                    'AMJ2',
                    'ARTR',
                    'AR6S',
                    'ARTMM',
                    'RSMj'
                ];

                $cleanData = [];
                foreach ($allowedColumns as $col) {
                    if (isset($data[$col])) {
                        $cleanData[$col] = $data[$col];
                    }
                }

                // Update database
                DB::table('pekerja')
                    ->where('id', $id)
                    ->update($cleanData);

                \Log::info("Updated ID {$id}:", $cleanData);
            }

            return back()->with('success', 'Data berhasil diupdate! ' . count($updates) . ' records.');
        } catch (\Exception $e) {
            \Log::error('Update error: ' . $e->getMessage());
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
}
