<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    private $permisos = [
      1 => ['ROLE_PLATAFORMA'],
      2 => ['ROLE_CONCILIADOR'],
      3 => ['ROLE_DIRECTOR'],
      4 => ['ROLE_SCA'],
      5 => ['ROLE_ADMIN']
    ];

    #[Route('/', name: 'usuario_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        $this->addFlash('success', Usuario::REGISTRO_EXITOSO);

        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'usuario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, string $fotoDir): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rolAsignado = $form['roles'] -> getData();
            $usuario -> setRoles($this->permisos[$rolAsignado]);


            if ($foto = $form['foto']-> getData()){
                $nombreFoto = bin2hex(random_bytes(6)).'.'.$foto -> guessExtension();
                try {
                    $foto -> move($fotoDir, $nombreFoto);
                } catch (FileException $exception){
                    // No se puede subir la Foto
                }
                $usuario -> setFoto($nombreFoto);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'usuario_show', methods: ['GET'])]
    public function show(Usuario $usuario): Response
    {
        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    #[Route('/{id}/edit', name: 'usuario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'usuario_delete', methods: ['POST'])]
    public function delete(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index', [], Response::HTTP_SEE_OTHER);
    }
}
