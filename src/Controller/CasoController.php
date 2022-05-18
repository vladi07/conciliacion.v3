<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Form\CasoType;
use App\Repository\CasoConciliatorioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/caso')]
class CasoController extends AbstractController
{
    #[Route('/', name: 'caso_index', methods:['GET','POST'])]
    public function index(CasoConciliatorioRepository $casoConciliatorioRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this -> addFlash('success', CasoConciliatorio::REGISTRO_EXITOSO);

        $caso = new CasoConciliatorio();
        $formulario = $this->createForm(CasoType::class,$caso);
        $formulario->handleRequest($request);
        $mensaje = "";
        if ($formulario->isSubmitted()&&$formulario->isValid()){
            $entityManager->persist($caso);
            $entityManager->flush();

            return $this->redirectToRoute('caso_index');
        }else{
            $mensaje = "Los datos son incorrectos";
        }

        //$casos = $casoConciliatorioRepository -> findBy([],['id'=>'ASC']);

        return $this->render('caso/index.html.twig', [
            'casos' => $casoConciliatorioRepository ->findBy([],['id' => 'DESC']),
            'formulario' => $formulario->createView(),
        ]);
    }

    #[Route('/nuevo', name: 'caso_nuevo', methods:['GET','POST']) ]
    public function nuevo(Request $request, EntityManagerInterface $entityManager){
        $caso = new CasoConciliatorio();
        $formulario = $this->createForm(CasoType::class, $caso);
        $formulario -> handleRequest($request);
        $mensaje = "";
        if ($formulario->isSubmitted()&&$formulario->isValid()){
            //$this->addFlash('success','Nuevo Registro');
            $entityManager->persist($caso);
            $entityManager->flush();

            return $this->redirectToRoute('caso_index');
        }else{
            $mensaje = "Los datos son invalidos";
        }
        //$template = $request->isXmlHttpRequest() ? 'nuevo.html.twig';
        return  $this->render('caso/index.html.twig',[
           'caso' => $caso,
           'form' => $formulario->createView(),
        ]);
    }

    #[Route('/{id}', name: 'caso_detalle', methods:['GET'])]
    public function detalle(CasoConciliatorio $casoConciliatorio): Response
    {
        return $this->render('caso/detalle.html.twig',[
            'caso' => $casoConciliatorio,
        ]);
    }

    #[Route('/{id}/edit', name:'caso_editar', methods:['GET','POST'])]
    public function editar(Request $request, CasoConciliatorio $casoConciliatorio, EntityManagerInterface $entityManager): Response
    {
        $formulario = $this->createForm(CasoType::class, $casoConciliatorio);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('caso_index');
        }
        return $this->renderForm('caso/editar.html.twig',[
           'caso' => $casoConciliatorio,
           'form' => $formulario,
        ]);
    }

    #[Route('/{id}', name:'caso_eliminar', methods:['POST'])]
    public function eliminar(): Response
    {
        return $this->redirectToRoute('caso_index',[],Response::HTTP_SEE_OTHER);
    }

    //**
    // * Lista de los casos conciliatorios
    // *
    // */
    /*
    public function index(CasoConciliatorioRepository $casoConciliatorioRepository): Response
    {
        return $this -> render('caso/index.html.twig',[
            'casos' => $casoConciliatorioRepository -> findAll(),
        ]);
    }

    //**
    // * Crear nuavo caso
    // */
    /*
    public function nuevo(Request $request, EntityManagerInterface $entityManager){
        $caso = new CasoConciliatorio();
        $form = $this -> createForm(CasoConciliatorio::class,$caso);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid() ) {
            $entityManager -> persist($caso);
            $entityManager -> flush();

            return $this -> redirect($this->generateUrl('caso_detalle', array('id' => $caso->getId())));
        }
        return $this -> render('caso/index.html.twig',[
            'caso' => $caso,
            'form' => $form->createView(),
        ]);
    }
    */
}
