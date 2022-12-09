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
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route ('/conciliacion')]
class ConciliacionController extends AbstractController
{
    #[Route('/', name: 'conciliacion_index', methods:['GET','POST'])]
    public function index(CasoConciliatorioRepository $casoConciliatorioRepository, EntityManagerInterface $entityManager): Response
    {
        $obtenerUsuario = $this -> getUser();

        if ($obtenerUsuario){

            //Obtener mis casos conciliatorios
            $misCasos = $entityManager ->getRepository(CasoConciliatorio::class)->findBy(['usuario'=>$obtenerUsuario]);
            //obtener todos los casos
            $conciliacion = $casoConciliatorioRepository -> findBy([],['id'=>'DESC']);

            return $this->render('conciliacion/index.html.twig',[
                //mostramos mis casos
                'misConciliaciones' => $misCasos,
                //mostarmos todos los casos
                'conciliaciones' => $conciliacion,

            ]);

        }else{
            return $this -> redirectToRoute('app_login');
        }
    }

    #[Route ('/nuevo', name:'conciliacion_nuevo', methods:['GET','POST'])]
    public function nuevo(Request $request, EntityManagerInterface $entityManager)
    {
        $conciliacion = new CasoConciliatorio();
        $form = $this->createForm(CasoType::class, $conciliacion);
        $form -> handleRequest($request);
        $mensaje = "";

        if ($form->isSubmitted() && $form->isValid()){
            //$centro = $this->redirectToRoute()
            //$conciliacion -> setCentro($centro);

//            $obtenerCentro = $this->getUser{$centro};
//            $conciliacion -> setCentro($obtenerCentro);

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
    public function show(CasoConciliatorio $casoConciliatorio, UsuarioExternoRepository  $usuarioExternoRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        //$userExternos = $usuarioExternoRepository -> findBy([],['id'=>'DESC']);
        $usuariosExternos = $usuarioExternoRepository -> findBy(array('casoConciliatorio'=>$casoConciliatorio), array('nombres'=>'ASC'),10);

        return $this->render('conciliacion/detalle.html.twig', [
            'conciliacion' => $casoConciliatorio,
            'externosCaso' => $usuariosExternos,
            //'usuariosExternos' => $userExternos
        ]);
    }

    #[Route('{id}/seguimiento', name:'conciliacion_seguimiento', methods:['GET','POST'])]
    public function seguimiento(CasoConciliatorio $casoConciliatorio, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this -> createForm(CasoType::class,$casoConciliatorio);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ( $casoConciliatorio->getEstado() == 'NUEVO'){
                $casoConciliatorio -> setEstado('TRATAMIENTO');
                $casoConciliatorio -> setEtapa('INVITACION');
                $entityManager -> flush();

                return $this->redirectToRoute('conciliacion_index');
            }else{
                if ($casoConciliatorio ->getEstado() == 'TRATAMIENTO'){
                    $casoConciliatorio -> setEstado('CONCLUIDO');
                    $casoConciliatorio -> setEtapa('CERRADO');
                    $entityManager -> flush();

                    return $this->redirectToRoute('conciliacion_index');
                 }
            }
            return $this->redirectToRoute('conciliacion_index');
        }
        return $this->renderForm('conciliacion/editar.html.twig',[
            'conciliacion' => $casoConciliatorio,
            'formulario' => $form,
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

    #[Route('/{id}/printpdf', name: 'conciliacion_pdf_invitacion', methods:['GET','POST'])]
    public function printInvitacion(CasoConciliatorio $casoConciliatorio, Request $request, EntityManagerInterface $entityManager): Response
    {
        $datoCaso = $casoConciliatorio;

        ob_start();

        $html = $this->renderView('conciliacion/invitacion.html.twig', [
            'datosCaso' => $datoCaso
        ]);

        $html2pdf = new Html2Pdf('p','LETTER', 'fr', true, 'UTF-8', array('10','10','10','10'));
        $html2pdf -> pdf -> SetDisplayMode('real');
        $html2pdf -> setDefaultFont('Arial');
        $html2pdf -> writeHTML($html);

        $cadena = 'invitacion.pdf';
        $originales = 'ÁÄÁ';
        $modificadas = 'aaa';

        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtoupper($cadena);

        ob_end_clean();

        return new Response($html2pdf->Output(utf8_decode($cadena), 'D'), 200,[
            'Content-Type' => 'aplication/pdf;charset=UTF-8'
        ]);
    }

    #[Route('/{id}/printpdfacta', name: 'conciliacion_pdf_acta', methods:['GET','POST'])]
    public function printActa(CasoConciliatorio $casoConciliatorio, Request $request, EntityManagerInterface $entityManager): Response
    {
        $datoCaso = $casoConciliatorio;

        ob_start();

        $html = $this->renderView('conciliacion/acta.html.twig', [
            'datosCaso' => $datoCaso
        ]);

        $html2pdf = new Html2Pdf('p','LETTER', 'fr', true, 'UTF-8', array('10','10','10','10'));
        $html2pdf -> pdf -> SetDisplayMode('real');
        $html2pdf -> setDefaultFont('Arial');
        $html2pdf -> writeHTML($html);

        $cadena = 'acta_conciliacion.pdf';
        $originales = 'ÁÄÁ';
        $modificadas = 'aaa';

        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtoupper($cadena);

        ob_end_clean();

        return new Response($html2pdf->Output(utf8_decode($cadena), 'D'), 200,[
            'Content-Type' => 'aplication/pdf;charset=UTF-8'
        ]);
    }
}
