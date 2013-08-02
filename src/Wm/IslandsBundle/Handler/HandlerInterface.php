<?php

namespace Wm\IslandsBundle\Handler;

use Symfony\Component\Form\Form;

/**
 *
 * @author oprokidnev
 */
interface HandlerInterface
{
    /**
     * 
     * @param \Symfony\Component\Form\Form $form
     * @return boolean Description
     */
    public function handle(Form $form);
}

?>
