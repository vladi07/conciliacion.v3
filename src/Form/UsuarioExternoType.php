<?php

namespace App\Form;

use App\Entity\UsuarioExterno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioExternoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombres')
            ->add('primer_apellido')
            ->add('segundo_apellido')
            ->add('tipo_documento')
            ->add('numero_documento')
            ->add('tipo_usuario')
            ->add('edad')
            ->add('domicilio')
            ->add('genero')
            ->add('grado_instruccion')
            ->add('correo')
            ->add('telefono')
            ->add('orden_judicial')
            ->add('autoridad_emision')
            ->add('fecha_emision')
            ->add('caso_conciliatorio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UsuarioExterno::class,
        ]);
    }
}
