<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Taskil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d4edda;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #800000;
            font-size: 13px;
        }

        .container-box {
            border: 2px solid #800000;
            padding: 15px;
            margin-top: 10px;
            background-color: #d4edda;
        }

        .text-maroon {
            color: #800000;
            font-weight: bold;
        }

        .section-header {
            border-bottom: 2px solid #800000;
            margin-bottom: 10px;
            padding-bottom: 5px;
            font-size: 14px;
        }

        .cb-item {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 5px;
        }

        .cb-item input {
            margin-right: 5px;
        }

        .cb-label {
            font-weight: bold;
            margin-right: 5px;
            min-width: 40px;
        }

        .keranjang-table {
            background: white;
            border: 1px solid #800000;
            width: 100%;
        }

        .keranjang-table th {
            background: #800000;
            color: white;
            font-size: 12px;
            text-align: center;
            padding: 6px;
            border: 1px solid #800000;
        }

        .keranjang-table td {
            font-size: 12px;
            padding: 6px;
            border: 1px solid #800000;
            vertical-align: middle;
        }

        .btn-hapus {
            background: #dc3545;
            color: white;
            border: none;
            padding: 2px 8px;
            cursor: pointer;
            font-size: 11px;
            border-radius: 3px;
        }

        .btn-hapus:hover {
            background: #c82333;
        }

        .worker-list {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #800000;
            background: white;
        }

        .worker-item {
            padding: 6px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
        }

        .worker-item:hover {
            background-color: #f0f0f0;
        }

        .worker-item.active {
            background-color: #c8e6c9;
            font-weight: bold;
        }

        .detail-panel {
            border: 1px solid #800000;
            background: white;
            padding: 10px;
            margin-top: 10px;
        }

        .detail-name {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            color: #800000;
        }

        .detail-row {
            display: flex;
            margin-bottom: 3px;
            font-size: 12px;
        }

        .detail-label {
            width: 100px;
            font-weight: bold;
        }

        .detail-separator {
            margin: 0 5px;
        }

        .autocomplete-wrapper {
            position: relative;
        }

        .autocomplete-list {
            position: absolute;
            border: 1px solid #800000;
            background: white;
            max-height: 150px;
            overflow-y: auto;
            width: 100%;
            z-index: 999;
            display: none;
        }

        .autocomplete-item {
            padding: 6px;
            cursor: pointer;
        }

        .autocomplete-item:hover {
            background-color: #f0f0f0;
        }

        .form-control-sm {
            font-size: 12px;
        }

        .input-group-custom {
            margin-bottom: 8px;
        }

        .input-label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <form id="formTaskil" action="/taskil/simpan" method="POST">
        @csrf

        <div class="container-fluid">
            <div class="container-box">

                <!-- HEADER -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h3 class="text-maroon mb-1">FORM TASKIL</h3>
                        <div>
                            <small>Tgl: {{ date('d/m/Y') }} | </small>
                            <small>No. Jamaah: <span class="fw-bold">{{ $noj }}</span></small>
                        </div>
                        <input type="hidden" name="noj" value="{{ $noj }}">
                    </div>
                </div>

                <div class="row">

                    <!-- KOLOM KIRI: STATUS & KERANJANG -->
                    <div class="col-md-3 border-end border-2 border-danger">
                        <h6 class="text-maroon section-header">Status Taskil</h6>
                        <div class="mb-3">
                            <div class="cb-item"><input type="checkbox" name="ul"> <label>UL --> Ulama</label>
                            </div>
                            <div class="cb-item"><input type="checkbox" name="um" checked> <label>UM -->
                                    Rijal</label></div>
                            <div class="cb-item"><input type="checkbox" name="ms"> <label>MS --> Masturot</label>
                            </div>
                            <div class="cb-item"><input type="checkbox" name="ps"> <label>PS --> Pelajar /
                                    Santri</label></div>
                        </div>

                        <h6 class="text-maroon section-header mt-4">Keranjang Karkun</h6>
                        <table class="keranjang-table">
                            <thead>
                                <tr>
                                    <th>NAMA</th>
                                    <th>ASAL</th>
                                    <th>PENGALAMAN</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                <tr id="empty-cart">
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada karkun dipilih</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-2 text-end">
                            <small>Total: <span id="cart-count" class="fw-bold">0</span> orang</small>
                        </div>
                    </div>

                    <!-- KOLOM TENGAH: CHECKBOX & INPUT -->
                    <div class="col-md-5 px-3">

                        <h6 class="text-maroon section-header text-center">Masa Taskil</h6>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="cb-item"><input type="checkbox" name="r3h" class="durasi"
                                        onchange="hitungTanggguh()"> <label>3H --> 3 Hari</label></div>
                                <div class="cb-item"><input type="checkbox" name="r40bs" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40BS --> 40 Hari Biasa</label></div>
                                <div class="cb-item"><input type="checkbox" name="r40jk" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40JK --> 40 Hari Jalan Kaki</label></div>
                                <div class="cb-item"><input type="checkbox" name="r40nj" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40NJ --> 40 Hari Negeri Jiran</label></div>
                                <div class="cb-item"><input type="checkbox" name="r4blbs" class="durasi"
                                        onchange="hitungTanggguh()"> <label>4BLBS --> 4 Bulan Biasa</label></div>
                                <div class="cb-item"><input type="checkbox" name="r4bljk" class="durasi"
                                        onchange="hitungTanggguh()"> <label>4BLJK --> 4 Bulan Jalan Kaki</label></div>
                            </div>
                            <div class="col-6">
                                <div class="cb-item"><input type="checkbox" name="r4blpb" class="durasi"
                                        onchange="hitungTanggguh()"> <label>4BLPB --> 4 Bulan IPB</label></div>
                                <div class="cb-item"><input type="checkbox" name="r4blnj" class="durasi"
                                        onchange="hitungTanggguh()"> <label>4BLNJ --> 4 Bulan Negeri Jauh</label></div>
                                <div class="cb-item"><input type="checkbox" name="r1tdn" class="durasi"
                                        onchange="hitungTanggguh()"> <label>1TDN --> 1 Dalam Negeri</label></div>
                                <div class="cb-item"><input type="checkbox" name="r1tipb" class="durasi"
                                        onchange="hitungTanggguh()"> <label>1TIPB --> 1 Tahun IPB</label></div>
                            </div>
                        </div>

                        <h6 class="text-maroon section-header text-center">Masa Taskil Mastu</h6>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="cb-item"><input type="checkbox" name="m3h" class="durasi"
                                        onchange="hitungTanggguh()"> <label>3H --> 3 Hari</label></div>
                                <div class="cb-item"><input type="checkbox" name="m10d" class="durasi"
                                        onchange="hitungTanggguh()"> <label>10D --> 10 Hari DN</label></div>
                                <div class="cb-item"><input type="checkbox" name="m10n" class="durasi"
                                        onchange="hitungTanggguh()"> <label>10N --> 10 Hari NJ</label></div>
                                <div class="cb-item"><input type="checkbox" name="m40d" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40D --> 40 Hari DN</label></div>
                                <div class="cb-item"><input type="checkbox" name="m40i" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40I --> 40 Hari IPE</label></div>
                                <div class="cb-item"><input type="checkbox" name="m40n" class="durasi"
                                        onchange="hitungTanggguh()"> <label>40N --> 40 Hari NJ</label></div>
                            </div>
                            <div class="col-6">
                                <div class="cb-item"><input type="checkbox" name="m2bld" class="durasi"
                                        onchange="hitungTanggguh()"> <label>2BLD --> 2 Bulan DN</label></div>
                                <div class="cb-item"><input type="checkbox" name="m2bli" class="durasi"
                                        onchange="hitungTanggguh()"> <label>2BLI --> 2 Bulan IPE</label></div>
                                <div class="cb-item"><input type="checkbox" name="m2bln" class="durasi"
                                        onchange="hitungTanggguh()"> <label>2BLN --> 2 Bulan NJ</label></div>
                            </div>
                        </div>

                        <h6 class="text-maroon section-header text-center">Masa Taskil</h6>
                        <div class="row mb-3">
                            <div class="col-12">
                                <!-- Ganti checkbox LBR dan 2XBL dengan input number -->
                                <div class="cb-item">
                                    <label>LBR</label>
                                    <span class="check-arrow">--&gt;</span>
                                    <input type="number" name="lbr" id="lbr"
                                        class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;" placeholder="0" min="0">
                                    <label class="ms-2">Keluar Saat Liburan</label>
                                </div>

                                <div class="cb-item">
                                    <label>2XBL</label>
                                    <span class="check-arrow">--&gt;</span>
                                    <input type="number" name="2xbl" id="2xbl"
                                        class="form-control form-control-sm"
                                        style="width: 60px; display: inline-block;" placeholder="0" min="0">
                                    <label class="ms-2">Keluar 1 Hari 2x setiap Bulan</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="border border-danger rounded p-3 bg-white">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group-custom">
                                        <label class="input-label">B. Hidayah</label>
                                        <input type="date" name="hdy" id="hdy"
                                            class="form-control form-control-sm d-inline w-75"
                                            onchange="hitungTanggguh()">
                                        <span class="ms-1">--> HDY</span>
                                    </div>
                                    <div class="input-group-custom">
                                        <label class="input-label">B. Tangguh</label>
                                        <input type="text" id="display_tgh"
                                            class="form-control form-control-sm d-inline w-75" readonly>
                                        <span class="ms-1">--> TGH</span>
                                        <input type="hidden" name="tgh" id="input_tgh">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group-custom">
                                        <label class="input-label">Amir</label>
                                        <div class="autocomplete-wrapper">
                                            <input type="text" name="amir" id="amir"
                                                class="form-control form-control-sm" placeholder="Ketik nama amir..."
                                                autocomplete="off">
                                            <div id="amir-list" class="autocomplete-list"></div>
                                        </div>
                                        <span class="ms-1">--> AMIR</span>
                                    </div>
                                    <div class="input-group-custom">
                                        <label class="input-label">Rute</label>
                                        <input type="text" name="rute" id="rute"
                                            class="form-control form-control-sm">
                                        <span class="ms-1">--> RUTE</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-sm btn-outline-danger me-2"
                                onclick="resetForm()">Hapus Item</button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="submitPOS()">Simpan dan
                                cetak surat Jalan</button>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PENCARIAN & DETAIL -->
                    <div class="col-md-4 border-start border-2 border-danger ps-3">
                        <h6 class="text-maroon section-header">Mencari Nama Karkun</h6>
                        <input type="text" id="search_pekerja" class="form-control form-control-sm mb-2"
                            placeholder="Ketik nama...">

                        <div class="worker-list" id="worker-list-container">
                            @foreach ($pekerja as $p)
                                <div class="worker-item" data-nam="{{ $p->NAM }}"
                                    data-hal="{{ $p->HAL ?? '-' }}" data-prop="{{ $p->PROP ?? '-' }}"
                                    data-mar="{{ $p->MAR ?? '-' }}" data-mah="{{ $p->MAH ?? '-' }}"
                                    data-sul="{{ $p->SUL ?? '' }}" data-sum="{{ $p->SUM ?? '' }}"
                                    data-sps="{{ $p->SPS ?? '' }}" data-r3h="{{ $p->R3H ?? '' }}"
                                    data-r40d="{{ $p->R40D ?? '' }}" data-r40n="{{ $p->R40N ?? '' }}"
                                    data-r4d="{{ $p->R4D ?? '' }}" data-r4i="{{ $p->R4I ?? '' }}"
                                    data-r4n="{{ $p->R4N ?? '' }}" data-r1d="{{ $p->R1D ?? '' }}"
                                    data-r1i="{{ $p->R1I ?? '' }}" data-r1n="{{ $p->R1N ?? '' }}"
                                    data-m3h="{{ $p->M3H ?? '' }}" data-m10d="{{ $p->M10D ?? '' }}"
                                    data-m10n="{{ $p->M10N ?? '' }}" data-m40d="{{ $p->M40D ?? '' }}"
                                    data-m40i="{{ $p->M40I ?? '' }}" data-m40n="{{ $p->M40N ?? '' }}"
                                    data-m2bd="{{ $p->M2BD ?? '' }}" data-m2bi="{{ $p->M2BI ?? '' }}"
                                    data-m2bn="{{ $p->M2BN ?? '' }}" onclick="addToCartDirectly(this)">
                                    <span class="text-maroon fw-bold">{{ $p->NAM }}</span>
                                    <small class="text-muted">{{ $p->HAL ?? '-' }}</small>
                                </div>
                            @endforeach
                        </div>

                        <!-- Detail Panel (Hanya Informasi) -->
                        <div class="detail-panel">
                            <div class="detail-name" id="det_nama">-</div>
                            <div class="detail-row"><span class="detail-label">Propinsi</span><span
                                    class="detail-separator">:</span><span id="det_prop">-</span></div>
                            <div class="detail-row"><span class="detail-label">Markas</span><span
                                    class="detail-separator">:</span><span id="det_mar">-</span></div>
                            <div class="detail-row"><span class="detail-label">Halaqoh</span><span
                                    class="detail-separator">:</span><span id="det_hal">-</span></div>
                            <div class="detail-row"><span class="detail-label">Mahala</span><span
                                    class="detail-separator">:</span><span id="det_mah">-</span></div>
                            <div class="detail-row"><span class="detail-label">Nama Karkun</span><span
                                    class="detail-separator">:</span><span id="det_karkun" class="fw-bold">-</span>
                            </div>
                            <div class="detail-row"><span class="detail-label">Status</span><span
                                    class="detail-separator">:</span><span id="det_status">-</span></div>
                            <div class="detail-row"><span class="detail-label">Peng. Rijal</span><span
                                    class="detail-separator">:</span><span id="det_rijal">-</span></div>
                            <div class="detail-row"><span class="detail-label">Peng. Masturot</span><span
                                    class="detail-separator">:</span><span id="det_masturot">-</span></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let keranjang = [];
        const allWorkers = @json($pekerja);

        function submitPOS() {
            console.log('=== DEBUG SUBMIT ===');
            console.log('Jumlah keranjang:', keranjang.length);
            console.log('Keranjang:', keranjang);
            console.log('B. Hidayah:', document.getElementById('hdy').value);
            // ... kode selanjutnya
        }

        // 1. Klik Langsung Masuk Keranjang
        function addToCartDirectly(el) {
            // Highlight item yang diklik
            document.querySelectorAll('.worker-item').forEach(i => i.classList.remove('active'));
            el.classList.add('active');

            const data = {
                nam: el.dataset.nam,
                hal: el.dataset.hal,
                prop: el.dataset.prop,
                mar: el.dataset.mar,
                mah: el.dataset.mah,
                sul: el.dataset.sul,
                sum: el.dataset.sum,
                sps: el.dataset.sps,
                r3h: el.dataset.r3h,
                r40d: el.dataset.r40d,
                r40n: el.dataset.r40n,
                r4d: el.dataset.r4d,
                r4i: el.dataset.r4i,
                r4n: el.dataset.r4n,
                r1d: el.dataset.r1d,
                r1i: el.dataset.r1i,
                r1n: el.dataset.r1n,
                m3h: el.dataset.m3h,
                m10d: el.dataset.m10d,
                m10n: el.dataset.m10n,
                m40d: el.dataset.m40d,
                m40i: el.dataset.m40i,
                m40n: el.dataset.m40n,
                m2bd: el.dataset.m2bd,
                m2bi: el.dataset.m2bi,
                m2bn: el.dataset.m2bn
            };

            // Cek duplikat
            if (keranjang.some(k => k.nam === data.nam)) {
                alert('Nama sudah ada di keranjang!');
                return;
            }

            // Tambah ke keranjang
            keranjang.push({
                nam: data.nam,
                hal: data.hal,
                prop: data.prop
            });
            renderKeranjang();

            // Update Detail Panel (Hanya untuk informasi)
            updateDetailPanel(data);

            // PENTING: TIDAK mengisi field Amir secara otomatis
        }

        // 2. Update Panel Detail
        function updateDetailPanel(data) {
            document.getElementById('det_nama').innerText = data.nam;
            document.getElementById('det_prop').innerText = data.prop;
            document.getElementById('det_mar').innerText = data.mar;
            document.getElementById('det_hal').innerText = data.hal;
            document.getElementById('det_mah').innerText = data.mah;
            document.getElementById('det_karkun').innerText = data.nam;

            // Status
            let status = 'Umum';
            if (data.sul && data.sul.toUpperCase() === 'X') status = 'Ulama';
            else if (data.sum && data.sum.toUpperCase() === 'X') status = 'Rijal';
            else if (data.sps && data.sps.toUpperCase() === 'X') status = 'Pelajar/Santri';
            document.getElementById('det_status').innerText = status;

            // Peng. Rijal
            const pengRijal = [];
            if (data.r3h) pengRijal.push('3H');
            if (data.r40d) pengRijal.push('40D');
            if (data.r40n) pengRijal.push('40N');
            if (data.r4d) pengRijal.push('4D');
            if (data.r4i) pengRijal.push('4I');
            if (data.r4n) pengRijal.push('4N');
            if (data.r1d) pengRijal.push('1D');
            if (data.r1i) pengRijal.push('1I');
            if (data.r1n) pengRijal.push('1N');
            document.getElementById('det_rijal').innerText = pengRijal.length > 0 ? pengRijal.join(', ') : '-';

            // Peng. Masturot
            const pengMasturot = [];
            if (data.m3h) pengMasturot.push('3H');
            if (data.m10d) pengMasturot.push('10D');
            if (data.m10n) pengMasturot.push('10N');
            if (data.m40d) pengMasturot.push('40D');
            if (data.m40i) pengMasturot.push('40I');
            if (data.m40n) pengMasturot.push('40N');
            if (data.m2bd) pengMasturot.push('2BLD');
            if (data.m2bi) pengMasturot.push('2BLI');
            if (data.m2bn) pengMasturot.push('2BLN');
            document.getElementById('det_masturot').innerText = pengMasturot.length > 0 ? pengMasturot.join(', ') : '-';
        }

        // 3. Render Keranjang
        function renderKeranjang() {
            const tbody = document.getElementById('cart-body');
            tbody.innerHTML = '';
            document.getElementById('cart-count').innerText = keranjang.length;

            if (keranjang.length === 0) {
                tbody.innerHTML =
                    '<tr id="empty-cart"><td colspan="4" class="text-center text-muted py-3">Belum ada karkun dipilih</td></tr>';
                return;
            }

            keranjang.forEach((k, index) => {
                tbody.innerHTML += `
                <tr>
                    <td>${k.nam}</td>
                    <td>${k.hal}</td>
                    <td>-</td>
                    <td class="text-center">
                        <button type="button" class="btn-hapus" onclick="hapusDariKeranjang(${index})">✕</button>
                    </td>
                </tr>
            `;
            });
        }

        function hapusDariKeranjang(index) {
            keranjang.splice(index, 1);
            renderKeranjang();
        }

        // 4. Autocomplete Amir (Independen)
        $('#amir').on('input', function() {
            const val = $(this).val().toLowerCase();
            const list = $('#amir-list');
            list.empty();

            if (val.length < 2) {
                list.hide();
                return;
            }

            const matches = allWorkers.filter(w => w.NAM.toLowerCase().includes(val));
            if (matches.length === 0) {
                list.hide();
                return;
            }

            matches.forEach(w => {
                list.append(
                    `<div class="autocomplete-item" onclick="selectAmir('${w.NAM}')">${w.NAM}</div>`);
            });
            list.show();
        });

        function selectAmir(nama) {
            $('#amir').val(nama);
            $('#amir-list').hide();
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.autocomplete-wrapper').length) $('#amir-list').hide();
        });

        // 5. Hitung Tangguh
        function hitungTanggguh() {
            let hdy = document.getElementById('hdy').value;
            if (!hdy) return;
            let total = 0;
            const durasi = {
                'r3h': 3,
                'r40bs': 40,
                'r40jk': 40,
                'r40nj': 40,
                'r4blbs': 120,
                'r4bljk': 120,
                'r4blpb': 120,
                'r4blnj': 120,
                'r1tdn': 360,
                'r1tipb': 360,
                'm3h': 3,
                'm10d': 10,
                'm10n': 10,
                'm40d': 40,
                'm40i': 40,
                'm40n': 40,
                'm2bld': 60,
                'm2bli': 60,
                'm2bln': 60,
                'lbr': 3,
                '2xbl': 14
            };
            document.querySelectorAll('.durasi:checked').forEach(cb => total += (durasi[cb.name] || 0));
            let tgl = new Date(hdy);
            tgl.setDate(tgl.getDate() + total);
            let fmt =
                `${String(tgl.getDate()).padStart(2,'0')}/${String(tgl.getMonth()+1).padStart(2,'0')}/${tgl.getFullYear()}`;
            document.getElementById('display_tgh').value = fmt;
            document.getElementById('input_tgh').value =
                `${tgl.getFullYear()}-${String(tgl.getMonth()+1).padStart(2,'0')}-${String(tgl.getDate()).padStart(2,'0')}`;
        }

        // 6. Filter Pencarian
        $('#search_pekerja').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $(".worker-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // 7. Submit POS
        function submitPOS() {
            console.log('Tombol simpan diklik');

            if (keranjang.length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }
            if (!document.getElementById('hdy').value) {
                alert('Isi B. Hidayah dulu!');
                return;
            }

            const form = document.getElementById('formTaskil');

            // Tambahkan hidden inputs untuk cart
            keranjang.forEach((k, i) => {
                const inputNam = document.createElement('input');
                inputNam.type = 'hidden';
                inputNam.name = `cart[${i}][nam]`;
                inputNam.value = k.nam;
                form.appendChild(inputNam);

                const inputHal = document.createElement('input');
                inputHal.type = 'hidden';
                inputHal.name = `cart[${i}][hal]`;
                inputHal.value = k.hal;
                form.appendChild(inputHal);

                const inputProp = document.createElement('input');
                inputProp.type = 'hidden';
                inputProp.name = `cart[${i}][prop]`;
                inputProp.value = k.prop;
                form.appendChild(inputProp);
            });

            console.log('Form akan di-submit');
            form.submit();
        }

        function resetForm() {
            window.location.reload();
        }

        // Disable tombol submit setelah diklik
        document.getElementById('formTaskil').addEventListener('submit', function(e) {
            if (this.dataset.submitting === 'true') {
                e.preventDefault();
                return false;
            }

            if (keranjang.length === 0) {
                e.preventDefault();
                alert('Keranjang masih kosong!');
                return false;
            }

            if (!document.getElementById('hdy').value) {
                e.preventDefault();
                alert('Isi B. Hidayah dulu!');
                return false;
            }

            // Set flag submitting
            this.dataset.submitting = 'true';

            // Disable semua tombol
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = 'Menyimpan...';
            }

            // Tambahkan hidden inputs untuk cart
            const form = this;
            keranjang.forEach((k, i) => {
                const inputNam = document.createElement('input');
                inputNam.type = 'hidden';
                inputNam.name = `cart[${i}][nam]`;
                inputNam.value = k.nam;
                form.appendChild(inputNam);

                const inputHal = document.createElement('input');
                inputHal.type = 'hidden';
                inputHal.name = `cart[${i}][hal]`;
                inputHal.value = k.hal;
                form.appendChild(inputHal);

                const inputProp = document.createElement('input');
                inputProp.type = 'hidden';
                inputProp.name = `cart[${i}][prop]`;
                inputProp.value = k.prop;
                form.appendChild(inputProp);
            });
        });
    </script>

</body>

</html>
