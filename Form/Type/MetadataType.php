<?php

namespace ILL\DataCiteDOIBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MetadataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('identifier');
        $builder->add('rights');
        $builder->add('publisher');
        $builder->add('publicationYear');
        $builder->add('language');

		$builder->add('titles', 'collection', array(
		    'type'   => new TitleType(),
		    'allow_add'  => true,
		    'allow_delete' => true
		));
    }

    public function getName()
    {
        //return 'metadata';
    }
}