<?php
   // dd($comptes)
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des transactions | Admin Bancaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f9fafb;
            color: #101828;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

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


        /* ================= MAIN ================= */
        .main {
            flex: 1;
            padding: 32px;
        }

        .page-header h1 {
            font-size: 28px;
        }

        .page-header p {
            color: #475467;
            margin-top: 6px;
        }

        /* ================= TABS ================= */
        .tabs {
            margin-top: 24px;
            display: flex;
            gap: 12px;
        }

        .tab {
            padding: 10px 18px;
            border-radius: 8px;
            border: 1px solid #d0d5dd;
            background: #fff;
            cursor: pointer;
            font-size: 14px;
        }

        .tab.active {
            background: #155dfc;
            color: #fff;
            border-color: #155dfc;
        }

        /* ================= CARD ================= */
        .card {
            margin-top: 24px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            padding: 24px;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .card-title .icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff3e0;
            color: #f97316;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ================= FORM ================= */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #d0d5dd;
        }

        /* ================= TYPE BUTTONS ================= */
        .type-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .type-btn {
            padding: 14px;
            border-radius: 10px;
            border: 2px solid #d0d5dd;
            background: #fff;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .type-btn.deposit.active {
            border-color: #22c55e;
            background: #ecfdf3;
            color: #15803d;
        }

        .type-btn.withdraw.active {
            border-color: #ef4444;
            background: #fef2f2;
            color: #b91c1c;
        }

        /* ================= BUTTON ================= */
        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #fff;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-green {
            background: #16a34a;
        }

        .btn-red {
            background: #dc2626;
        }

        /* ================= EMPTY ================= */
        .empty {
            text-align: center;
            padding: 60px;
            color: #667085;
        }

        .empty i {
            font-size: 48px;
            color: #d0d5dd;
            margin-bottom: 16px;
        }
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
                <div class="tab active">
                    Ajouter une transaction
                </div>
            </a>
            <a href="<?php echo WEB_ROOT; ?>/?controller=transaction&action=index">
                <div class="tab">
                    Lister les transactions
                </div>
            </a>
        </div>

        <div class="card">

            <?php if (empty($comptes)): ?>

                <!-- EMPTY STATE -->
                <div class="empty">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <h3>Aucun compte disponible</h3>
                    <p>Créez d'abord un compte.</p>
                </div>

            <?php else: ?>

                <div class="card-title">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-down-up-across-line"></i>
                    </div>
                    <h3>Nouvelle transaction</h3>
                </div>

                <form method="POST" action="<?php echo WEB_ROOT ?>/?controller=transaction&action=store">

                    <div class="form-group">
                        <label>Sélectionner un compte</label>
                        <select name="numeroDeCompte" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach ($comptes as $compte): ?>
                                <option value="<?= $compte->getNumeroDeCompte() ?>" name="numeroDeCompte">
                                    <?= $compte->getNumeroDeCompte() ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Type de transaction</label>
                        <div class="type-buttons">
                            <button type="button" class="type-btn deposit active" id="btnDepot" name ="type">
                                <i class="fa-solid fa-arrow-down"></i> DEPOT
                            </button>
                            <button type="button" class="type-btn withdraw" id="btnRetrait" name ="type">
                                <i class="fa-solid fa-arrow-up"></i> RETRAIT
                            </button>
                        </div>
                        <input type="hidden" name="type" id="typeTransaction" value="DEPOT">
                    </div>

                    <div class="form-group">
                        <label>Montant (FCFA)</label>
                        <input type="number" min="1" name="montant" placeholder="0.00" required>
                    </div>

                    <div class="form-group">
                        <label>Description (optionnel)</label>
                        <input type="text" name="description" placeholder="Ex : Achat supermarché">
                    </div>

                    <button class="btn-submit btn-green" id="btnSubmit">
                        <i class="fa-solid fa-check"></i> Valider la transaction
                    </button>

                </form>

            <?php endif; ?>

        </div>

    </main>

</div>

<script>
    const btnDepot = document.getElementById("btnDepot");
    const btnRetrait = document.getElementById("btnRetrait");
    const typeInput = document.getElementById("typeTransaction");
    const submitBtn = document.getElementById("btnSubmit");

    btnDepot.onclick = () => {
        btnDepot.classList.add("active");
        btnRetrait.classList.remove("active");
        typeInput.value = "DEPOT";
        submitBtn.className = "btn-submit btn-green";
    };

    btnRetrait.onclick = () => {
        btnRetrait.classList.add("active");
        btnDepot.classList.remove("active");
        typeInput.value = "RETRAIT";
        submitBtn.className = "btn-submit btn-red";
    };
</script>

</body>
</html>