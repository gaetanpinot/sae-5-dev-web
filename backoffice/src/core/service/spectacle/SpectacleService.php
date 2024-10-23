<?php

namespace nrv\back\core\service\spectacle;


use DI\Container;
use nrv\back\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\back\infrastructure\Repositories\SpectacleRepository;
use Psr\Container\ContainerInterface;

class SpectacleService implements SpectacleServiceInterface
{
    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(ContainerInterface $cont) {
        $this->spectacleRepository = $cont->get(SpectacleRepositoryInterface::class);
    }   

    public function getSpectacles(): array
    {
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectacles();
        foreach ($spectacles as $spectacle) {
            $res[] = $spectacle->toDTO();
        }
        return $res;
    }

    public function getSpectaclesByDate($dateDebut, $dateFin): array{
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectaclesByDate($dateDebut, $dateFin);
        foreach ($spectacles as $spectacle) {
            $res[] = $spectacle->toDTO();
        }
        return $res;
    }

    public function addSpectacle($spec_params){
        $this->spectacleRepository->addSpectacle($spec_params);
    }

}
