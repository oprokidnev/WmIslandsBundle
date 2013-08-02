<?php

namespace Wm\IslandsBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of IslandType
 *
 * @author oprokidnev
 */
class IslandType extends AbstractType
{

    /**
     *
     * @var array
     */
    protected $fields = array();

    /**
     * {@inheritDoc}
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->fields as $field) {
            print_r($field);
            call_user_func_array([$builder, 'add'], $field);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return '';
    }

}