<?php

namespace App\Form;

use App\Entity\Centro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CentroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class,[
                'label' => 'Nombre del Centro'
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Dirección'
            ])
            ->add('matricula', TextType::class,[
                'label' => 'Matricula'
            ])
            ->add('resolucion', TextType::class,[
                'label' => 'Número de Resolución del Centro'
            ])
            ->add('vigencia', DateType::class,[
                'label' => 'Vigenci de la Matricula',
                'widget' => 'single_text'
            ])
            ->add('tipo', ChoiceType::class,[
                'label' => 'Tipo de Centro',
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'PRIVADO' => 'Privado',
                    'PUBLICO' => 'Publico',
                ]
            ])
            ->add('representante', TextType::class,[
                'label' => 'Nombre del Representante Legal',
            ])
            ->add('cargo_representante', TextType::class,[
                'label' => 'Cargo del Representante Legal',
            ])
            ->add('departamento', ChoiceType::class,[
                'label' => 'Departamento',
                'placeholder' => 'Seleccione una opción',
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
            ->add('ciudad', TextType::class,[
                'label' => 'Ciudad o Localidad',
            ])
            ->add('zona', TextType::class,[
                'label' => 'Zona o Barrio',
            ])
            ->add('telefono', NumberType::class,[
                'label' => 'Teléfono o Celular de contacto',
                'required' => false,
                'help' => 'Ingrese solo números',
            ])
            ->add('fax', NumberType::class,[
                'label' => 'Fax',
                'required' => false,
                'help' => 'Ingrese solo números',
            ])
            ->add('correo', EmailType::class, [
                'label' => 'Correo Electronico',
                'help' => 'Ej. mi.correo@gmail.com',
                'required' => false
            ])
            ->add('documento', FileType::class,[
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypesMessage' => 'Por favor cargue un Documento PDF valido'
                    ])
                ]
            ])
            ->add('guardar', SubmitType::class,[
                'label' => 'Guardar'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Centro::class,
        ]);
    }
}