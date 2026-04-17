<!DOCTYPE html>
<html>
<head>
    <title>Input Wilayah Kerja Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #c8f7c5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .group-title { color: #800000; font-weight: bold; border-bottom: 1px solid #666; margin-bottom: 8px; font-size: 0.9rem; }
        .section-label { color: red; font-style: italic; font-size: 0.75rem; }
        .form-select-sm, .form-control-sm { border-radius: 0; border: 1px solid #999; background-color: white; }
        .entry-header { font-weight: bold; font-size: 1.1rem; }
        .red-text { color: red; font-weight: bold; }
        .ck-label { font-size: 0.85rem; font-weight: 500; }
        .arrow-text { font-weight: bold; font-size: 0.8rem; margin-right: 5px; }
    </style>
</head>
<body>
<div class="container-fluid p-4">
    <form action="/pekerja/simpan" method="POST">
        @csrf
        
        <div class="row mb-4">
            <div class="col-md-4">
                <span class="entry-header">Entery</span> {{ date('d/m/Y') }} --- > <span class="fw-bold">TGL</span>
                <h3 class="fw-bold mt-2">WILAYAH KERJA <span class="red-text">BARU</span></h3>
                
                <div class="row mt-3 g-2">
                    <div class="col-4 small fw-bold">Propinsi</div>
<div class="col-8 mb-1">
    <input name="prof" id="input_prof" list="data_prof" class="form-control form-control-sm" placeholder="Pilih Propinsi...">
    <datalist id="data_prof">
        @foreach($list_prof as $p) <option value="{{ $p }}"> @endforeach
    </datalist>
</div>

<div class="col-4 small fw-bold">Markas</div>
<div class="col-8 mb-1">
    <input name="mar" id="input_mar" list="data_mar" class="form-control form-control-sm" placeholder="Pilih Markas...">
    <datalist id="data_mar"></datalist>
</div>

<div class="col-4 small fw-bold mt-4">Halaqoh</div>
<div class="col-8 mt-4 mb-1">
    <input name="hal" id="input_hal" list="data_hal" class="form-control form-control-sm" placeholder="Pilih Halaqoh...">
    <datalist id="data_hal"></datalist>
</div>

<div class="col-4 small fw-bold">Mahala</div>
<div class="col-8 mb-1">
    <input name="mah" id="input_mah" list="data_mah" class="form-control form-control-sm" placeholder="Pilih Mahala...">
    <datalist id="data_mah"></datalist>
</div>

<script>
    const dbData = {!! $data_wilayah->toJson() !!};

    function updateDatalist(inputId, listId, filterKey, filterValue, targetKey) {
        const list = document.getElementById(listId);
        list.innerHTML = '';
        
        // Filter data unik berdasarkan pilihan sebelumnya
        const filtered = [...new Set(dbData
            .filter(item => item[filterKey] === filterValue)
            .map(item => item[targetKey]))];

        filtered.forEach(val => {
            if(val) list.innerHTML += `<option value="${val}">`;
        });
    }

    // Ketika Propinsi dipilih -> Update Markas
    document.getElementById('input_prof').addEventListener('change', function() {
        updateDatalist('input_mar', 'data_mar', 'PROF', this.value, 'MAR');
    });

    // Ketika Markas dipilih -> Update Halaqoh
    document.getElementById('input_mar').addEventListener('change', function() {
        const prof = document.getElementById('input_prof').value;
        const filteredHal = [...new Set(dbData
            .filter(item => item.PROF === prof && item.MAR === this.value)
            .map(item => item.HAL))];
            
        const list = document.getElementById('data_hal');
        list.innerHTML = '';
        filteredHal.forEach(val => { if(val) list.innerHTML += `<option value="${val}">`; });
    });

    // Ketika Halaqoh dipilih -> Update Mahala
    document.getElementById('input_hal').addEventListener('change', function() {
        const prof = document.getElementById('input_prof').value;
        const mar = document.getElementById('input_mar').value;
        const filteredMah = [...new Set(dbData
            .filter(item => item.PROF === prof && item.MAR === mar && item.HAL === this.value)
            .map(item => item.MAH))];
            
        const list = document.getElementById('data_mah');
        list.innerHTML = '';
        filteredMah.forEach(val => { if(val) list.innerHTML += `<option value="${val}">`; });
    });
</script>
                    
                    <div class="col-12 mt-3">
                        <label class="small fw-bold">Nama <span class="section-label">Karkun</span></label>
                        <input type="text" name="nama" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="group-title text-end">Usaha <span class="section-label">Pelajar / Santri</span></div>
                        <div class="d-flex justify-content-end gap-3">
                            <span>
    <span class="arrow-text">PLBR ---></span>
    <input type="number" name="plbr" class="form-control d-inline-block" style="width: 60px;" placeholder="0"> 
    <span class="ck-label">Keluar Saat Liburan (Hari)</span>
</span>
                            <span><span class="arrow-text">PHMS ---></span><input type="checkbox" name="phms" value="x"> <span class="ck-label">Hadir Malam Subgozari</span></span>
                            <span><span class="arrow-text">PHM ---></span><input type="checkbox" name="phm" value="x"> <span class="ck-label">Hadir Musyawarah</span></span>
                        </div>
                    </div>

                    <div class="col-md-4 offset-md-4">
                        <div class="group-title">Status <span class="section-label">Pekerja</span></div>
                        <div class="mb-1"><span class="arrow-text">SUL ---></span><input type="checkbox" name="sul" value="x"> <span class="ck-label">Ulama</span></div>
                        <div class="mb-1"><span class="arrow-text">SUM ---></span><input type="checkbox" name="sum" value="x"> <span class="ck-label">Umum</span></div>
                        <div class="mb-1"><span class="arrow-text">SPS ---></span><input type="checkbox" name="sps" value="x"> <span class="ck-label">Pelajar / Santri</span></div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="group-title">Pengalaman <span class="section-label">Rijal</span></div>
                        <div class="mb-1"><span class="arrow-text">R3h ---></span><input type="checkbox" name="r3h" value="x"> <span class="ck-label">3 Hari</span></div>
                        <div class="mb-1"><span class="arrow-text">R40D ---></span><input type="checkbox" name="r40d" value="x"> <span class="ck-label">40 Hari DN</span></div>
                        <div class="mb-1"><span class="arrow-text">R40N ---></span><input type="checkbox" name="r40n" value="x"> <span class="ck-label">40 Hari NJ</span></div>
                        <div class="mb-1"><span class="arrow-text">R4D ---></span><input type="checkbox" name="r4d" value="x"> <span class="ck-label">4 Bulan DN</span></div>
                        <div class="mb-1"><span class="arrow-text">R4I ---></span><input type="checkbox" name="r4i" value="x"> <span class="ck-label">4 Bulan IPB</span></div>
                        <div class="mb-1"><span class="arrow-text">R4N ---></span><input type="checkbox" name="r4n" value="x"> <span class="ck-label">4 Bulan NJ</span></div>
                        <div class="mb-1"><span class="arrow-text">R1D ---></span><input type="checkbox" name="r1d" value="x"> <span class="ck-label">1 Tahun DN</span></div>
                        <div class="mb-1"><span class="arrow-text">R1I ---></span><input type="checkbox" name="r1i" value="x"> <span class="ck-label">1 Tahun IPB</span></div>
                        <div class="mb-1"><span class="arrow-text">R1N ---></span><input type="checkbox" name="r1n" value="x"> <span class="ck-label">1 Tahun NJ</span></div>
                    </div>

                    <div class="col-md-4">
                        <div class="group-title">Menghidupkan <span class="section-label">Amal Masjid</span></div>
                        <div class="mb-1"><span class="arrow-text">AMMH ---></span><input type="checkbox" name="ammh" value="x"> <span class="ck-label">Musyawarah Harian</span></div>
                        <div class="mb-1"><span class="arrow-text">AMTM ---></span><input type="checkbox" name="amtm" value="x"> <span class="ck-label">Taklim Masjid</span></div>
                        <div class="mb-1"><span class="arrow-text">AM25 ---></span><input type="checkbox" name="am25" value="x"> <span class="ck-label">Kunjungan 2,5 Jam</span></div>
                        <div class="mb-1"><span class="arrow-text">AMJ1 ---></span><input type="checkbox" name="amj1" value="x"> <span class="ck-label">Jaula 1</span></div>
                        <div class="mb-1"><span class="arrow-text">AMJ2 ---></span><input type="checkbox" name="amj2" value="x"> <span class="ck-label">Jaula 2</span></div>
                        <div class="mb-1"><span class="arrow-text">AM3H ---></span><input type="checkbox" name="am3h" value="x"> <span class="ck-label">3 Hari / Bulan</span></div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="group-title">Pengalaman <span class="section-label">Masturot</span></div>
                        <div class="mb-1"><span class="arrow-text">M3H ---></span><input type="checkbox" name="m3h" value="x"> <span class="ck-label">3 Hari</span></div>
                        <div class="mb-1"><span class="arrow-text">M10D ---></span><input type="checkbox" name="m10d" value="x"> <span class="ck-label">10 Hari DN</span></div>
                        <div class="mb-1"><span class="arrow-text">M10N ---></span><input type="checkbox" name="m10n" value="x"> <span class="ck-label">10 Hari NJ</span></div>
                        <div class="mb-1"><span class="arrow-text">M40D ---></span><input type="checkbox" name="m40d" value="x"> <span class="ck-label">40 Hari DN</span></div>
                        <div class="mb-1"><span class="arrow-text">M40I ---></span><input type="checkbox" name="m40i" value="x"> <span class="ck-label">40 Hari IPB</span></div>
                        <div class="mb-1"><span class="arrow-text">M40N ---></span><input type="checkbox" name="m40n" value="x"> <span class="ck-label">40 Hari NJ</span></div>
                        <div class="mb-1"><span class="arrow-text">M2BD ---></span><input type="checkbox" name="m2bd" value="x"> <span class="ck-label">2 Bulan DN</span></div>
                        <div class="mb-1"><span class="arrow-text">M2BI ---></span><input type="checkbox" name="m2bi" value="x"> <span class="ck-label">2 Bulan IPB</span></div>
                        <div class="mb-1"><span class="arrow-text">M2BN ---></span><input type="checkbox" name="m2bn" value="x"> <span class="ck-label">2 Bulan NJ</span></div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="group-title">Menghidupkan <span class="section-label">Amal Rumah</span></div>
                        <div class="mb-1"><span class="arrow-text">ARTR ---></span><input type="checkbox" name="artr" value="x"> <span class="ck-label">Hidup Taklim Rumah</span></div>
                        <div class="mb-1"><span class="arrow-text">AR6S ---></span><input type="checkbox" name="ar6s" value="x"> <span class="ck-label">Dengan 6 Sifat</span></div>
                        <div class="mb-1"><span class="arrow-text">ARTMM ---></span><input type="checkbox" name="artmm" value="x"> <span class="ck-label">Hadir TMM</span></div>
                        <div class="mb-1"><span class="arrow-text">RSMJ ---></span><input type="checkbox" name="rsmj" value="x"> <span class="ck-label">Rumah siap Menerima jama'ah Masturot</span>
                    </div>
    
                    <div class="mt-3">
                        <label class="small fw-bold">ARMHL ---> Tempat Taklim Mahala</label>
                         <input type="text" name="armhl" class="form-control form-control-sm">
                    </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            
            @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mt-4">
    <button type="submit" class="btn btn-light border shadow-sm px-4 fw-bold">Simpan</button>
    
    <a href="/" class="btn btn-light border shadow-sm px-4 fw-bold text-danger">Selesai / Batal</a>
</div>
        
        </div>
    </form>
</div>
</body>
</html>