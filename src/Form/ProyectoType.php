<?php

namespace App\Form;

use App\Entity\TProyecto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProyectoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre_proyecto')
            ->add('direccion_proyecto')
            ->add('archivo_cotizacion')
            ->add('Fecha_inicio')
            ->add('Fecha_fin')
            ->add('cliente_id')
            ->add('trabajador_id')
            ->add('estado_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TProyecto::class,
        ]);
    }
}
