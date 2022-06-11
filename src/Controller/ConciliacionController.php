<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use App\Entity\Usuario;
use App\Form\CasoType;
use App\Repository\CasoConciliatorioRepository;
use App\Repository\CentroRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route ('/conciliacion')]
class ConciliacionController extends AbstractController
{
    #[Route('/', name: 'conciliacion_index', methods:['GET', 'POST'])]
    public function index(UsuarioRepository $usuarioRepository, CentroRepository $centroRepository, CasoConciliatorioRepository $casoConciliatorioRepository): Response
    {
        $this -> addFlash('success', CasoConciliatorio::REGISTRO_CASO_EXITOSO );

        $conciliacion = $casoConciliatorioRepository -> findBy([],['id'=>'DESC']);

        return $this->render('conciliacion/index.html.twig', [
            'conciliaciones' => $conciliacion,
        ]);
    }

    #[Route ('/nuevo', name:'conciliacion_nuevo', methods:['GET','POST'])]
    public function nuevo(CasoConciliatorio $casoConciliatorio, Request $request, EntityManagerInterface $entityManager): Response
    {
        $conciliacion = new CasoConciliatorio();
        $formulario = $this->createForm(CasoType::class, $conciliacion);
        $formulario->handleRequest($request);
        $mensaje = "";

        if ($formulario->isSubmitted() && $formulario->isValid()){
            //$conciliacion->setCentro($centro);
            //$conciliacion->getUsuario();

            $entityManager->persist($conciliacion);
            $entityManager->flush();

            return $this->redirectToRoute('conciliacion_index');

        }else{
            $mensaje = "Los datos son invalidos";
        }

        return $this->renderForm('conciliacion/nuevo.html.twig',[
            'conciliacion' => $conciliacion,
            'form'=>$formulario,
        ]);

    }
}
