<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade Data Karkun - Nurul Madinah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f8f0;
            font-family: Arial, sans-serif;
        }

        .filter-section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .data-table {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: #2c5530;
            color: white;
            font-size: 10pt;
            vertical-align: middle;
            text-align: center;
        }

        .table td {
            font-size: 10pt;
            vertical-align: middle;
            text-align: center;
        }

        .nama-cell {
            text-align: left !important;
            font-weight: bold;
        }

        .form-check-input {
            cursor: pointer;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">📋 UPGRADE DATA KARKUN</h4>
                <small class="text-muted">Update status dan pengalaman karkun</small>
            </div>
            <a href="/taskil" class="btn btn-outline-secondary btn-sm">⬅ Kembali ke Taskil</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-section">
            <h6 class="border-bottom pb-2 mb-3">🔍 Filter Data</h6>
            <div class="row g-3">

                <!-- Propinsi -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Propinsi</label>
                    <select class="form-select" id="filterProf" onchange="loadMarkas()">
                        <option value="">-- Pilih Propinsi --</option>
                        @foreach ($profinsi as $p)
                            <option value="{{ $p->PROF }}">{{ $p->PROF }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Markas -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Markas</label>
                    <select class="form-select" id="filterMar" onchange="loadHalaqoh()" disabled>
                        <option value="">-- Pilih Markas --</option>
                    </select>
                </div>

                <!-- Halaqoh -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Halaqoh</label>
                    <select class="form-select" id="filterHal" onchange="loadMahala()" disabled>
                        <option value="">-- Pilih Halaqoh --</option>
                    </select>
                </div>

                <!-- Mahala -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">Mahala</label>
                    <select class="form-select" id="filterMah" onchange="loadData()" disabled>
                        <option value="">-- Pilih Mahala --</option>
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-success btn-sm" onclick="loadData()">
                    🔄 Tampilkan Data
                </button>
                <button class="btn btn-secondary btn-sm" onclick="resetFilter()">
                    ↺ Reset
                </button>
            </div>
        </div>

        <!-- Loading -->
        <div class="loading" id="loading">
            <div class="spinner-border text-success" role="status"></div>
            <p>Memuat data...</p>
        </div>

        <!-- Data Table -->
        <!-- ... (Kode filter di atas tetap sama) ... -->

        <!-- Data Table -->
        <div class="data-table hidden" id="dataSection">
            <form action="{{ route('pekerja.update') }}" method="POST" id="updateForm">
                @csrf

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">📊 Data Karkun (<span id="countData">0</span> orang)</h6>
                    <button type="submit" class="btn btn-primary btn-sm">
                        💾 Simpan Perubahan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="font-size: 11px;">
                        <thead class="bg-dark text-white text-center">
                            <!-- BARIS 1: JUDUL KELOMPOK -->
                            <tr>
                                <th rowspan="2" width="5%">No</th>
                                <th rowspan="2" width="15%">Nama Karkun</th>
                                <th colspan="3">STATUS</th>
                                <th colspan="9">PENGALAMAN RIJAL</th>
                                <th colspan="2">PEL-SAN</th>
                                <th colspan="9">MASTUROT</th>
                                <th colspan="10" rowspan="2">AMAH YANG HIDUP</th>
                            </tr>

                            <!-- BARIS 2: SUB-JUDUL & NAMA KOLOM -->
                            <tr>
                                <!-- STATUS -->
                                <th>UL</th>
                                <th>UM</th>
                                <th>PS</th>
                                
                                <!-- PENGALAMAN RIJAL -->
                                <th colspan="1">3HR</th>
                                <th colspan="2">40 HARI</th>
                                <th colspan="3">4 BULAN</th>
                                <th colspan="3">1 TAHUN</th>

                                <!-- PEL-SAN -->
                                <th>LBR</th>
                                <th>2XL</th>
                            

                                <!-- MASTUROT -->                                
                                <th colspan="1">3HR</th>
                                <th colspan="2">15 HARI</th>
                                <th colspan="3">40 HARI</th>
                                <th colspan="3">2 BULAN</th>

                                <!-- AMAH YANG HIDUP -->
                                
                            </tr>

                            <!-- BARIS 3: DETAIL SUB-KOLOM (Rijal, Masturot, dll) -->                            
                            <tr class="bg-secondary text-white">
                                <td></td>
                                <td></td> <!-- No & Nama -->

                                <!-- STATUS (Empty) -->
                                <td></td>
                                <td></td>
                                <td></td>
                                
                                <!-- RIJAL -->
                                <td></td>
                                <th>DN</th>
                                <th>NJ</th>
                                <th>DN</th>
                                <th>IPB</th>
                                <th>NJ</th>
                                <th>DN</th>
                                <th>IPB</th>
                                <th>NJ</th>

                                <!-- PEL-SAN (Empty) -->
                                <td></td>
                                <td></td>
                               
                                <!-- MASTUROT -->
                                <th></th>
                                <th>DN</th>
                                <th>NJ</th>
                                <th>DN</th>
                                <th>IPB</th>
                                <th>NJ</th>
                                <th>DN</th>
                                <th>IPB</th>
                                <th>NJ</th>
                                
                                <!-- AMAH (Empty) -->
                                <th>MH</th>
                                <th>TM</th>
                                <th>2,5</th>                             
                                <th>J1</th>
                                <th>J2</th>
                                <th>3H</th>
                                <th>TR</th>
                                <th>6SF</th>
                                <th>TMM</th>
                                <th>SMJM</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="text-center align-middle">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- ... (Script di bawah) ... -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
    // Fungsi Helper Checkbox
    function renderCheckbox(id, name, checkedValue) {
        const isChecked = checkedValue == 1 || checkedValue == 'X' ? 'checked' : '';
        return `
            <td>
                <input type="hidden" name="updates[${id}][${name}]" value="0">
                <div class="form-check d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" 
                           name="updates[${id}][${name}]" value="1" ${isChecked}>
                </div>
            </td>
        `;
    }

    function renderInput(id, name, value) {
        return `
            <td>
                <input type="number" class="form-control form-control-sm" 
                       name="updates[${id}][${name}]" value="${value || 0}" 
                       style="width: 50px; text-align: center;">
            </td>
        `;
    }

    // Fungsi Load Markas
    function loadMarkas() {
        const prof = document.getElementById('filterProf').value;
        const marSelect = document.getElementById('filterMar');
        const halSelect = document.getElementById('filterHal');
        const mahSelect = document.getElementById('filterMah');

        console.log('Load Markas - Propinsi:', prof);

        // Reset downstream
        halSelect.innerHTML = '<option value="">-- Pilih Halaqoh --</option>';
        halSelect.disabled = true;
        mahSelect.innerHTML = '<option value="">-- Pilih Mahala --</option>';
        mahSelect.disabled = true;
        document.getElementById('dataSection').classList.add('hidden');

        if (!prof) {
            marSelect.innerHTML = '<option value="">-- Pilih Markas --</option>';
            marSelect.disabled = true;
            return;
        }

        marSelect.innerHTML = '<option value="">Loading...</option>';
        marSelect.disabled = true;

        fetch(`/api/markas/${encodeURIComponent(prof)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data Markas:', data);
                marSelect.innerHTML = '<option value="">-- Pilih Markas --</option>';
                
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.MAR || item.mar;
                        opt.textContent = item.MAR || item.mar;
                        marSelect.appendChild(opt);
                    });
                    marSelect.disabled = false;
                } else {
                    marSelect.innerHTML = '<option value="">-- Tidak ada data --</option>';
                }
            })
            .catch(error => {
                console.error('Error loadMarkas:', error);
                marSelect.innerHTML = '<option value="">-- Error --</option>';
                alert('Gagal memuat data Markas. Cek console (F12)');
            });
    }

    // Fungsi Load Halaqoh
    function loadHalaqoh() {
        const mar = document.getElementById('filterMar').value;
        const halSelect = document.getElementById('filterHal');
        const mahSelect = document.getElementById('filterMah');

        console.log('Load Halaqoh - Markas:', mar);

        mahSelect.innerHTML = '<option value="">-- Pilih Mahala --</option>';
        mahSelect.disabled = true;
        document.getElementById('dataSection').classList.add('hidden');

        if (!mar) {
            halSelect.innerHTML = '<option value="">-- Pilih Halaqoh --</option>';
            halSelect.disabled = true;
            return;
        }

        halSelect.innerHTML = '<option value="">Loading...</option>';
        halSelect.disabled = true;

        fetch(`/api/halaqoh/${encodeURIComponent(mar)}`)
            .then(response => {
                if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                return response.json();
            })
            .then(data => {
                console.log('Data Halaqoh:', data);
                halSelect.innerHTML = '<option value="">-- Pilih Halaqoh --</option>';
                
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.HAL || item.hal;
                        opt.textContent = item.HAL || item.hal;
                        halSelect.appendChild(opt);
                    });
                    halSelect.disabled = false;
                } else {
                    halSelect.innerHTML = '<option value="">-- Tidak ada data --</option>';
                }
            })
            .catch(error => {
                console.error('Error loadHalaqoh:', error);
                halSelect.innerHTML = '<option value="">-- Error --</option>';
            });
    }

    // Fungsi Load Mahala
    function loadMahala() {
        const hal = document.getElementById('filterHal').value;
        const mahSelect = document.getElementById('filterMah');

        console.log('Load Mahala - Halaqoh:', hal);

        if (!hal) {
            mahSelect.innerHTML = '<option value="">-- Pilih Mahala --</option>';
            mahSelect.disabled = true;
            return;
        }

        mahSelect.innerHTML = '<option value="">Loading...</option>';
        mahSelect.disabled = true;

        fetch(`/api/mahala/${encodeURIComponent(hal)}`)
            .then(response => {
                if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                return response.json();
            })
            .then(data => {
                console.log('Data Mahala:', data);
                mahSelect.innerHTML = '<option value="">-- Pilih Mahala --</option>';
                
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.MAH || item.mah;
                        opt.textContent = item.MAH || item.mah;
                        mahSelect.appendChild(opt);
                    });
                    mahSelect.disabled = false;
                } else {
                    mahSelect.innerHTML = '<option value="">-- Tidak ada data --</option>';
                }
            })
            .catch(error => {
                console.error('Error loadMahala:', error);
                mahSelect.innerHTML = '<option value="">-- Error --</option>';
            });
    }

    // Fungsi Load Data Tabel
    function loadData() {
        const prof = document.getElementById('filterProf').value;
        const mar = document.getElementById('filterMar').value;
        const hal = document.getElementById('filterHal').value;
        const mah = document.getElementById('filterMah').value;

        console.log('Load Data - Filter:', { prof, mar, hal, mah });

        if (!prof || !mar) {
            alert('Minimal pilih Propinsi dan Markas!');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('dataSection').classList.add('hidden');

        const params = new URLSearchParams();
        if (prof) params.append('prof', prof);
        if (mar) params.append('mar', mar);
        if (hal) params.append('hal', hal);
        if (mah) params.append('mah', mah);

        fetch(`/pekerja/filter?${params}`)
            .then(response => {
                if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                return response.json();
            })
            .then(data => {
                console.log('Data Pekerja:', data);
                document.getElementById('loading').style.display = 'none';
                document.getElementById('dataSection').classList.remove('hidden');
                document.getElementById('countData').textContent = data.length;
                
                if (data.length > 0) {
                    renderTable(data);
                } else {
                    document.getElementById('tableBody').innerHTML = 
                        '<tr><td colspan="35" class="text-center py-4">Data tidak ditemukan</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error loadData:', error);
                document.getElementById('loading').style.display = 'none';
                alert('Gagal memuat data. Cek Console (F12) untuk detail error.');
            });
    }

    // Fungsi Render Tabel
    function renderTable(data) {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';

        data.forEach((p, index) => {
            const tr = document.createElement('tr');
            
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td class="text-start ps-3"><strong>${p.NAM || p.nam}</strong></td>
                
                <!-- STATUS -->
                ${renderCheckbox(p.id, 'SUL', p.SUL || p.sul)}
                ${renderCheckbox(p.id, 'SUM', p.SUM || p.sum)}
                ${renderCheckbox(p.id, 'SPS', p.SPS || p.sps)}               
                
                <!-- RIJAL -->
                ${renderCheckbox(p.id, 'R3H', p.R3H || p.r3h)}
                ${renderCheckbox(p.id, 'R40D', p.R40D || p.r40d)}
                ${renderCheckbox(p.id, 'R40N', p.R40N || p.r40n)}
                ${renderCheckbox(p.id, 'R4D', p.R4D || p.r4d)}
                ${renderCheckbox(p.id, 'R4I', p.R4I || p.r4i)}
                ${renderCheckbox(p.id, 'R4N', p.R4N || p.r4N)}
                ${renderCheckbox(p.id, 'R1D', p.R1D || p.r1D)}
                ${renderCheckbox(p.id, 'R1I', p.R1I || p.r1i)}
                ${renderCheckbox(p.id, 'R1N', p.R1N || p.r1N)}
                
                <!-- PEL-SAN -->
                ${renderCheckbox(p.id, 'PLBR', p.PLBR || p.plbr)}
                ${renderCheckbox(p.id, '2XBL', p['2XBL'] || p['2xbl'])}                
                
                <!-- MASTUROT -->
                ${renderCheckbox(p.id, 'M3H', p.M3H || p.m3h)}
                ${renderCheckbox(p.id, 'M10D', p.M10D || p.m10d)}
                ${renderCheckbox(p.id, 'M10N', p.M10N || p.m10n)}
                ${renderCheckbox(p.id, 'M40D', p.M40D || p.m40d)}
                ${renderCheckbox(p.id, 'M40I', p.M40I || p.m40i)}
                ${renderCheckbox(p.id, 'M40N', p.M40N || p.m40n)}
                ${renderCheckbox(p.id, 'M2BD', p.M2BD || p.m2bd)}
                ${renderCheckbox(p.id, 'M2BI', p.M2BI || p.m2bi)}
                ${renderCheckbox(p.id, 'M2BN', p.M2BN || p.m2bn)}
                
                <!-- AMAH -->
                ${renderCheckbox(p.id, 'AMMH', p.AMMH || p.ammh)}
                ${renderCheckbox(p.id, 'AMTM', p.AMTM || p.amtm)}
                ${renderCheckbox(p.id, 'AM25', p.AM25 || p.am25)}
                ${renderCheckbox(p.id, 'AMJ1', p.AMJ1 || p.amj1)}
                ${renderCheckbox(p.id, 'AMJ2', p.AMJ2 || p.amj2)}
                ${renderCheckbox(p.id, 'AM3H', p.AM3H || p.am3h)}
                ${renderCheckbox(p.id, 'ARTR', p.ARTR || p.artr)}
                ${renderCheckbox(p.id, 'AR6S', p.AR6S || p.ar6s)}
                ${renderCheckbox(p.id, 'ARTMM', p.ARTMM || p.artmm)}
                ${renderCheckbox(p.id, 'RSMJ', p.RSMJ|| p.rsmj)}
            `;
            
            tbody.appendChild(tr);
        });
    }

    // Fungsi Reset
    function resetFilter() {
        document.getElementById('filterProf').value = '';
        document.getElementById('filterMar').innerHTML = '<option value="">-- Pilih Markas --</option>';
        document.getElementById('filterMar').disabled = true;
        document.getElementById('filterHal').innerHTML = '<option value="">-- Pilih Halaqoh --</option>';
        document.getElementById('filterHal').disabled = true;
        document.getElementById('filterMah').innerHTML = '<option value="">-- Pilih Mahala --</option>';
        document.getElementById('filterMah').disabled = true;
        document.getElementById('dataSection').classList.add('hidden');
    }

    // Debug: Pastikan DOM sudah loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Loaded - Script siap');
    });
</script>