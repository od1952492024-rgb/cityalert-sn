<style>
    /* Grille de statistiques */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .stat-card .label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-main);
        margin-top: 8px;
    }

    /* Section à deux colonnes pour le CRUD */
    .admin-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
        margin-top: 32px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        letter-spacing: -0.3px;
        margin-bottom: 20px;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Formulaire épuré pour l'ajout de catégorie */
    .form-dark {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-dark input, .form-dark select {
        width: 100%;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid var(--card-border);
        border-radius: 10px;
        padding: 12px 14px;
        color: var(--text-main);
        font-size: 14px;
        outline: none;
    }

    .form-dark input:focus {
        border-color: var(--accent);
    }

    .btn-primary-dark {
        background: var(--accent);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-primary-dark:hover {
        background: #4f46e5;
    }

    /* Actions CRUD */
    .btn-danger-sm {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger-sm:hover {
        background: var(--danger);
        color: white;
    }

    .btn-secondary-sm {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        border: 1px solid var(--card-border);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-secondary-sm:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted);
        border-bottom: 1px solid var(--card-border);
    }

    td {
        padding: 14px 16px;
        font-size: 13.5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    }
</style>

<h2>Console d'Administration</h2>
<p class="subtitle">Supervision globale, gestion du CRUD et sécurité du système municipal.</p>

<!-- 1. KPI / STATISTIQUES GLOBALES -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Incidents</div>
        <div class="number"><?= count($incidents ?? []) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Citoyens Inscrits</div>
        <div class="number">142</div>
    </div>
    <div class="stat-card">
        <div class="label">Agents Actifs</div>
        <div class="number">8</div>
    </div>
    <div class="stat-card">
        <div class="label">Taux de Résolution</div>
        <div class="number" style="color: var(--success);">84%</div>
    </div>
</div>

<div class="admin-grid">
    
    <!-- COLONNE GAUCHE : GESTION DES UTILISATEURS (READ / UPDATE / DELETE) -->
    <div class="card" style="padding: 20px 0;">
        <div class="section-title" style="padding: 0 20px;">
            <span>👥 Contrôle des Comptes Utilisateurs</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Nom / Matricule</th>
                    <th>Email</th>
                    <th>Rôle Actuel</th>
                    <th style="text-align: right;">Actions Administrateur</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemple d'utilisateur 1 (Agent à révoquer au besoin) -->
                <tr>
                    <td><strong>Agent Municipal</strong></td>
                    <td style="color: var(--text-muted);">agent@cityalert.sn</td>
                    <td><span style="color: var(--warning); font-weight: 600;">AGENT</span></td>
                    <td style="text-align: right; display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="/cityalert/public/admin/users/demote/1" class="btn-secondary-sm">Rétrograder</a>
                        <a href="#" class="btn-danger-sm">Révoquer</a>
                    </td>
                </tr>
                <!-- Exemple d'utilisateur 2 (Citoyen à promouvoir) -->
                <tr>
                    <td>Ousmane Diallo</td>
                    <td style="color: var(--text-muted);">ousmane@exemple.sn</td>
                    <td><span style="color: var(--text-muted);">CITOYEN</span></td>
                    <td style="text-align: right;">
                        <a href="/cityalert/public/admin/users/promote/2" class="btn-secondary-sm" style="color: #4ade80; border-color: rgba(74, 222, 128, 0.2);">Promouvoir Agent</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- COLONNE DROITE : CREATION COMPLÈTE (CREATE DE NOUVELLES CATEGORIES) -->
    <div class="card">
        <div class="section-title">
            <span>✨ Nouvelle Compétence (Category Create)</span>
        </div>
        
        <form action="/cityalert/public/admin/categories/create" method="POST" class="form-dark">
            <div>
                <label style="font-size: 12px; color: var(--text-muted); display:block; margin-bottom:6px;">Nom de la catégorie</label>
                <input type="text" name="category_name" placeholder="Ex: Espaces Verts, Animaux..." required>
            </div>
            
            <div>
                <label style="font-size: 12px; color: var(--text-muted); display:block; margin-bottom:6px;">Direction Responsable</label>
                <select name="department">
                    <option value="voirie">Direction de la Voirie Urbaine</option>
                    <option value="environnement">Direction Environnement & Cadre de vie</option>
                    <option value="securite">Sécurité Publique</option>
                </select>
            </div>

            <button type="submit" class="btn-primary-dark">Déployer la catégorie</button>
        </form>
    </div>

</div>

<!-- SECTION BASSE : PURGE ET NETTOYAGE COMPLET (DELETE DU CRUD) -->
<div class="card" style="margin-top: 32px; border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h4 style="color: #f87171; font-weight: 600; font-size: 16px;">Zone de Sécurité & Purge</h4>
            <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">En tant qu'administrateur, vous avez le pouvoir de supprimer définitivement les données obsolètes.</p>
        </div>
        <a href="/cityalert/public/admin/incidents/purge" 
           class="btn-danger-sm" 
           style="padding: 12px 20px; font-weight: 500;"
           onclick="return confirm('Attention ! Vous allez archiver et supprimer toutes les lignes de test. Continuer ?');">
           💥 Purger le Registre des Incidents
        </a>
    </div>
</div>