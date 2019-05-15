<?php

namespace App\Form;

use App\Entity\TDetalleProyectoHerramientas;
use App\Entity\TProyecto;
use App\Entity\THerramienta;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;





class DetalleHerramientasPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        

        ->add('herramientaid', EntityType::class, array(
                'class' => THerramienta::class,
                'choice_label' => 'codigo'))


        ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();

            
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TDetalleProyectoHerramientas::class,
        ]);
    }
}
