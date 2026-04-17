<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Rajdhani', sans-serif;
            background: transparent;
            color: #e2e8f0;
            padding: 40px;
            height: 100vh;
            overflow: auto;
        }

        .welcome-card {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(192, 132, 252, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .welcome-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #00d4ff, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: #00d4ff;
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.2);
        }

        .stat-icon { font-size: 2.5rem; margin-bottom: 10px; }
        .stat-number {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #00d4ff;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 5px;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .quick-link {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            text-decoration: none;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .quick-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00ff88;
            transform: translateX(10px);
        }

        .quick-link-icon { font-size: 2rem; }
        .quick-link-text { font-size: 1.1rem; font-weight: 500; }
    </style>
</head>
<body>
    <div class="welcome-card">
        <h1 class="welcome-title">SELAMAT DATANG</h1>
        <p class="welcome-subtitle">Sistem Manajemen Data Jama'ah Tabligh</p>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-number">4</div>
                <div class="stat-label">Modul Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number">872</div>
                <div class="stat-label">Total Karkun</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🕌</div>
                <div class="stat-number">7</div>
                <div class="stat-label">Halaqoh</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number">LIVE</div>
                <div class="stat-label">Status Sistem</div>
            </div>
        </div>

        <div class="quick-links">
            <a href="/taskil" class="quick-link" target="_parent">
                <span class="quick-link-icon">📋</span>
                <span class="quick-link-text">Buka Surat Jalan Taskil</span>
            </a>
            <a href="/pekerja" class="quick-link" target="_parent">
                <span class="quick-link-icon">⚡</span>
                <span class="quick-link-text">Upgrade Data Karkun</span>
            </a>
            <a href="/monitoring" class="quick-link" target="_parent">
                <span class="quick-link-icon">📊</span>
                <span class="quick-link-text">Monitoring Potensi Kerja</span>
            </a>
        </div>
    </div>
</body>
</html>