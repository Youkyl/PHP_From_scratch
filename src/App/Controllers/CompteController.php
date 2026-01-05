<?php

namespace App\controllers;

use App\core\Controller;
use App\entity\Comptes;
use App\service\ComptesService;
use App\service\TransactionService;

class CompteController extends Controller
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
        $transactions = $this->transacServ->searchTransac();

        $nbrTransac = [];

        foreach ($comptes as $compte) {
            $nbrTransac[$compte->getNumeroDeCompte()] = $this->transacServ->searchTransacByACC($compte->getNumeroDeCompte());
            
            //$nbrTransac += $compte->getTransactions();
        }

        $this->renderHtml('compte/index.html.php', ['comptes' => $comptes,
                                                    'nombre_transaction' => $nbrTransac]);
    }

    public function create()
    {
        $this->renderHtml('compte/create.html.php');
    }

    public function store()
    {

        var_dump($_POST);
        exit;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero = $_POST['numero'] ?? null;
            $solde  = $_POST['solde'] ?? 0;
            $type   = $_POST['type'] ?? null;
            $dureeBlocage = $_POST['dureeBlocage'] ?? null;

            $compte = new Comptes($numero, $solde, type:$type, dureeDeblocage:$dureeBlocage);
            
            $this->compteService->creatAcc($compte);    


            header('Location: index.php?action=comptes');
            exit;
        }
    }
    

}