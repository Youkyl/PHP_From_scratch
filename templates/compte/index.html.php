<?php
   // dd($comptes)
   //dd($transac)
   //dd($nbrTransac)
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo CSS_ROOT; ?>/ListerCompptes.css">

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
                <a href="<?php echo WEB_ROOT; ?>/?controller=compte&action=index" class="active">
                    <i class="fa-solid fa-users"></i> Afficher les comptes
                </a>
                <a href="<?php echo WEB_ROOT; ?>/?controller=transaction&action=create">
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
            <h1>Liste des comptes</h1>
            <p><?php echo count($comptes) ?> compte(s) enregistré(s)</p>
        </div>

        <div class="card">

            <?php if (empty($comptes)) : ?>

                <!-- EMPTY STATE -->
                <div class="empty">
                    <i class="fa-solid fa-credit-card"></i>
                    <h3>Aucun compte créé</h3>
                    <p>Créez votre premier compte pour commencer</p>
                </div>

            <?php else : ?>

                <!-- TABLE -->
                <table>
                    <thead>
                        <tr>
                            <th>TITULAIRE</th>
                            <th>NUMÉRO DE COMPTE</th>
                            <th>TYPE</th>
                            <th>STATUT</th>
                            <th>SOLDE</th>
                            <th>TRANSACTIONS</th>
                            <th>DUREE DE BLOCAGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comptes as $key => $compte): ?>
                            <tr>
                                <td>Youan HOUNKPATIN</td>
                                <td><?php echo $compte->getNumeroDeCompte() ?></td>
                                <td>
                                    <span class="badge badge-blue">
                                        <?php echo $compte->getType()->value ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-green">Actif</span>
                                </td>
                                <td><?= number_format($compte->getSolde(),2,',',' ') ?> FCFA</td>

                                <?php if (empty($nbrTransac)) : ?>
                                    <td>Aucune transaction sur ce compte</td>
                                <?php else : ?>
                                    
                                    <td><?php echo count($nbrTransac) ?></td>

                                <?php endif; ?>

                                <td><?= $compte->getDureeDeblocage() ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

            <?php endif; ?>

        </div>

    </main>

</div>
