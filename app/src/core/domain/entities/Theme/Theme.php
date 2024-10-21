<?php

namespace nrv\core\domain\entities\Theme;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\ThemeDTO;
use nrv\core\dto\UtilisateurDTO;

class Theme extends Entity
{
    public string $id;
    public string $labelle;

    public function __construct($id, $labelle)
    {
        $this->id = $id;
        $this->labelle = $labelle;
    }
    public function toDTO(): ThemeDTO
    {
        return new ThemeDTO($this);

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabelle(): string
    {
        return $this->labelle;
    }

}