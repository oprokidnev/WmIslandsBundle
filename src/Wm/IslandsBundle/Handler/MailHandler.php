<?php

namespace Wm\IslandsBundle\Handler;

use \Symfony\Component\Templating\EngineInterface;

/**
 * Description of Mail
 *
 * @author oprokidnev
 */
class MailHandler implements HandlerInterface
{

    /**
     *
     * @var EngineInterface
     */
    protected $renderer;

    /**
     *
     * @var array
     */
    protected $parameters;

    /**
     *
     * @var string
     */
    protected $to;

    /**
     *
     * @var string
     */
    protected $sender;

    /**
     *
     * @var string
     */
    protected $subject;

    /**
     *
     * @var string
     */
    protected $template;

    /**
     *
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    public function __construct()
    {
        
    }

    /**
     * 
     * @return \Swift_Mailer
     */
    public function getSwiftMailer()
    {
        return $this->swiftMailer;
    }

    /**
     * 
     * @param \Swift_Mailer $swiftMailer
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setSwiftMailer(\Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
        return $this;
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function handle(\Symfony\Component\Form\Form $form)
    {
        $mailer  = $this->getSwiftMailer();
        /* @var $message \Swift_Message */
        $message = $mailer->createMessage();
        $message->addTo($this->getTo());
        $message->setSubject($this->getSubject());
        $message->setBody($this->getRenderer()->render($this->getTemplate(), $form->getData()));
        $message->setSender($this->getSender());
        return $mailer->send($message);
        ;
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
     * @param array $parameters
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        foreach ($parameters as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * 
     * @param string $to
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * 
     * @param string $subject
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * 
     * @param string $template
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * 
     * @return \Symfony\Component\Templating\EngineInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * 
     * @param \Symfony\Component\Templating\EngineInterface $renderer
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setRenderer(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * 
     * @param string $sender
     * @return \Wm\IslandsBundle\Handler\MailHandler
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

}

?>
