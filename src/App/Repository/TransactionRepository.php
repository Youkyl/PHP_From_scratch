<?php
namespace App\Repository;

use Config\Database;
use App\entity\Transaction;
use App\entity\TypeDeTransaction;
use Exception;
use PDO;

class TransactionRepository{
 
    
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function insertTransaction($transaction) : void{

          try 
          {
            $this->db->beginTransaction();
          

        $sql = "
            INSERT INTO transaction (numero_compte, type, montant, frais)
            VALUES (:num, :type::type_transaction, :montant, :frais)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':num' => $transaction->getCompte()->getNumeroDeCompte(),
            ':type' => $transaction->getType()->name,
            ':montant' => $transaction->getMontant(),
            ':frais' => $transaction->getFrais()
        ]);

        $sql = "
            UPDATE compte
            SET solde = :solde
            WHERE numero_compte = :num
        ";

        $stmt = $this->db->prepare($sql);   

        $stmt->execute([
            ':solde' => $transaction->getCompte()->getSolde(),
            ':num' => $transaction->getCompte()->getNumeroDeCompte()
        ]);
        $this->db->commit();

        echo "Transaction insérée avec succès.";

    }   catch (Exception $e) {
  // Oups, problème ? On annule tout (rollback)
  $this->db->rollBack();
  echo "Erreur : " . $e->getMessage();
    }
}


    public function selectTransaction($numeroDeCompte):array{


        $sql = "
            SELECT * FROM transaction
            WHERE numero_compte = :num
            ORDER BY date_transaction DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':num' => $numeroDeCompte]);

        $transactions = [];

        while ($row = $stmt->fetch()) {
            $transactions[] = new Transaction(
                 montant:$row['montant'],
                 type:TypeDeTransaction::fromDatabase($row['type']),
                 id: $row['id'],
                 frais:$row['frais']
            );

            $row = $stmt->fetch();
        }

        return $transactions;
    }
}