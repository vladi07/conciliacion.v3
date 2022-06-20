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
            //->add('fecha_rechazo', null)
            //->add('motivo_rechazo', TextareaType::class,[
            //    'attr' => ['class' => 'tinymce'],
            //])
            //->add('estado', null)
            //->add('etapa', null)
            //->add('invitacion')
            //->add('fecha_audiencia', DateType::class, [
            //    'label' => 'Fecha de Audiencia',
            //    'widget' => 'single_text',
            //    'required' => false,
            //])
            //->add('hora_audiencia', TimeType::class,[
            //    'input' => 'datetime',
            //    'widget' => 'choice',
            //    'required' => false,
            //])
            //->add('detalle_asistencia', ChoiceType::class,[
            //    'label' => 'Solicitante(s):',
            //    'multiple' => false,
            //    'required' => true,
            //    'expanded' => true,
            //    'choices' => [
            //        'ASISTIO' => 'Asistio',
            //        'NO ASISTIO' => 'No Asistio'
            //    ]
            //])
            //->add('fecha_asistencia', DateType::class, [
            //    'required' => false,
            //])
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
                'placeholder' => 'Un centro',
                'class' => Centro::class,
                'choice_label' => 'nombre',
                'multiple' => false,
                'expanded' => false
            ])

            //->add('conciliador', EntityType::class, [
            //    'label' => 'Conciliador',
            //    'placeholder' => 'Seleccione un Conciliador',
            //    'class' => Usuario::class,
            //    'choice_label' => 'nombres',
            //    'multiple' => false,
            //    'expanded' => false
            //])
            //->add('usuario_externo')

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
