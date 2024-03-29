<?php

namespace App\Forms ;

use App\Entity\User;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles',ChoiceType::class, [
                "expanded"=>true,
                "multiple"=>false,
                "choices"=>array(
                    'Administrador'=>"ROLE_ADMIN",
                    'Basico'=>"ROLE_USER"
                )]
            )
        ;

        
        //roles field data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
         // transform the array to a string
            //return count($rolesArray)? $rolesArray[0]: null;
            return implode(', ', $rolesArray);
            },
            function ($rolesString) {
         // transform the string back to an array
            return [$rolesString];
    }
));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
