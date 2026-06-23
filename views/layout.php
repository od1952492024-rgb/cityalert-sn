<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail — CityAlert SN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-main: #090d16;
            --sidebar-bg: #0f172a;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.07);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Layout Structure */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar exclusive */
        .sidebar {
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .sidebar-brand .flag {
            font-size: 24px;
        }

        .sidebar-brand h1 {
            font-size: 19px;
            font-weight: 600;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--card-border);
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 32px;
        }

        .user-badge .name {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-badge .role {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--accent);
            margin-top: 4px;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .sidebar nav a:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.04);
        }

        .sidebar nav a.active {
            color: var(--text-main);
            background: var(--accent-glow);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .sidebar .logout-link {
            margin-top: auto;
            color: #f87171 !important;
        }
        
        .sidebar .logout-link:hover {
            background: rgba(239, 68, 68, 0.1) !important;
        }

        /* Main Content */
        .main-content {
            padding: 40px 48px;
            overflow-y: auto;
            max-width: 1400px;
            width: 100%;
        }

        /* Éléments de design réutilisables pour les sous-vues */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 24px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        h2 {
            font-size: 26px;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 15px;
            margin-bottom: 32px;
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        <div class="sidebar">
            <div class="sidebar-brand">
                <span class="flag">🇸🇳</span>
                <h1>CityAlert Portal</h1>
            </div>
            
            <div class="user-badge">
                <span class="name"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <span class="role"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
            </div>
            
            <nav>
                <a href="/cityalert/public/incidents" class="active">📋 Régistre des incidents</a>
                
                <?php if($_SESSION['user_role'] === 'citoyen'): ?>
                    <a href="/cityalert/public/incidents/create">➕ Déclarer un incident</a>
                <?php endif; ?>

                <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="/cityalert/public/admin/dashboard" style="color:#4ade80;">📊 Analyse Console</a>
                <?php endif; ?>
                
                <a href="/cityalert/public/logout" class="logout-link">🚪 Clôturer la session</a>
            </nav>
        </div>
        
        <div class="main-content">
            <?php require $view; ?>
        </div>
    </div>
</body>
</html>