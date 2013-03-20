<?php

namespace ILL\DataCiteDOIBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TitleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('type', 'choice', array(
            'required'  => true,
                     'attr' => array(
            "data-bind" => 'options: type, optionsValue: "id", optionsText: "type"'
            )
        ));
    }

    public function getName()
    {
        return "";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ILL\DataCiteDOIBundle\Model\Metadata\Title'
        ));
    }

}