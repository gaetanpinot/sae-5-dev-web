<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use DI\Container;
use nrv\core\domain\entities\Soiree\Soiree;
use PDO;

class SoireeRepository implements SoireeRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getSoirees(): array{
        return $this->pdo->query('SELECT * FROM soiree')->fetchAll();
    }

    public function getSoireeById(string $id): Soiree{
        $result = $this->pdo->query('SELECT * FROM soiree WHERE id = ' . $id)->fetch();
        return new Soiree($result['id'], $result['nom'], $result['id_theme'], $result['date'], $result['heure_debut'], $result['duree'], $result['id_lieu'], $result['nb_places'], $result['nb_places_restantes'], $result['tarif_normal'], $result['tarif_reduit']);
    }

    public function save(Soiree $soiree): void{
        $request = $this->pdo->prepare('INSERT INTO soiree (id, nom, id_theme, date, heure_debut, duree, id_lieu, nb_places, nb_places_restantes, tarif_normal, tarif_reduit) VALUES (:id, :nom, :id_theme, :date, :heure_debut, :duree, :id_lieu, :nb_places, :nb_places_restantes, :tarif_normal, :tarif_reduit) ON CONFLICT (id) DO UPDATE SET nom = :nom, id_theme = :id_theme, date = :date, heure_debut = :heure_debut, duree = :duree, id_lieu = :id_lieu, nb_places = :nb_places, nb_places_restantes = :nb_places_restantes, tarif_normal = :tarif_normal, tarif_reduit = :tarif_reduit');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heure_debut' => $soiree->heure_debut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nb_places' => $soiree->nb_places,
            'nb_places_restantes' => $soiree->nb_places_restantes,
            'tarif_normal' => $soiree->tarif_normal,
            'tarif_reduit' => $soiree->tarif_reduit
        ]);
    }

    public function updateSoiree(Soiree $soiree): void{
        $request = $this->pdo->prepare('UPDATE soiree SET nom = :nom, id_theme = :id_theme, date = :date, heure_debut = :heure_debut, duree = :duree, id_lieu = :id_lieu, nb_places = :nb_places, nb_places_restantes = :nb_places_restantes, tarif_normal = :tarif_normal, tarif_reduit = :tarif_reduit WHERE id = :id');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heure_debut' => $soiree->heure_debut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nb_places' => $soiree->nb_places,
            'nb_places_restantes' => $soiree->nb_places_restantes,
            'tarif_normal' => $soiree->tarif_normal,
            'tarif_reduit' => $soiree->tarif_reduit
        ]);
    }

    public function deleteSoiree(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM soiree WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}