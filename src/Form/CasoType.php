<?php

namespace App\Form;

use App\Entity\CasoConciliatorio;
use App\Entity\Centro;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CasoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('fecha')
            ->add('materia', ChoiceType::class,[
                'label' => 'Materia',
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'CIVIL' => 'Civil',
                    'COMERCIAL' => 'Comercial',
                    'FAMILIAR' => 'Familiar',
                    'VECINAL' => 'Vecinal',
                    'MUNICIPAL' => 'Municipal',
                    'ESCOLAR' => 'Escolar',
                    'COOPERATIVO' => 'Cooperativo',
                    'COMUNITARIO' => 'Comunitario',
                    'MERCANTIL' => 'Mercantil',
                    'DEPORTIVO' => 'Deportivo',
                ]
            ])
            ->add('tipo_conciliacion', ChoiceType::class,[
                'label' => 'Tipo de Conciliación',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'PRESENCIAL' => 'Presencial',
                    'VIRTUAL' => 'Virtual',
                ]
            ])
            ->add('descripcion', TextareaType::class,[
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('idioma', ChoiceType::class,[
                'label' => 'Idioma',
                'placeholder' => 'Seleccione una opción',
                'choices' => [
                    'ESPAÑOL' => 'Español',
                    'AYMARA' => 'Aymara',
                    'QUECHUA' => 'Quechua',
                    'GUARANI' => 'Guarani',
                ]
            ])
            ->add('fecha_rechazo', DateType::class,[
                'label' => 'Fecha de Rechazo del Caso',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('motivo_rechazo', TextareaType::class,[
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            //->add('estado', null)
            //->add('etapa', null)
            //->add('invitacion')
            ->add('fecha_audiencia', DateType::class, [
                'label' => 'Fecha de Audiencia',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('hora_audiencia', TimeType::class,[
                'label' => 'Hora de Audiencia',
                'input' => 'datetime',
                'widget' => 'choice',
                'required' => false,
            ])
            ->add('detalle_asistencia', ChoiceType::class,[
                'label' => 'Solicitante(s)',
                'required' => false,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'ASISTIERON' => 'Asistio',
                    'NO ASISTIERON' => 'No Asistio'
                ]
            ])
            ->add('fecha_asistencia', DateType::class, [
                'label' => 'Fecha Asistencia de Audiencia',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('documento', FileType::class,[
                'label' => 'Cargar archivo en PDF',
                'required' => false, //Que no sea obligatorio
                'mapped' => false, //CAmpo no definido en la entidad
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => 'application/pdf',
                        'mimeTypesMessage' => 'Cargar archivo valido',
                    ])
                ],
            ])
            ->add('centro', EntityType::class,[
                'label' => 'Centro Conciliatorio',
                'placeholder' => 'Centro de Conciliación',
                'class' => Centro::class,
                'query_builder' => function(EntityRepository $er){
                    return $er -> createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');

                },
                'choice_label' => function ($centro){
                    return $centro->getNombre();
                },
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('usuario', EntityType::class,[
                'label' => 'Conciliador a asignar',
                'placeholder' => 'Selecciones un Conciliador',
                'class' => Usuario::class,
                'query_builder' => function(EntityRepository $er){
                    return $er -> createQueryBuilder('u')
                        ->orderBy('u.nombres','ASC');
                },
                'choice_label' => function ($usuario){
                    return $usuario->getNombres();
                },
                'multiple' => false,
                'expanded' => false,
                'required' => false,
            ])
            ->add('detalleActa', TextareaType::class,[
                'attr' => ['class' => 'tinymce'],
                'label' => 'Detalle del Acta',
                'required' => false,
            ])
            //->add('usuario_externo')
            //->add('sala')
            //->add('agenda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CasoConciliatorio::class,
        ]);
    }
}
