<?php

namespace App\Controllers;

use App\Entity\Comptes;

class CompteController
{
    public function index()
    {
        $comptes = [];
        require_once __DIR__ . '/../../Public/Pages/ListerCompptes.html';
    }

    public function create()
    {
        require_once __DIR__ . '/../../Public/Pages/CreateAcc.html';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = $_POST['numero'] ?? null;
            $solde  = $_POST['solde'] ?? 0;
            $type   = $_POST['type'] ?? null;

            $compte = new Comptes($numero, $solde, $type);

            header('Location: index.php?action=comptes');
            exit;
        }
    }
    

}
