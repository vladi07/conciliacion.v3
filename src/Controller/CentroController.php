<?php

namespace App\Controller;

use App\Entity\Centro;
use App\Form\CentroType;
use App\Repository\CentroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/centro')]
class CentroController extends AbstractController
{
    #[Route('/', name: 'centro_index', methods: ['GET'])]
    public function index(CentroRepository $centroRepository): Response
    {
        $this -> addFlash('success', Centro::REGISTRO_EXITOSO);

        return $this->render('centro/index.html.twig', [
            'centros' => $centroRepository -> findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'centro_nuevo', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $centro = new Centro();
        $form = $this -> createForm(CentroType::class, $centro);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()){

            $entityManager -> persist($centro);
            $entityManager -> flush();

            return $this -> redirectToRoute('centro_index');
        }

        return $this->render('centro/nuevo.html.twig', [
            'formulario' => $form -> createView(),
        ]);
    }
}
