<?php

namespace nrv\core\domain\entities\Billet;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\BilletDTO;
use nrv\core\dto\UtilisateurDTO;

class Billet extends Entity
{
    public string $id;
    public string $id_user;
    public string $id_spectacle;
    public float $tarif;

    public function __construct($id, $id_user, $id_spectacle, $tarif)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_spectacle = $id_spectacle;
        $this->tarif = $tarif;
    }

    public function toDTO(): BilletDTO
    {
        return new BilletDTO($this);
    }

}