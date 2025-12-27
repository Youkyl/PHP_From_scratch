<?php

namespace App\Controllers;

use App\Entity\Transaction;

class TransactionController
{
    public function index()
    {
        $transactions = [];
        require_once __DIR__ . '/../../Public/Pages/ListTransac.html';
    }

    public function create()
    {
        require_once __DIR__ . '/../../Public/Pages/AddTransac.html';
    }

}
