<?php

namespace App\controllers;

use App\core\Controller;
use App\service\ComptesService;
use App\service\TransactionService;

class TransactionController extends Controller
{
    private ComptesService $compteService;
    private TransactionService $transacServ;

    public function __construct()
    {
     $this->compteService = new ComptesService();
     $this->transacServ = new TransactionService();
    }

    public function index()
    {
        $comptes =  $this->compteService->searchAcc();
        $this->renderHtml('/transaction/index.html.php', ['comptes' => $comptes]);
    }

    public function create()
    {
        $comptes =  $this->compteService->searchAcc();
        $this->renderHtml('/transaction/creat.html.php', ['comptes' => $comptes]);
    }

    public function list()
    {
        
        $comptes =  $this->compteService->searchAcc();
        //$transactions = $this->transacServ->searchTransacByACC($numeroDeCompte);
        $this->renderHtml('/transaction/index.html.php', ['comptes' => $comptes]);

    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $montant = $_POST['montant'] ?? null;
            $type   = $_POST['type'] ?? null;
            $numeroDeCompte = $_POST['numeroDeCompte'] ?? null;

            
            $this->transacServ->creatTransac(montant:$montant, type:$type, numeroDeCompte:$numeroDeCompte);    


            header('Location: ' . WEB_ROOT . '/?controller=transaction&action=index');
            exit;
        }


    }

}
