<?php 
namespace Acme\ImageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PresetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
			->add('mode')
			->add('width')
			->add('height')
			->add('save', 'submit');
    }

    public function getName()
    {
        return 'preset';
    }
}