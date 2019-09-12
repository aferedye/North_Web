<?php

namespace App\Form;

use App\Entity\Devis;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maquette', RangeType::class)
            ->add('lvlgraphisme', RangeType::class)
            ->add('nbrpage', RangeType::class)
            ->add('nbrlangue', RangeType::class)
            ->add('partieblog', CheckboxType::class)
            ->add('formulaireinscritdevis', RangeType::class)
            ->add('forum', CheckboxType::class)
            ->add('accesmembre', CheckboxType::class)
            ->add('gestionfichier', CheckboxType::class)
            ->add('cartedynamique', CheckboxType::class)
            ->add('integrvideo', CheckboxType::class)
            ->add('assistance', CheckboxType::class)
            ->add('nomprojet', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class)
            ->add('telephone', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
