<style>
    /* Filtres bar */
    .filter-bar {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        margin-bottom: 32px;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-filter label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .select-custom {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid var(--card-border);
        color: var(--text-main);
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
        min-width: 160px;
        cursor: pointer;
    }

    .select-custom:focus {
        border-color: var(--accent);
    }

    .btn-filter {
        background: var(--text-main);
        color: var(--bg-main);
        border: none;
        padding: 11px 20px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-filter:hover {
        opacity: 0.9;
    }

    /* Table ultra-clean */
    .table-container {
        overflow-x: auto;
        margin-top: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        padding: 16px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted);
        border-bottom: 1px solid var(--card-border);
        letter-spacing: 0.5px;
    }

    td {
        padding: 18px 16px;
        font-size: 14px;
        color: var(--text-main);
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.01);
    }

    /* Badges de Statut et Priorités Evolués */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .prio-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .prio-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        border: 1px solid var(--card-border);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-action:hover {
        background: var(--accent);
        border-color: var(--accent);
    }
</style>

<h2>Registre des Signalements</h2>
<p class="subtitle">Indexation en temps réel des anomalies d'infrastructures.</p>

<div class="card" style="padding: 16px 24px; margin-bottom: 32px;">
    <form method="GET" action="" class="filter-bar">
        <div class="form-group-filter">
            <label>Statut</label>
            <select name="status" class="select-custom">
                <option value="">Tous</option>
                <option value="Nouveau">Nouveau</option>
                <option value="En cours">En cours</option>
                <option value="Résolu">Résolu</option>
                <option value="Rejeté">Rejeté</option>
            </select>
        </div>
        <div class="form-group-filter">
            <label>Catégorie</label>
            <select name="category" class="select-custom">
                <option value="">Toutes</option>
                <option value="voirie">Voirie</option>
                <option value="eclairage">Éclairage</option>
                <option value="dechets">Déchets</option>
                <option value="eau">Eau & Assainissement</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">Appliquer les filtres</button>
    </form>
</div>

<div class="card" style="padding: 0;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Anomalie</th>
                    <th>Catégorie</th>
                    <th>Localisation</th>
                    <th>Statut</th>
                    <th>Criticité</th>
                    <th>Résolution</th>
                    <th>Fiche</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($incidents)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">Aucun incident répertorié.</td>
                </tr>
                <?php endif; ?>
                <?php foreach($incidents as $inc): ?>
                <tr>
                    <td><strong style="font-weight: 500; color: #fff;"><?= htmlspecialchars($inc->title) ?></strong></td>
                    <td style="color: var(--text-muted); text-transform: capitalize;"><?= $inc->category ?></td>
                    <td style="color: var(--text-muted);"><?= htmlspecialchars($inc->address) ?></td>
                    <td>
                        <?php
                            $statusColor = 'rgba(255,255,255,0.1)';
                            if($inc->status === 'Nouveau') $statusColor = 'rgba(99, 102, 241, 0.15); color: #818cf8;';
                            if($inc->status === 'En cours') $statusColor = 'rgba(245, 158, 11, 0.15); color: #fbbf24;';
                            if($inc->status === 'Résolu') $statusColor = 'rgba(16, 185, 129, 0.15); color: #34d399;';
                            if($inc->status === 'Rejeté') $statusColor = 'rgba(239, 68, 68, 0.15); color: #f87171;';
                        ?>
                        <span class="status-badge" style="<?= $statusColor ?>"><?= $inc->status ?></span>
                    </td>
                    <td>
                        <?php
                            $dotColor = '#94a3b8';
                            if($inc->priority === 'Urgente' || $inc->priority === 'Haute') $dotColor = 'var(--danger)';
                            if($inc->priority === 'Moyenne') $dotColor = 'var(--warning)';
                            if($inc->priority === 'Normale') $dotColor = 'var(--success)';
                        ?>
                        <span class="prio-indicator"><span class="prio-dot" style="background: <?= $dotColor ?>;"></span><?= $inc->priority ?></span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 13px;">J+<?= $inc->resolution_deadline ?></td>
                    <td>
                        <a href="/cityalert/public/incidents/show/<?= $inc->id ?>" class="btn-action">Ouvrir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>