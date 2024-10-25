<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\soiree\SoireeService;
use nrv\infrastructure\Exceptions\NoDataFoundException;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidatorException;
use Respect\Validation\Validator;

class AfficheDetailSoireeAction extends AbstractAction
{

    private SoireeService $soireeService;

    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->soireeService = $cont->get(SoireeService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {

            //Affichage du détail d’une soirée : nom de la soirée, thématique, date et horaire, lieu, tarifs,
            //ainsi que la liste des spectacles : titre, artistes, description, style de musique, vidéo.
            $data = $rq->getAttribute('id');


            Validator::uuid()->assert($data);


            $soiree = $this->soireeService->getSoireeDetail($data);

            return JsonRenderer::render($rs, 200, $soiree);

        }   catch (ValidatorException $e) {
                return JsonRenderer::render($rs, 400, ['error' => $e->getMessage()]);
        }   catch (NoDataFoundException $e) {
                return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }   catch (PDOException  $e) {
                return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
            catch (\Exception $e) {
            //erreur serveur
                return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
    }
}