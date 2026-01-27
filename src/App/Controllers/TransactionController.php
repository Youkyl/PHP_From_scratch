<?php

namespace App\controllers;

use App\core\Controller;
use App\entity\TypeDeCompte;
use App\entity\TypeDeTransaction;
use App\service\ComptesService;
use App\service\TransactionService;

class TransactionController extends Controller
{
    private ComptesService $compteService;
    private TransactionService $transacServ;

    public function __construct()
    {
     $this->compteService = ComptesService::getInstance();
     $this->transacServ = TransactionService::getInstance();
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

    //#[Route('/transaction/list.html.php/{numeroDeCompte}', methods:['GET'])]
   
    public function list($numeroDeCompte)
    {
        $comptes =  $this->compteService->searchAccByNum($numeroDeCompte);
        $transactions = $this->transacServ->searchTransacByACC($numeroDeCompte);
       // dd( $transactions);
       // dd($comptes);
        $this->renderHtml('/transaction/list.html.php', ['comptes' => $comptes, 'transactions' => $transactions]);

    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $montant = $_POST['montant'] ?? null;
            $type   = $_POST['type'] ?? null;
            $numeroDeCompte = $_POST['numeroDeCompte'] ?? null;

            //dd( $montant, $type, $numeroDeCompte);

            
            $this->transacServ->creatTransac(
                montant:$montant, 
                type:TypeDeTransaction::fromDatabase($type),
                numeroDeCompte:$numeroDeCompte);    


            
            $this->redirect('controller=transaction&action=create');
        }


    }
    

}
