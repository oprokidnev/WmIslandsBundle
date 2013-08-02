<?php

namespace Wm\IslandsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Component\HttpFoundation\Request,
    Wm\IslandsBundle\Form\IslandType,
    Symfony\Component\Yaml\Parser as YamlParser,
    Wm\IslandsBundle\Handler\HandlerChainHandler;

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
        $kernel           = $this->get('kernel');
        $xmlFileLocation  = dirname($kernel->getRootDir()) . '/forms/' . $formId . '.xml';
        $fields           = $islandFormParser->parse($xmlFileLocation)->getElements();
        $form             = $this->createForm(new IslandType($fields));
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                try {
                    $yamlParser = new YamlParser();
                    $handlerConfig = $yamlParser->parse(file_get_contents(dirname($kernel->getRootDir()) . '/forms/' . $formId . '.yml')) ['handler_chain'];
                } catch (\Exception $exc) {
                    return new \Symfony\Component\HttpFoundation\JsonResponse([
                        'success'  => true,
                        'error'    => ['yml-file-not-found'],
                        'redirect' => 'http://oprokidnev.ru/'
                    ]);
                }
                $handler = $this->get('wm_islands_handler_chain_handler')->setParameters($handlerConfig)->handle($form);


                return new \Symfony\Component\HttpFoundation\JsonResponse([
                    'success'  => true,
                    'error'    => [],
                    'redirect' => 'oprokidnev.ru'
                ]);
            }
        }
        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'success'  => true,
            'error'    => ['form-not-valid'],
            'redirect' => 'http://oprokidnev.ru/badPage'
        ]);
    }

}
