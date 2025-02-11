<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use nrv\back\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\back\core\repositoryInterfaces\SoireeRepositoryInterface;
use nrv\back\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\back\core\repositoryInterfaces\ThemeRepositoryInterface;
use nrv\back\core\service\ArtisteService;
use nrv\back\core\service\ArtisteServiceInterface;
use nrv\back\core\service\Theme\ThemeServiceInterface;
use nrv\back\core\service\lieu\LieuService;
use nrv\back\core\service\lieu\LieuServiceInterface;
use nrv\back\core\service\spectacle\SpectacleService;
use nrv\back\core\service\spectacle\SpectacleServiceInterface;
use nrv\back\core\service\theme\ThemeService;
use nrv\back\infrastructure\Repositories\ArtisteRepository;
use nrv\back\infrastructure\Repositories\LieuRepository;
use nrv\back\infrastructure\Repositories\SoireeRepository;
use nrv\back\infrastructure\Repositories\SpectacleRepository;
use nrv\back\infrastructure\Repositories\ThemeRepository;
use nrv\core\repositoryInterfaces\LieuRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use nrv\back\middlewares\CorsMiddleware;




return [

    //Repository interface
    SpectacleRepositoryInterface::class => DI\autowire(SpectacleRepository::class),
    SoireeRepositoryInterface::class => DI\autowire(SoireeRepository::class),
    LieuRepositoryInterface::class=>DI\autowire(LieuRepository::class),
    ArtisteRepositoryInterface::class=>DI\autowire(ArtisteRepository::class),
    ThemeRepositoryInterface::class=> DI\autowire(ThemeRepository::class),
    //Services
    LieuServiceInterface::class=>DI\autowire(LieuService::class),
    SpectacleServiceInterface::class => DI\create(SpectacleService::class)->constructor(DI\get(ContainerInterface::class)),
    ArtisteServiceInterface::class=> DI\autowire(ArtisteService::class),
    ThemeServiceInterface::class => DI\autowire(ThemeService::class),
    //PDO
    'pdo.commun' => function(ContainerInterface $c){
        $config= parse_ini_file($c->get('db.config'));
        return new PDO($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);
    },

    //auth
    
    StreamHandler::class => DI\create(StreamHandler::class)
        ->constructor(DI\get('logs.dir'), Level::Debug)
        ->method('setFormatter', DI\get(LineFormatter::class)),

    
    LineFormatter::class => function() {
        $dateFormat = "d/m/Y H:i"; // Format de la date que tu veux
        $output = "[%datetime%] %channel%.%level_name%: %message% %context%\n"; // Format des logs
        return new LineFormatter($output, $dateFormat);
    },
    LoggerInterface::class => DI\create(Logger::class)->constructor('sae-5-Logger', [DI\get(StreamHandler::class)]),

    CorsMiddleware::class => DI\autowire(),




];
