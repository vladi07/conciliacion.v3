<?php

namespace App\Form;

use App\Entity\UsuarioExterno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioExternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombres', TextType::class,[
                'label' => 'Nombre(s)'
            ])
            ->add('primer_apellido', TextType::class,[
                'label' => 'Primer Apellido'
            ])
            ->add('segundo_apellido', TextType::class,[
                'label' => 'Segundo Apellido',
                'required' => false
            ])
            ->add('tipo_documento', ChoiceType::class,[
                'label' => 'Tipo de Documento',
                'placeholder' => 'Seleccione un tipo de documento',
                'choices' => [
                    'CÉDULA DE IDENTIDAD' => 'Cedula de Identidad',
                    'LIBRETA DE SERVICIO MILITAR' => 'Libreta de Servicio Militar',
                    'NÚMERO DE PASPORTE' => 'Número de Pasaporte'
                ]
            ])
            ->add('numero_documento', NumberType::class,[
                'label' => 'Número del Docuemnto',
                'required' => true
            ] )
            ->add('tipo_usuario', ChoiceType::class,[
                'label' => 'Tipo de Usuario',
                'placeholder' => 'Seleccione un tipo de usuario',
                'choices' => [
                    'SOLICITANTE' => 'Solicitante',
                    'INVITADO' => 'Invitado'
                ]
            ])
            ->add('edad', NumberType::class,[
                'label' => 'Edad',
                'required' => true
            ])
            ->add('domicilio', TextType::class,[
                'label' => 'Dirección del Usuario'
            ])
            ->add('genero', ChoiceType::class,[
                'label' => 'Género',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'FEMENINO' => 'Femenino',
                    'MASCULINO' => 'Masculino'
                ]
            ])
            ->add('grado_instruccion', ChoiceType::class,[
                'label' => 'Grado de Instruccion Academica',
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'BACHILLER' => 'Bachiller',
                    'LICENCIATURA' => 'Licenciatura',
                    'MAESTRIA' => 'Maestria',
                    'DOCTORADO' => 'Doctorado'
                ]
            ])
            ->add('correo', EmailType::class,[
                'required' => false
            ])
            ->add('telefono', NumberType::class,[
                'label' => 'Telefono o Celular',
                'required' => false
            ])
            ->add('orden_judicial', TextType::class,[
                'label' => 'Número de la Orden Judicial',
                'required' => false
            ])
            ->add('autoridad_emision', TextType::class,[
                'label' => 'Nombre de la Autoridad que Emitio la Orden',
                'required' => false
            ])
            ->add('fecha_emision', DateType::class,[
                'label' => 'Fecha de Emision del Documento',
                'widget' => 'single_text',
                'required' => false,
            ])
            //->add('caso_conciliatorio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UsuarioExterno::class,
        ]);
    }
}
