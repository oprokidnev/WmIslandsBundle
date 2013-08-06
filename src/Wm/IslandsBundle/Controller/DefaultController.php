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
     */
    public function indexAction($formId, Request $request)
    {
        $success = true;
        $errors  = [];

        /* @var $islandFormParser \Wm\IslandsBundle\Service\IslandFormParser */
        $islandFormParser = $this->get('wm_islands_form_parser');
        /* @var $kernel \AppKernel */
        $kernel           = $this->get('kernel');

        try {
            $yamlParser     = new YamlParser();
            $config         = $yamlParser->parse(file_get_contents(dirname($kernel->getRootDir()) . '/forms/' . $formId . '.yml'));
            $handlerConfig  = $config['handler_chain'];
            $responseConfig = $config['response'];
        } catch (\Exception $exc) {
            $success  = false;
            $errors[] = 'файл описания действий формы не найден или не включает необходимые параметры';
            return $this->getResponse($success, $errors, 'http://webmotor.ru/');
        }

        $xmlFileLocation = dirname($kernel->getRootDir()) . '/forms/' . $formId . '.xml';
        if (file_exists($xmlFileLocation)) {

            $fields = $islandFormParser->parse($xmlFileLocation)->getElements();
            $form   = $this->createForm(new IslandType($fields));

            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $handler = $this->get('wm_islands_handler_chain_handler')
                        ->setParameters($handlerConfig)
                        ->handle($form);
                    
                    if ($handler) {
                        $success = $success && true;
                    } else {
                        $success  = false;
                        $errors[] = 'Обработчик выдал ошибку';
                    }
                }
            }
        } else {
            $success  = false;
            $errors[] = 'файл описания формы не найден';
        }
        $redirect = $success ? $responseConfig['success_url'] : $responseConfig['failure_url'];
        return $this->getResponse($formId, $success, $errors, $redirect);
    }

    public function getResponse($formId, $success, $errors, $redirect)
    {
        /* @var $logger \Wm\IslandsBundle\Log\Logger */
        $logger = $this->container->get('wm_islands_logger');
        $logger->save($formId, $success, $errors);

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'success'  => $success,
            'error'    => $errors,
            'redirect' => $redirect
        ]);
    }

}
