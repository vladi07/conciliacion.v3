<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use App\Form\CasoType;
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
    #[Route('/', name: 'centro_index', methods: ['GET','POST'])]
    public function index(CentroRepository $centroRepository, Request $request,EntityManagerInterface $entityManager): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $centroRepository->getPaginadorCentro($offset);

        return $this->render('centro/index.html.twig', [
            //'centros' => $centroRepository -> findBy([],['nombre'=>'ASC']),
            'centros' => $paginator,
            'previous' => $offset - CentroRepository::PAGINADOR_POR_PAGINA,
            'next' => min(count($paginator), $offset + CentroRepository::PAGINADOR_POR_PAGINA),
            'desde' => $offset + 1
        ]);
    }

    #[Route('/nuevo', name: 'centro_nuevo', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $obtenerUsuario = $this -> getUser();
        $centro = new Centro();
        $form = $this -> createForm(CentroType::class, $centro);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()){
            $centro -> setUsuarioCreador($obtenerUsuario);

            $entityManager -> persist($centro);
            $entityManager -> flush();

            $this->addFlash('success', Centro::REGISTRO_EXITOSO);

            return $this -> redirectToRoute('centro_index');
        }

        return $this->renderForm('centro/nuevo.html.twig', [
            'centro' => $centro,
            'formulario' => $form,
        ]);
    }

    #[Route('/{id}', name:'centro_detalle', methods:['GET','POST'])]
    public function show(Centro $centro, Request $request): Response
    {
        return $this -> render('centro/detalle.html.twig',[
            'centro' => $centro,
        ]);
    }

    #[Route('/{id}/edit', name: 'centro_editar', methods: ['GET','POST'])]
    public function edit(Request $request, Centro $centro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentroType::class, $centro);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();

            $this->addFlash('alert', Centro::MODIFICACION_EXITOSA);
            return $this->redirectToRoute('centro_index');
        }

        return $this->renderForm('centro/editar.html.twig',[
            'centro' => $centro,
            'formulario' => $form,
        ]);
    }

    #[Route('/{id}', name: 'centro_eliminar', methods:['POST'])]
    public function delete(Request $request, Centro $centro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centro_index', [],Response::HTTP_SEE_OTHER);
    }
}
