<?php

namespace nrv\core\domain\entities\Panier;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\PanierDTO;
use nrv\core\dto\UtilisateurDTO;

class Panier extends Entity
{
    protected string $id;
    protected string $id_utilisateur;
    protected bool $is_valide;

    public function __construct($id, $id_utilisateur, $is_valide)
    {
        $this->id = $id;
        $this->id_utilisateur = $id_utilisateur;
        $this->is_valide = $is_valide;
    }
    public function toDTO(): PanierDTO
    {
        return new PanierDTO($this);
    }
}