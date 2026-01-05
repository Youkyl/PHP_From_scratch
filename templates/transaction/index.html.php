<?php
   // dd($comptes)
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des transactions | Admin Bancaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial}
        body{background:#f9fafb;color:#101828}
        .app{display:flex;min-height:100vh}
        a{
            text-decoration: none;
        }

/* ================= SIDEBAR ================= */
.sidebar {
    width: 260px;
    background: #101828;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar-header {
    padding: 24px;
    border-bottom: 1px solid #1e2939;
}

.sidebar-header h2 {
    font-size: 18px;
}

.sidebar-header p {
    font-size: 12px;
    color: #98a2b3;
    margin-top: 4px;
}

.menu {
    padding: 16px;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    height: 48px;
    padding: 0 16px;
    margin-bottom: 8px;
    border-radius: 10px;
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s ease;
}

/* ==== ICÔNES SIDEBAR ==== */
.menu a i {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #c7d2fe;
}

.menu a.active {
    background: #155dfc;
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}

.menu a.active i {
    color: #ffffff;
}

.menu a:hover {
    background: #1e2939;
}

.logout {
    padding: 16px;
    border-top: 1px solid #1e2939;
}

.logout a {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px;
    border-radius: 10px;
    color: #ffffff;
    text-decoration: none;
}

.logout i {
    font-size: 16px;
    color: #fda4af;
}

.logout a:hover {
    background: #1e2939;
}


        /* MAIN */
        .main{flex:1;padding:32px}
        .page-header h1{font-size:28px}
        .page-header p{margin-top:6px;color:#475467}

        /* TABS */
        .tabs{margin-top:24px;display:flex;gap:12px}
        .tab{padding:10px 18px;border-radius:8px;border:1px solid #d0d5dd;background:#fff}
        .tab.active{background:#155dfc;color:#fff;border-color:#155dfc}

        /* CARD */
        .card{margin-top:24px;background:#fff;border-radius:12px;box-shadow:0 2px 6px rgba(0,0,0,.08);padding:24px}

        /* FORM */
        .form-group{margin-bottom:20px}
        label{display:block;margin-bottom:6px;font-size:14px}
        select{width:100%;padding:14px;border-radius:8px;border:1px solid #d0d5dd}

        /* INFO */
        .info{display:flex;justify-content:space-between;align-items:center;background:#f0f7ff;padding:16px;border-radius:10px;margin-bottom:20px}
        .info strong{font-size:18px}

        /* TABLE */
        table{width:100%;border-collapse:collapse}
        th{font-size:12px;color:#667085;padding:12px;text-align:left}
        td{padding:14px;border-top:1px solid #f0f2f5;font-size:14px}
        .badge{padding:4px 10px;border-radius:6px;font-size:12px}
        .green{background:#ecfdf3;color:#027a48}
        .red{background:#fef2f2;color:#b42318}
        .amount-plus{color:#16a34a}
        .amount-minus{color:#dc2626}

        /* EMPTY */
        .empty{text-align:center;padding:60px;color:#667085}
        .empty i{font-size:48px;color:#d0d5dd;margin-bottom:12px}
    </style>
</head>

<body>

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div>
            <div class="sidebar-header">
                <h2>Admin Bancaire</h2>
                <p>Espace Administrateur</p>
            </div>

            <nav class="menu">
                <a href="<?php echo WEB_ROOT; ?>/?controller=home&action=index">
                    <i class="fa-solid fa-chart-line"></i> Tableau de bord
                </a>
                <a href="<?php echo WEB_ROOT; ?>/?controller=compte&action=create">
                    <i class="fa-solid fa-user-plus"></i> Créer un compte
                </a>
                <a href="<?php echo WEB_ROOT; ?>/?controller=compte&action=index" >
                    <i class="fa-solid fa-users"></i> Afficher les comptes
                </a>
                <a href="<?php echo WEB_ROOT; ?>/?controller=transaction&action=create" class="active">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i> Transactions
                </a>
            </nav>
        </div>

        <div class="logout">
            <a href="#">
                <!-- <i class="fa-solid fa-right-from-bracket"></i> Déconnexion -->
            </a>
        </div>
    </aside>

<!-- MAIN -->
<main class="main">

<div class="page-header">
            <h1>Gestion des transactions</h1>
            <p>Ajouter des dépôts/retraits et consulter l'historique</p>
        </div>

        <div class="tabs">
            <a href="<?php echo WEB_ROOT; ?>/?controller=transaction&action=create">
                <div class="tab">
                    Ajouter une transaction
                </div>
            </a>
            <a href="<?php echo WEB_ROOT; ?>/?controller=transaction&action=index">
                <div class="tab active">
                    Lister les transactions
                </div>
            </a>
        </div>

        <?php if (empty($comptes)): ?>

            <!-- ÉTAT 1 : AUCUN COMPTE -->
            <div class="empty">
                <i class="fa-solid fa-list"></i>
                <h3>Aucun compte disponible</h3>
            </div>

        <?php else: ?>

            <div class="form-group">
                <label>Sélectionner un compte</label>
                <select onchange="location.href=this.value">
                    <option value="">-- Choisir --</option>
                    <?php foreach ($comptes as $c): ?>
                        <option value="<?= WEB_ROOT ?>/?controller=transaction&action=list<?= $c->getId() ?>"
                            <?= isset($compte) && $compte->getId()===$c->getId() ? 'selected':'' ?>>
                            <?= $c->getNumeroDeCompte() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($compte)): ?>

                <div class="info">
                    <div>
                        <small>Titulaire</small><br>
                        <strong><?= $compte->getTitulaire() ?></strong>
                    </div>
                    <div>
                        <small>Solde actuel</small><br>
                        <strong><?= number_format($compte->getSolde(),2,',',' ') ?> FCFA</strong>
                    </div>
                </div>

                <?php if (empty($transactions)): ?>

                    <!-- ÉTAT 2 : AUCUNE TRANSACTION -->
                    <div class="empty">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p>Aucune transaction enregistrée</p>
                    </div>

                <?php else: ?>

                    <!-- ÉTAT 3 : TABLE -->
                    <table>
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>TYPE</th>
                                <th>DESCRIPTION</th>
                                <th>MONTANT</th>
                                <th>FRAIS</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= $t->getDate()->format('d/m/Y H:i') ?></td>
                                <td>
                                    <span class="badge <?= $t->isDepot() ? 'green':'red' ?>">
                                        <?= $t->getType() ?>
                                    </span>
                                </td>
                                <td><?= $t->getDescription() ?></td>
                                <td class="<?= $t->isDepot() ? 'amount-plus':'amount-minus' ?>">
                                    <?= $t->isDepot() ? '+' : '-' ?>
                                    <?= number_format($t->getMontant(),2,',',' ') ?> FCFA
                                </td>
                                <td><?= number_format($t->getFrais(),2,',',' ') ?> FCFA</td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

                <?php endif; ?>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</main>

</div>
</body>
</html>