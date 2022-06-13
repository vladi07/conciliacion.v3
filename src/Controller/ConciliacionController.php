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
        $conciliacion = $casoConciliatorioRepository -> findBy([],['id'=>'DESC']);

        return $this->render('conciliacion/index.html.twig', [
            'conciliaciones' => $conciliacion,
        ]);
    }

    #[Route ('/nuevo', name:'conciliacion_nuevo', methods:['GET','POST'])]
    public function nuevo(Usuario $usuario, Request $request, EntityManagerInterface $entityManager)
    {
        $conciliacion = new CasoConciliatorio();
        $form = $this->createForm(CasoType::class, $conciliacion);
        $form -> handleRequest($request);
        $mensaje = "";

        if ($form->isSubmitted() && $form->isValid()){
            //$conciliacion->setCentro($centro);
            $conciliacion->addUsuario($usuario);

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
}
