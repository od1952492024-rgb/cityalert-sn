<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - CityAlert</title>
    <link rel="stylesheet" href="/cityalert/public/css/style.css">
</head>
<body style="background: #f1f5f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin:0;">
    <div class="card" style="width: 400px; padding: 30px;">
        <h2 style="text-align: center; color: #1e3a8a; margin-bottom: 20px;">Créer un compte Citoyen</h2>

        <form action="" method="POST">
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" class="form-control" required placeholder="Ousmane Diallo">
            </div>
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" class="form-control" required placeholder="adresse@email.sn">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimum 6 caractères">
            </div>
            <button type="submit" class="btn">S'inscrire</button>
        </form>
        <p style="text-align: center; font-size: 14px; margin-top: 20px;">
            Déjà inscrit ? <a href="/cityalert/public/" style="color: #2563eb; text-decoration: none; font-weight: bold;">Se connecter</a>
        </p>
    </div>
</body>
</html>