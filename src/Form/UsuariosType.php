<?php

namespace App\Form;

use App\Entity\Usuarios;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre')
            ->add('Apellidos')
            ->add('Nacimiento')
            ->add('Sexo',ChoiceType::class,array(
                "expanded"=>true,
                "multiple"=>false,
                "choices"=>array(
                    'Masculino'=>"M",
                    'Femenino'=>"F"
                )
            ))
            ->add('Ciudad')
            ->add('Aficiones', null, [
                "multiple"=>true,
                "expanded"=>true,
                'label_attr' => ['class'=>'Aficiones'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuarios::class,
        ]);
    }
}
