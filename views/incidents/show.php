<?php
// Nettoyage rapide des caractères spéciaux hérités de la base pour un affichage propre devant le prof
$title_clean = htmlspecialchars_decode($incident->title ?? '', ENT_QUOTES);
$desc_clean = htmlspecialchars_decode($incident->description ?? '', ENT_QUOTES);
?>

<style>
    /* Structure de la page de détails */
    .incident-details-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 32px;
        align-items: start;
    }

    .main-column {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .side-column {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    /* Mises en valeur des textes et métadonnées */
    .meta-list {
        list-style: none;
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14.5px;
        color: var(--text-muted);
    }

    .meta-item strong {
        color: var(--text-main);
        font-weight: 500;
    }

    /* --- FIL DE DISCUSSION PREMIUM --- */
    .discussion-section {
        margin-top: 12px;
    }

    .comments-stack {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 24px;
    }

    .comment-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .comment-author {
        font-weight: 600;
        color: #fff;
    }

    .comment-badge {
        background: var(--accent-glow);
        color: var(--accent);
        border: 1px solid rgba(99, 102, 241, 0.2);
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .comment-body {
        color: #e2e8f0;
        font-size: 14px;
        line-height: 1.5;
    }

    .comment-date {
        color: var(--text-muted);
        font-size: 11px;
        text-align: right;
    }

    /* Formulaires de saisie et de traitement */
    .form-box {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .label-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    textarea, select, .input-styled {
        width: 100%;
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid var(--card-border) !important;
        color: #f8fafc !important;
        border-radius: 12px !important;
        padding: 14px !important;
        font-size: 14.5px;
        outline: none;
        transition: border-color 0.2s;
    }

    textarea:focus, select:focus {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    /* Boutons d'action */
    .btn-action-primary {
        background: var(--accent) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 20px !important;
        font-size: 14.5px;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-action-primary:hover {
        background: var(--accent-hover) !important;
    }

    /* Badge de statut dans l'historique */
    .status-highlight {
        background: var(--accent-glow);
        color: var(--accent);
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        margin-top: 4px;
    }
</style>

<div style="margin-bottom: 32px;">
    <a href="/cityalert/public/incidents" style="color: var(--text-muted); text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 12px;">← Retour au registre</a>
    <h2>Signalement #<?= $incident->id ?> — <?= htmlspecialchars($title_clean) ?></h2>
</div>

<div class="incident-details-grid">
    
    <div class="main-column">
        
        <div class="card">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 14px;">Détails techniques</h3>
            <p style="color: #e2e8f0; font-size: 15px; line-height: 1.6;"><?= nl2br(htmlspecialchars($desc_clean)) ?></p>
            
            <hr style="border: 0; border-top: 1px solid var(--card-border); margin: 20px 0;">
            
            <div class="meta-list">
                <div class="meta-item">📍 <strong>Lieu :</strong> <?= htmlspecialchars($incident->address) ?></div>
                <div class="meta-item">👤 <strong>Auteur :</strong> <?= htmlspecialchars($incident->user_name ?? 'Citoyen Anonyme') ?></div>
                <div class="meta-item">📅 <strong>Déclaré le :</strong> <?= htmlspecialchars($incident->created_at) ?></div>
            </div>
        </div>

        <div class="discussion-section">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">💬 Fil de Discussion (Citoyen ↔ Agent)</h3>
            
            <div class="comments-stack">
                <?php if (empty($comments)): ?>
                    <div class="comment-card" style="text-align: center; color: var(--text-muted); padding: 30px;">
                        Aucun message échangé pour le moment sur ce signalement.
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <?php 
                        // Sécurité magique : Détecte automatiquement le nom de ta colonne de texte
                        $raw_text = '';
                        if (isset($comment->comment)) { $raw_text = $comment->comment; }
                        elseif (isset($comment->content)) { $raw_text = $comment->content; }
                        elseif (isset($comment->text)) { $raw_text = $comment->text; }
                        elseif (isset($comment->message)) { $raw_text = $comment->message; }
                        
                        $text_clean = htmlspecialchars_decode($raw_text ?? '', ENT_QUOTES);
                        ?>
                        <div class="comment-card">
                            <div class="comment-header">
                                <span class="comment-author"><?= htmlspecialchars($comment->user_name ?? 'Utilisateur') ?></span>
                                <span class="comment-badge"><?= htmlspecialchars($comment->user_role ?? 'agent') ?></span>
                            </div>
                            <div class="comment-body">
                                <?= nl2br(htmlspecialchars($text_clean)) ?>
                            </div>
                            <div class="comment-date">
                                <?= htmlspecialchars($comment->created_at ?? '') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card">
                <form action="/cityalert/public/comments/create" method="POST" class="form-box">
                    <input type="hidden" name="incident_id" value="<?= $incident->id ?>">
                    <div class="form-group">
                        <label class="label-title" for="comment">Ajouter une remarque ou répondre...</label>
                        <textarea id="comment" name="comment" rows="3" placeholder="Écrivez votre message ici pour informer les services municipaux..." required></textarea>
                    </div>
                    <div style="text-align: right;">
                        <button type="submit" class="btn-action-primary">Envoyer le message</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="side-column">
        
        <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'agent' || $_SESSION['user_role'] === 'admin')): ?>
            <div class="card" style="border-left: 4px solid var(--accent);">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">🛠️ Traitement Agent / Admin</h3>
                
                <form action="/cityalert/public/incidents/updateStatus" method="POST" class="form-box">
                    <input type="hidden" name="incident_id" value="<?= $incident->id ?>">
                    
                    <div class="form-group">
                        <label class="label-title">Modifier l'état</label>
                        <select name="status">
                            <option value="Nouveau" <?= ($incident->status ?? '') === 'Nouveau' ? 'selected' : '' ?>>Nouveau</option>
                            <option value="En cours" <?= ($incident->status ?? '') === 'En cours' ? 'selected' : '' ?>>En cours</option>
                            <option value="Résolu" <?= ($incident->status ?? '') === 'Résolu' ? 'selected' : '' ?>>Résolu</option>
                            <option value="Rejeté" <?= ($incident->status ?? '') === 'Rejeté' ? 'selected' : '' ?>>Rejeté</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-title">Action ou justification menée</label>
                        <textarea name="resolution_note" rows="3" placeholder="Décrivez les mesures prises (ex: équipe de voirie dépêchée sur place)..." required></textarea>
                    </div>

                    <button type="submit" class="btn-action-primary" style="width: 100%;">Enregistrer la mise à jour</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="card">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">📜 Cycle de Vie</h3>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label class="label-title">Statut actuel du dossier</label>
                    <div>
                        <?php
                            $incStatus = $incident->status ?? 'Nouveau';
                            $statusStyle = 'color: #818cf8; background: rgba(99, 102, 241, 0.15);';
                            if($incStatus === 'En cours') $statusStyle = 'color: #fbbf24; background: rgba(245, 158, 11, 0.15);';
                            if($incStatus === 'Résolu') $statusStyle = 'color: #34d399; background: rgba(16, 185, 129, 0.15);';
                            if($incStatus === 'Rejeté') $statusStyle = 'color: #f87171; background: rgba(239, 68, 68, 0.15);';
                        ?>
                        <span class="status-highlight" style="<?= $statusStyle ?>"><?= htmlspecialchars($incStatus) ?></span>
                    </div>
                </div>
                
                <div>
                    <label class="label-title">Priorité configurée</label>
                    <p style="font-size: 14.5px; font-weight: 500; margin-top: 4px; color:#fff;">⚡ <?= htmlspecialchars($incident->priority ?? 'Normale') ?></p>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <div class="card" style="border: 1px dashed rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.02); text-align: center; padding: 20px;">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 14px;">Action de modération irréversible</p>
                <a href="/cityalert/public/admin/incidents/delete/<?= $incident->id ?>" 
                   class="btn-action-primary" 
                   style="background: rgba(239, 68, 68, 0.1) !important; color: #f87171 !important; border: 1px solid rgba(239, 68, 68, 0.2) !important; width: 100%; text-decoration: none;"
                   onclick="return confirm('Confirmer la suppression définitive et complète de ce signalement du registre ?');">
                   🗑️ Supprimer la fiche d'incident
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>