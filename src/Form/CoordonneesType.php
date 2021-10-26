<?php

namespace App\Form;

use App\Entity\Coordonnees;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoordonneesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, array('label' => false))
            ->add('prenom', null, array('label' => false))
            ->add('tel', TelType::class, [
                'label' => false,
                'invalid_message' => 'Invalide'
            ])
            ->add('mail', EmailType::class, ['label' => false])
            // ->add('fk_user')
            ->add('address', AddressType::class, [
                'label' => 'ADRESSE'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coordonnees::class,
        ]);
    }
}
