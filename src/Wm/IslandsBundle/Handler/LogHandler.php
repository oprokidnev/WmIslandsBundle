<?php

namespace Wm\IslandsBundle\Handler;

use \Symfony\Component\Templating\EngineInterface,
    Wm\IslandsBundle\Entity\Log;

/**
 * Mail handler 
 *
 * @author oprokidnev
 */
class LogHandler implements HandlerInterface
{

    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * 
     * {@inheritDoc}
     */
    public function handle(\Symfony\Component\Form\Form $form)
    {
        $om    = $this->getObjectManager();
        $entry = new Log();
        $entry
            ->setFormData($form->getData())
            ->setEnvironment(array(
                'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
        ));
        $om->persist($entry);
        $om->flush();
    }

    /**
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * 
     * @param array|null $parameters
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setParameters($parameters)
    {
        if (!is_null($parameters)) {
            $this->parameters = $parameters;
            foreach ($parameters as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }

    /**
     * 
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @return \Wm\IslandsBundle\Handler\LogHandler
     */
    public function setObjectManager(\Doctrine\Common\Persistence\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

}

?>
