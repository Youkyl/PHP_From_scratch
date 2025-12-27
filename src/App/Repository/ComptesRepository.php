<?php
namespace App\Repository;

use Config\Database;
use App\entity\Comptes;
use App\entity\TypeDeCompte;
use PDO;

class ComptesRepository
{
    
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function insertCompte($compte) : void{


        $sql = "
            INSERT INTO compte (numero_compte, type, solde, duree_blocage)
            VALUES (:num, :type::type_compte, :solde, :duree)
        ";

        $stmt = $this->db->prepare($sql);   

        $stmt->execute([
            ':num' => $compte->getNumeroDeCompte(),
            ':type' => $compte->getType()->name,
            ':solde' => $compte->getSolde(),
            ':duree' => $compte->getDureeDeblocage()
        ]);

 
        
    }


    
    public function selectAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM compte");
        $comptes = [];

        while ($row = $stmt->fetch()) {
            $comptes[] = new Comptes(
                $row['numero_compte'],
                $row['solde'],
                TypeDeCompte::fromDatabase($row['type']),
                $row['duree_blocage']
            );
        }

        return $comptes;
    }


    public function selectAccByNum($numeroCompte):Comptes {
    
        $sql = "SELECT * FROM compte WHERE numero_compte = :num";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':num' => $numeroCompte]);

        $row = $stmt->fetch();

        if ($row) {
            return new Comptes(
                $row['numero_compte'],
                $row['solde'],
                TypeDeCompte::fromDatabase($row['type']),
                $row['duree_blocage']
            );
        }

        throw new \Exception("Compte non trouvé avec le numéro : " . $numeroCompte);
    }


    public function updateSoldeAcc( $numeroDeCompte, $newSolde) : void {
        $sql = "
            UPDATE compte
            SET solde = :solde
            WHERE numero_compte = :num
        ";

        $stmt = $this->db->prepare($sql);   

        $stmt->execute([
            ':solde' => $newSolde,
            ':num' => $numeroDeCompte
        ]);

        throw new \Exception("Erreur lors de la mise à jour du solde pour le compte : " . $numeroDeCompte);
    }





}

