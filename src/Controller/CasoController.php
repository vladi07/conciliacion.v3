<?php

namespace App\Controller;

use App\Entity\CasoConciliatorio;
use App\Form\CasoType;
use App\Repository\CasoConciliatorioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/caso')]
class CasoController extends AbstractController
{
    #[Route('/', name: 'caso_index', methods:['GET'])]
    public function index(CasoConciliatorioRepository $casoConciliatorioRepository): Response
    {
        return $this->render('caso/index.html.twig', [
            'casos' => $casoConciliatorioRepository ->findBy([],['id' => 'DESC']),
        ]);
    }

    #[Route('/nuevo', name: 'caso_nuevo', methods:['GET','POST']) ]
    public function nuevo(Request $request, EntityManagerInterface $entityManager, string $docDir):Response
    {
        $caso = new CasoConciliatorio();
        $formulario = $this->createForm(CasoType::class, $caso);
        $formulario -> handleRequest($request);
        $mensaje = '';
        if ($formulario->isSubmitted() && $formulario->isValid()){
            //$this->addFlash('success','Nuevo Registro');
            //$usuario = $this->getUser();
            //$caso->addUsuario($usuario);
            if ($documento = $formulario['documento']->getData()){
                $nombreDocumento = bin2hex(random_bytes(4)).'.'.$documento->guessExtension();
                try {
                    $documento->move($docDir, $nombreDocumento);
                }catch (FileException $exception){
                    //no se pudo cargar el archivo
                }
                $caso -> setDocumento($nombreDocumento);
            }
            $entityManager->persist($caso);
            $entityManager->flush();

            return $this->redirectToRoute('caso_index');
        }else{
            $mensaje = 'Los datos son invalidos';
        }

        return  $this->renderForm('caso/nuevo.html.twig',[
           'caso' => $caso,
           'form' => $formulario,
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

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('caso_index');
        }
        return $this->renderForm('caso/editar.html.twig',[
           'caso' => $casoConciliatorio,
           'form' => $formulario,
        ]);
    }

    #[Route('/{id}', name:'caso_eliminar', methods:['POST'])]
    public function eliminar(Request $request, CasoConciliatorio $casoConciliatorio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$casoConciliatorio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($casoConciliatorio);
            $entityManager->flush();
        }
        return $this->redirectToRoute('caso_index',[],Response::HTTP_SEE_OTHER);
    }
}
