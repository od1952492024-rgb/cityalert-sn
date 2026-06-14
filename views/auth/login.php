
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — CityAlert SN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
         /* Mis à jour par Mbene */
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            --panel-bg: rgba(255, 255, 255, 0.03);
            --panel-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --input-bg: rgba(15, 23, 42, 0.6);
            --error-bg: rgba(239, 68, 68, 0.1);
            --error-text: #fca5a5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Cercles lumineux d'arrière-plan (Effet de profondeur Ambiant) */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: var(--accent);
            filter: blur(120px);
            opacity: 0.15;
            z-index: 0;
        }
        body::before { top: 15%; left: 20%; }
        body::after { bottom: 15%; right: 20%; background: #ec4899; }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .login-card {
            background: var(--panel-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--panel-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 14px;
            color: var(--accent);
            font-size: 24px;
            margin-bottom: 16px;
        }

        .brand-header h1 {
            color: var(--text-main);
            font-size: 24px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .brand-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 6px;
        }

        .error-message {
            background: var(--error-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-text);
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--text-main);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--panel-border);
            border-radius: 12px;
            padding: 14px 16px;
            color: var(--text-main);
            font-size: 15px;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: rgba(15, 23, 42, 0.8);
        }

        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.4);
        }

        .btn-submit {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-submit:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .card-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
        }

        .card-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .card-footer a:hover {
            color: #818cf8;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        
        <div class="brand-header">
            <div class="brand-logo">🇸🇳</div>
            <h1>CityAlert SN</h1>
            <p>Plateforme Municipale de Proximité</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="error-message">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/cityalert/public/" method="POST">
            <div class="form-group">
                <label for="email">Identifiant numérique / Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-control" placeholder="nom@cityalert.sn" required autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Clé de sécurité / Mot de passe</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">S'authentifier sur le portail</button>
        </form>

        <div class="card-footer">
            <span style="color: var(--text-muted);">Citoyen non enregistré ? </span>
            <a href="/cityalert/public/register">Créer un espace</a>
        </div>

    </div>
</div>

</body>
</html>