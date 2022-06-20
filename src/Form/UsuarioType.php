<?php

namespace App\Form;

use App\Entity\Centro;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'label' => 'Usuario'
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Contraseña'
            ])
            ->add('roles', ChoiceType::class,[
                'label' => 'Tipo de Usuario',
                'mapped' => false,
                'placeholder' => 'Seleccione Tipo de Usuario',
                'choices' => [
                    'PLATAFORMA' => 1,
                    'CONCILIADOR' => 2,
                    'DIRECTOR CENTRO' => 3,
                    'AJAN- SCA' => 4,
                    'ADMINISTRADOR' => 5
                ],
                'required' => true,
            ])
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
            ->add('numero_documento', NumberType::class, [
                'label' => 'Número de Documento',
                'required' => true,
            ])
            ->add('expedido', ChoiceType::class,[
                'label' => 'Expedido en',
                'placeholder' => 'Seleccione un departamento',
                'choices' => [
                    'BENI' => 'Beni',
                    'CHUQUISACA' => 'Chuquisaca',
                    'COCHABAMBA' => 'Cochabamba',
                    'LA PAZ' => 'La Paz',
                    'ORURO' => 'Oruro',
                    'PANDO' => 'Pando',
                    'POTOSI' => 'Potosi',
                    'SANTA CRUZ' => 'Santa Cruz',
                    'TARIJA' => 'Tarija'
                ]
            ])
            ->add('domicilio')
            ->add('departamento', ChoiceType::class,[
                'label' => 'Departamento',
                'placeholder' => 'Seleccione un departamento',
                'choices' => [
                    'BENI' => 'Beni',
                    'CHUQUISACA' => 'Chuquisaca',
                    'COCHABAMBA' => 'Cochabamba',
                    'LA PAZ' => 'La Paz',
                    'ORURO' => 'Oruro',
                    'PANDO' => 'Pando',
                    'POTOSI' => 'Potosi',
                    'SANTA CRUZ' => 'Santa Cruz',
                    'TARIJA' => 'Tarija'
                 ]
            ])
            ->add('fecha_nacimiento', DateType::class,[
                'widget' => 'single_text'
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
            ->add('grado_academico', ChoiceType::class,[
                'label' => 'Grado Academico',
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'BACHILLER' => 'Bachiller',
                    'LICENCIATURA' => 'Licenciatura',
                    'MAESTRIA' => 'Maestria',
                    'DOCTORADO' => 'Doctorado'
                ]
            ])
            ->add('profesion')
            ->add('telefono', NumberType::class,[
                'label' => 'Telefono o Celular',
                'required' => false
            ])
            ->add('correo', EmailType::class,[
                'required' => false
            ])
            ->add('foto', FileType::class,[
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image(['maxSize' => '5120k'])
                ]
            ])
            ->add('centro', EntityType::class,[
                'label' => 'Centro de Conciliación',
                'placeholder' => 'Seleccione un Centro',
                'class' => Centro::class,
                'query_builder' => function(EntityRepository $er){
                    return $er -> createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('activo', CheckboxType::class, [
                'label' => '¿Habilitar usuario?',
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false,
            ])
            //->add('fecha_creacion')
            //->add('caso_conciliatorio')
            //->add('agenda')
            //->add('Registrar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
