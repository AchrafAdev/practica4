<?php

namespace App\Form;

use App\Entity\Usuarios;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UsuariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', TextType::class)
            ->add('Apellidos', TextType::class)
            ->add('Nacimiento',  DateType::class, [
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => true,
            ])
            ->add('Sexo',ChoiceType::class,array(
                "expanded"=>true,
                "multiple"=>false,
                "choices"=>array(
                    'Masculino'=>"M",
                    'Femenino'=>"F"
                )
            ))
            ->add('Ciudad', null, [
                "multiple"=>false,
                "expanded"=>false,
                'required'=>false,
                'label_attr'=>['class'=>'Ciudades'],
                'placeholder' => 'Elige una ciudad',   
            ])
            ->add('Aficiones', null, [
                "multiple" =>true,
                "expanded" =>true,
                'label_attr' => ['class'=>'Aficiones'],
            ])
            ->add('imagen',FileType::class, [
                'label' => 'Imagen',
                'mapped' => false,
                'required' => true,
                'constraints'=> [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Suba su foto aqui',
                    ])
                    ],
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
