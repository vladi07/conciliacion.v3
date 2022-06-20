<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use App\Entity\Usuario;
use App\Entity\UsuarioExterno;
use App\Form\CasoType;
use App\Form\UsuarioExternoType;
use App\Repository\CasoConciliatorioRepository;
use App\Repository\CentroRepository;
use App\Repository\UsuarioExternoRepository;
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
    #[Route('/', name: 'conciliacion_index', methods:['GET','POST'])]
    public function index(UsuarioRepository $usuarioRepository, CentroRepository $centroRepository, CasoConciliatorioRepository $casoConciliatorioRepository): Response
    {
        $conciliacion = $casoConciliatorioRepository -> findBy([],['id'=>'DESC']);

        return $this->render('conciliacion/index.html.twig', [
            'conciliaciones' => $conciliacion,
        ]);
    }

    #[Route ('/nuevo', name:'conciliacion_nuevo', methods:['GET','POST'])]
    public function nuevo(Request $request, EntityManagerInterface $entityManager)
    {
        $conciliacion = new CasoConciliatorio();
        $form = $this->createForm(CasoType::class, $conciliacion);
        $form -> handleRequest($request);
        $mensaje = "";

        if ($form->isSubmitted() && $form->isValid()){
            //$usuario = $this->getUser();
            //$conciliacion ->setUsuario($usuario);

            //$centro = $this->redirectToRoute()
            //$conciliacion -> setCentro($centro);

            $conciliacion -> setEstado('NUEVO');
            $conciliacion -> setEtapa('VALORACION');

            $entityManager->persist($conciliacion);
            $entityManager->flush();

            $this->addFlash('success', CasoConciliatorio::REGISTRO_CASO_EXITOSO);

            return $this->redirectToRoute('conciliacion_index');

        }else{
            $mensaje = "Los datos son invalidos";
        }

        return $this->renderForm('conciliacion/nuevo.html.twig',[
            'conciliacion' => $conciliacion,
            'formulario'=>$form,
        ]);
    }

    #[Route('/{id}/detalle', name:'conciliacion_detalle', methods:['GET','POST'])]
    public function show(CasoConciliatorio $casoConciliatorio, UsuarioExternoRepository  $usuarioExternoRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        //$externo = new UsuarioExterno();
        //$form = $this->createForm(UsuarioExternoType::class, $externo);
        //$form -> handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()){
        //    $externo -> setCasoConciliatorio($casoConciliatorio);

        //    $entityManager->persist($externo);
        //    $entityManager->flush();
            //$this->addFlash();
        //    return $this->redirectToRoute('conciliacion_detalle', ['id'=>$casoConciliatorio->getId()]);
        //}
        //$userExterno = $usuarioExternoRepository->getMisExternos($casoConciliatorio);

        $usuariosExternos = $usuarioExternoRepository -> findBy([],['id'=>'DESC']);

        return $this->render('conciliacion/detalle.html.twig', [
            'conciliacion' => $casoConciliatorio,

            //'userExterno' => $form -> createView(),
            'externos' => $usuariosExternos,
        ]);
    }

    #[Route('/{id}/editar', name: 'conciliacion_editar', methods:['GET','POST'])]
    public function edit(CasoConciliatorio $casoConciliatorio, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this -> createForm(CasoType::class, $casoConciliatorio);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();

            $this->addFlash('alert', CasoConciliatorio::MODIFICACION_CASO_EXITOSO);
            return $this->redirectToRoute('conciliacion_index');
        }

        return $this->renderForm('conciliacion/editar.html.twig',[
           'conciliacion' => $casoConciliatorio,
           'formulario' => $form,
        ]);
    }
}
