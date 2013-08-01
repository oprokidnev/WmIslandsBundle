<?php

namespace Wm\IslandsBundle\Service;

use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Form\Form;

/**
 * IslandFormConstructor returns Symfony 2 form, builded by Island description
 *
 * @author oprokidnev
 */
class IslandFormParser
{
    /**
     *
     * @var array 
     */
    protected $elements = array();
    public function __construct()
    {
        
    }

    public function parse($xmlFileLocation)
    {
        try {
            $crawler = new Crawler();
            $crawler->addXmlContent(file_get_contents($xmlFileLocation));
        } catch (\Exception $exc) {
            echo $exc->getMessage();
            return null;
        }
        $elements = [];
        $crawler->filter('filters > *')->each(function (Crawler $node, $i) use (&$elements) {
                $nodeName = '';
                foreach ($node as $key => $element) {
                    $nodeName = $element->nodeName;
                }
                /**
                 * Сопоставляем типы данных 
                 */
                switch (trim($nodeName)) {
                    case 'textBox':
                        $fieldName = null;
                        foreach ($node->filter('description')->children() as $parameter) {
                            /* @var $parameter \DOMElement */
                            if ($parameter->nodeName == 'setParameter') {
                                $fieldName = $parameter->getAttribute('name');
                            }
                        }
                        if (!is_null($fieldName)) {
                            $element    = array(
                                $fieldName,
                                'text',
                                array(
                                    'label' => $node->filter('description')->attr('caption')
                                ),
                            );
                            $elements[] = $element;
                        }
                        break;

                    default:
                        break;
                }
            });
        $this->setElements($elements);
        return $this;
    }
    public function getElements()
    {
        return $this->elements;
    }

    public function setElements($elements)
    {
        $this->elements = $elements;
        return $this;
    }


}