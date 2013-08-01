<?php

namespace Wm\IslandsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\HttpFoundation\Request,
    Wm\IslandsBundle\Form\IslandType;

class DefaultController extends Controller
{
    /**
     * @Route("/{formId}")
     * @Template()
     */
    public function indexAction($formId, Request $request)
    {
        /* @var $islandFormParser \Wm\IslandsBundle\Service\IslandFormParser */
        $islandFormParser = $this->get('wm_islands_form_parser');
        /* @var $kernel \AppKernel */
        $kernel = $this->get('kernel');
        $xmlFileLocation = dirname($kernel->getRootDir()).'/forms/'.$formId.'.xml';
        $fields =  $islandFormParser->parse($xmlFileLocation)->getElements();
        $form = $this->createForm(new IslandType($fields));
        return array('form'=>$form->createView());
        var_dump($form->isValid());
        return new \Symfony\Component\HttpFoundation\JsonResponse(iterator_to_array($request->request->getIterator()));
    }
}
