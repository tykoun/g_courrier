<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * permet d'avoir la configuration de base d'un champ !
     * 
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder){
        return[
//            'label' => false,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TextType::class, $this->getConfiguration("Nom", "Nom d'utilisateur..."))
            ->add('Prenom',TextType::class, $this->getConfiguration("Prenom", "Prenom d'utilisateur..."))
            ->add('Telephone',TextType::class, $this->getConfiguration("Numero Telephone", "+261..."))
            ->add('email',EmailType::class, $this->getConfiguration("email", "Adresse email..."))
            ->add('adresse',TextType::class, $this->getConfiguration("Adresse", "Lot..."))
            ->add('Fonction',TextType::class, $this->getConfiguration("Fonction", "Fonction..."))
            ->add('Username',TextType::class, $this->getConfiguration("Username", "Surnom"))
            ->add('Password',PasswordType::class, $this->getConfiguration("Mot de passe", "Mot de passe..."))
            ->add('Confirm_password',PasswordType::class, $this->getConfiguration("Confirmation du mot de passe", "Répétez votre mot de passe..."))
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'NomService',
//                'label' => false,
//                 'expanded' => true,
                
                // 'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
