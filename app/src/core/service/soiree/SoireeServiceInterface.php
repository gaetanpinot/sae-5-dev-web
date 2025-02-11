<?php

namespace nrv\core\service\soiree;

use nrv\core\dto\SoireeDTO;

interface SoireeServiceInterface
{
    public function getSoireeDetail($soiree_id): SoireeDTO;
public function getSoireeSpectacleId(string $spectacle_id): array;
}
