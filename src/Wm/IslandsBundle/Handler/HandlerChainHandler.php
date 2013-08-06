<?php

namespace Wm\IslandsBundle\Handler;

use Symfony\Component\DependencyInjection\Container;
use Wm\IslandsBundle\Handler\HandlerInterface;
use \Symfony\Component\Form\Form;

/**
 * Description of HandlerChain
 *
 * @author oprokidnev
 */
class HandlerChainHandler implements HandlerInterface
{

    protected $parameters = array();

    /**
     *
     * @var Container
     */
    protected $container;

    /**
     *
     * @var HanlderInterface[]
     */
    protected $handlers;

    /**
     * {@inheritDoc}
     * @param \Symfony\Component\Form\Form $form
     */
    public function handle(Form $form)
    {
        $result = true;
        foreach ($this->handlers as $handler) {
            $result = $handler->handle($form) && $result;
        }
        return $result;
    }

    /**
     * 
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * 
     * @return \Wm\IslandsBundle\Handler\HanlderInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * 
     * @param \Wm\IslandsBundle\Handler\HanlderInterface $handlers
     * @return \Wm\IslandsBundle\Handler\HandlerChainHandler
     */
    public function setHandlers(array $handlers)
    {
        $this->handlers = $handlers;
        return $this;
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
     * @param array $chain
     * @return \Wm\IslandsBundle\Handler\HandlerChainHandler
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        $this->handlers   = array();
        /**
         * Initializing handlers
         */
        foreach ($parameters as $serviceName => $handlerParameters) {
            $this->handlers [] = $this->getContainer()
                ->get('wm_islands_' . $serviceName)
                ->setParameters(@$parameters[$serviceName]);
        }

        return $this;
    }

}

?>
