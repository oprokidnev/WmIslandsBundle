<?php

namespace Wm\IslandsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Log
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="formData", type="array")
     */
    private $formData;

    /**
     * @var array
     *
     * @ORM\Column(name="environment", type="array")
     */
    private $environment;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set formData
     *
     * @param array $formData
     * @return Log
     */
    public function setFormData($formData)
    {
        $this->formData = $formData;
    
        return $this;
    }

    /**
     * Get formData
     *
     * @return array 
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * Set environment
     *
     * @param array $environment
     * @return Log
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    
        return $this;
    }

    /**
     * Get environment
     *
     * @return array 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
