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
        // Obtenemos al usuario LOGUEADO
        $usuarioLog = $this->getUser();

        if ($usuarioLog){
            $centros = $centroRepository -> findAll();

            $centroCasos = [];
            $centroCantidad = [];

            foreach ( $centros as $centro ){
                $centroCasos[] = $centro->getNombre();
                $centroCantidad[] = count($centro -> getCasoConciliatorio());
            }

            $casosConciliatorios = $casoConciliatorioRepository ->findAll();

            $casosMateria = [];
            $casosCantidad = [];

            foreach ($casosConciliatorios as $conciliacion) {
                $casosMateria[] = $conciliacion->getMateria();
                $casosCantidad[] = ($conciliacion -> getUsuario());
            }

            return $this->render('principal/index.html.twig', [
                'centroCasos' => json_encode($centroCasos),
                'centroCantidades' => json_encode($centroCantidad),

                'casosMateria' => json_encode($casosMateria),
                'casosCantidad' => json_encode($casosCantidad),
            ]);

        } else {
            return $this-> redirectToRoute('app_login');
        }
    }
}