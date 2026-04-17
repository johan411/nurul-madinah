<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nurul Madinah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0e1a;
            --bg-card: rgba(15, 23, 42, 0.8);
            --neon-blue: #00d4ff;
            --neon-green: #00ff88;
            --neon-red: #ff6b6b;
            --neon-yellow: #ffd93d;
            --neon-purple: #c084fc;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: var(--bg-dark);
            color: #e2e8f0;
            overflow: hidden;
            height: 100vh;
        }

        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(192, 132, 252, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(0, 255, 136, 0.05) 0%, transparent 50%);
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        /* Layout */
        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 30px;
        }

        .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(0, 212, 255, 0.5);
        }

        .logo-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        .menu-list {
            list-style: none;
            flex: 1;
        }

        .menu-item {
            margin-bottom: 10px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-radius: 12px;
            text-decoration: none;
            color: #94a3b8;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .menu-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--menu-color, var(--neon-blue)), transparent);
            opacity: 0.1;
            transition: width 0.3s ease;
        }

        .menu-link:hover::before,
        .menu-link.active::before {
            width: 100%;
        }

        .menu-link:hover,
        .menu-link.active {
            background: var(--glass-bg);
            border-color: var(--menu-color, var(--neon-blue));
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
        }

        .menu-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
        }

        .menu-text {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .top-bar {
            height: 70px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .page-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.3rem;
            color: #fff;
        }

        .datetime {
            font-size: 0.9rem;
            color: #64748b;
            font-family: 'Orbitron', sans-serif;
        }

        .content-area {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .content-frame {
            width: 100%;
            height: 100%;
            border: none;
            background: #f8fafc;
        }

        /* Loading Animation */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .loader {
            width: 60px;
            height: 60px;
            border: 3px solid transparent;
            border-top-color: var(--neon-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--glass-border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--neon-blue);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding: 10px;
            }
            .logo-text, .logo-subtitle, .menu-text {
                display: none;
            }
            .menu-icon {
                margin-right: 0;
            }
            .menu-link {
                justify-content: center;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-text">NURUL MADINAH</div>
                <div class="logo-subtitle">SYSTEM DASHBOARD</div>
            </div>

            <ul class="menu-list">
                @foreach($menuItems as $item)
                <li class="menu-item">
                    <a class="menu-link" 
                       data-url="{{ $item['url'] }}" 
                       data-title="{{ $item['name'] }}"
                       data-id="{{ $item['id'] }}"
                       style="--menu-color: {{ $item['color'] }}"
                       @if($loop->first) class="active" @endif>
                        <span class="menu-icon">{{ $item['icon'] }}</span>
                        <span class="menu-text">{{ $item['name'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>

            <div style="padding: 20px 0; border-top: 1px solid var(--glass-border); text-align: center;">
                <small style="color: #475569; font-size: 0.75rem;">v1.0.0 | © 2026</small>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <h1 class="page-title" id="pageTitle">Beranda</h1>
                <div class="datetime" id="datetime"></div>
            </div>

            <div class="content-area">
                <div class="loading-overlay" id="loading">
                    <div class="loader"></div>
                </div>
                <iframe class="content-frame" id="contentFrame" src="/dashboard/home" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
            </div>
        </main>
    </div>

    <script>
        // Update DateTime
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('datetime').textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Menu Navigation
        const menuLinks = document.querySelectorAll('.menu-link');
        const contentFrame = document.getElementById('contentFrame');
        const pageTitle = document.getElementById('pageTitle');
        const loading = document.getElementById('loading');

        menuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active state
                menuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                // Get data
                const url = this.dataset.url;
                const title = this.dataset.title;
                
                // Update title with animation
                pageTitle.style.opacity = '0';
                setTimeout(() => {
                    pageTitle.textContent = title;
                    pageTitle.style.opacity = '1';
                }, 200);
                
                // Show loading
                loading.classList.add('active');
                
                // Load content
                contentFrame.src = url;
                
                // Hide loading when iframe loads
                contentFrame.onload = function() {
                    setTimeout(() => {
                        loading.classList.remove('active');
                    }, 500);
                };
            });
        });

        // Add CSS transition for title
        pageTitle.style.transition = 'opacity 0.2s ease';
    </script>
</body>
</html>