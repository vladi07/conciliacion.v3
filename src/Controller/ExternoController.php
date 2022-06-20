<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Entity\UsuarioExterno;
use App\Form\UsuarioExternoType;
use App\Repository\UsuarioExternoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExternoController extends AbstractController
{
    #[Route('/externo', name: 'externo_index')]
    public function index(): Response
    {

        return $this->render('externo/index.html.twig', [
            'controller_name' => 'ExternoController',
        ]);
    }

    #[Route('/{id}/externo', name:'externo_nuevo', methods:['GET', 'POST'])]
    public function nuevo(Request $request, EntityManagerInterface $entityManager, CasoConciliatorio $casoConciliatorio){
        $externo = new UsuarioExterno();
        $form = $this->createForm(UsuarioExternoType::class, $externo);
        $form-> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $externo -> setCasoConciliatorio($casoConciliatorio);

            $entityManager->persist($externo);
            $entityManager->flush();

            return $this->redirectToRoute('conciliacion_detalle', ['id'=>$casoConciliatorio->getId()]);
        }

        //$userExterno = $usuarioExternoRepository->getMisExternos($casoConciliatorio);

        return $this->render('externo/nuevo.html.twig', [
            'usuarioExterno' => $externo,
            'formulario' => $form -> createView(),
        ]);
    }

}
