<h2>Signaler un nouvel incident</h2>
<p style="color: #64748b;">Aidez nos services municipaux à intervenir au plus vite.</p>

<div class="card" style="max-width: 600px;">
    <form action="" method="POST">
        <div class="form-group">
            <label>Titre abrégé du problème</label>
            <input type="text" name="title" class="form-control" required placeholder="Ex: Nid de poule important, Lampadaire cassé...">
        </div>
        
        <div class="form-group">
            <label>Catégorie de l'incident</label>
            <select name="category" class="form-control" required>
                <option value="voirie">Voirie (Routes, Trottoirs)</option>
                <option value="eclairage">Éclairage Public</option>
                <option value="dechets">Déchets & Dépôts sauvages</option>
                <option value="eau">Eau & Assainissement</option>
            </select>
        </div>

        <div class="form-group">
            <label>Adresse / Localisation précise</label>
            <input type="text" name="address" class="form-control" required placeholder="Ex: Rue 10 en face de la boulangerie">
        </div>

        <div class="form-group">
            <label>Description détaillée</label>
            <textarea name="description" class="form-control" rows="4" required placeholder="Donnez le plus de détails possibles pour guider les agents municipaux..."></textarea>
        </div>

        <button type="submit" class="btn">Envoyer le signalement</button>
    </form>
</div>