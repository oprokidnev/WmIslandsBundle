<?php

namespace Wm\IslandsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of IslandType
 *
 * @author oprokidnev
 */
class IslandType extends AbstractType
{

    protected $fields = array();

    public function __construct($fields)
    {
        $this->fields=$fields;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->fields as $field) {
            print_r($field);
            call_user_func_array([$builder, 'add'], $field);
        }
    }

    public function getName()
    {
        return '';
    }

}