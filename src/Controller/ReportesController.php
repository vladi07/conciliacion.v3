<?php

namespace App\Controller;

use App\Entity\Centro;
use App\Repository\CasoConciliatorioRepository;
use App\Repository\CentroRepository;
use App\Repository\UsuarioExternoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reporte')]
class ReportesController extends AbstractController
{
    #[Route('/', name: 'reporte_index', methods:['GET','POST'])]
    public function index(CentroRepository $centroRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $centros = $centroRepository->findAll([],['nombre' => 'ASC']);
        if ($request-> isMethod("POST")){
            $nombre = $request->get('nombre');
            $centros = $entityManager->getRepository('App:Centro')->findBy(array('nombre' => $nombre));
        }

        return $this->render('reportes/index.html.twig',array('Centro'=>$centros));
    }

    #[Route('/{id}/reporte', name:'reporte_centro', methods:['GET','POST'] )]
    public function reporteCentro(Centro $centro, CasoConciliatorioRepository $casoConciliatorioRepository, UsuarioExternoRepository $usuarioExternoRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $conciliaciones = $casoConciliatorioRepository -> findBy(array('centro' => $centro), array('id' => 'ASC'),10);

        $idmEsp = $casoConciliatorioRepository -> findBy(['idioma' => 'Español']);
        $idmAym = $casoConciliatorioRepository -> findBy(['idioma' => 'Aymara']);
        $idmQue = $casoConciliatorioRepository -> findBy(['idioma' => 'Quechua']);
        $idmGua = $casoConciliatorioRepository -> findBy(['idioma' => 'Guarani']);

        $nivSec = $usuarioExternoRepository -> findBy(['grado_instruccion' => 'Bachiller']);
        $nivLic = $usuarioExternoRepository -> findBy(['grado_instruccion' => 'Licenciatura']);
        $nivMas = $usuarioExternoRepository -> findBy(['grado_instruccion' => 'Maestria']);
        $nivDoc = $usuarioExternoRepository -> findBy(['grado_instruccion' => 'Doctorado']);

        $genMas = $usuarioExternoRepository -> findBy(['genero' => 'Masculino']);
        $genFem = $usuarioExternoRepository -> findBy(['genero' => 'Femenino']);

        $matCiv = $casoConciliatorioRepository -> findBy(['materia' => 'Civil']);
        $matFam = $casoConciliatorioRepository -> findBy(['materia' => 'Familiar']);
        $matComer = $casoConciliatorioRepository -> findBy(['materia' => 'Comercial']);
        $matVec = $casoConciliatorioRepository -> findBy(['materia' => 'Vecinal']);
        $matMun = $casoConciliatorioRepository -> findBy(['materia' => 'Municipal']);
        $matEsc = $casoConciliatorioRepository -> findBy(['materia' => 'Escolar']);
        $matCop = $casoConciliatorioRepository -> findBy(['materia' => 'Cooperativo']);
        $matCom = $casoConciliatorioRepository -> findBy(['materia' => 'Comunitario']);
        $matMer = $casoConciliatorioRepository -> findBy(['materia' => 'Mercantil']);
        $matDep = $casoConciliatorioRepository -> findBy(['materia' => 'Deportivo']);

        $tipPre = $casoConciliatorioRepository -> findBy(['tipo_conciliacion' => 'Presencial']);
        $tipVir = $casoConciliatorioRepository -> findBy(['tipo_conciliacion' => 'Virtual']);

        $estNew = $casoConciliatorioRepository -> findBy(['estado' => 'NUEVO']);
        $estTrat = $casoConciliatorioRepository -> findBy(['estado' => 'TRATAMIENTO']);
        $estFin = $casoConciliatorioRepository -> findBy(['estado' => 'CONCLUIDO']);

        return $this->render('reportes/reporteCentro.html.twig',[
            'centro' => $centro,
            'casosConciliados' => $conciliaciones,

            'idmEspañol' => $idmEsp,
            'idmAymara' => $idmAym,
            'idmQuechua' => $idmQue,
            'idmGuarani' => $idmGua,

            'nivSecundaria' => $nivSec,
            'nivLicenciatura' => $nivLic,
            'nivMaestria' => $nivMas,
            'nivDoctorado' => $nivDoc,

            'genMasculino' => $genMas,
            'genFemenino' => $genFem,

            'matCivil' => $matCiv,
            'matFamiliar' => $matFam,
            'matComercial' => $matComer,
            'matVecinal' => $matVec,
            'matMunicipal' => $matMun,
            'matEscolar' => $matEsc,
            'matCooperativo' => $matCop,
            'matComunitario' => $matCom,
            'matMercantil' => $matMer,
            'matDeportivo' => $matDep,

            'tipPresencial' => $tipPre,
            'tipVirtual' => $tipVir,

            'estNuevo' => $estNew,
            'estTratamiento' => $estTrat,
            'estFin' => $estFin,
        ]);
    }

}
