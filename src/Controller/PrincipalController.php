<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use App\Repository\CasoConciliatorioRepository;
use App\Repository\CentroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    #[Route('/', name: 'principal')]
    public function index(CentroRepository $centroRepository, CasoConciliatorioRepository $casoConciliatorioRepository): Response
    {
        //$centro = $centroRepository->findAll();

        //return $this->render('principal/index.html.twig', [
        //    'misCentros' => $centro,
        //]);

        $centros = $centroRepository -> findAll();

        $centroCasos = [];
        $centroCantidad = [];


        foreach ( $centros as $centro ){
            $centroCasos[] = $centro->getNombre();
            $centroCantidad[] = count($centro -> getCasoConciliatorio());
        }

        return $this->render('principal/index.html.twig', [
            'centroCasos' => json_encode($centroCasos),
            'centroCantidades' => json_encode($centroCantidad),
        ]);

    }

    #[Route('/mi_centro/{id}', name: 'mis_centros')]
    public function show(Request $request, CasoConciliatorioRepository $casoConciliatorioRepository, Centro $centro)
    {
        $offset = max(0,$request->query->getInt('offset',0));

        $paginator = $casoConciliatorioRepository->getCasoPaginator($centro, $offset);

        //$conciliaciones = $centro->getCasoConciliatorio();
        //$conciliaciones = $casoConciliatorioRepository->findBy(
        //    ['centro' => $centro]
        //);

        return $this->render('principal/show.html.twig',[
            'misCentros' => $centro,
            'misConciliaciones' => $paginator,
            'anterior' => $offset - CasoConciliatorioRepository::PAGINATOR_PER_PAGE,
            'siguiente' => min(count($paginator), $offset + CasoConciliatorioRepository::PAGINATOR_PER_PAGE),

        ]);
    }


}
