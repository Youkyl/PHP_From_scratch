<?php
namespace App\repository;

use App\core\Database;
use App\entity\Transaction;
use App\entity\TypeDeTransaction;
use App\repository\Interface\TransactionRepositoryImp;
use Exception;
use PDO;

class TransactionRepository implements TransactionRepositoryImp
{
 
    private static TransactionRepository | null $instance = null;
    
    private PDO $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function getInstance(): TransactionRepository
    {
        if (self::$instance === null) {
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }

    public function insertTransaction(Transaction $transaction) : void{

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


    public function selectTransaction(string $numeroDeCompte):array{


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
                 frais:$row['frais'],
                 date:$row['date_transaction']
            );

           // $row = $stmt->fetch();
        }

        return $transactions;
    }

    public function selectAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM transaction");
        $transactions = [];

        while ($row = $stmt->fetch()) {
            $transactions[] = new Transaction(
                montant:$row['montant'],
                type:TypeDeTransaction::fromDatabase($row['type']),
                id: $row['id'],
                frais:$row['frais']
            );
        }

        return $transactions;
    }
}