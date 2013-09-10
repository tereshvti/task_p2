<?php

namespace Acme\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\ImageBundle\Entity\Preset2;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PresetController extends Controller
{
    public function indexAction()
    {
         $presets = $this->getDoctrine()
			->getRepository('AcmeImageBundle:Preset2')
			->findAll();

		if (!$presets) {
			throw $this->createNotFoundException(
				'No presets found :('
			);
		}
        return $this->render('AcmeImageBundle:Preset:index.html.twig', array('presets' => $presets));
    }

	public function newAction(Request $request)
    {
        $preset = new Preset2();
        $form = $this->createFormBuilder($preset)
			->add('name', 'text')
			->add('mode', 'text')
			->add('width', 'integer')
			->add('height', 'integer')
			->add('save', 'submit')
			->getForm();
		
				
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			/*
			if (!(in_array ($form->get('mode')->getData(), array('IN', 'OUT', 'EXACT')))) {
				$this->get('session')->getFlashBag()->add(
					'notice',
					'Invalid mode'
				);
				return $this->redirect($this->generateUrl('new_preset'));
			} */
			$validator = $this->get('validator');
			$errors = $validator->validate($preset);

			if (count($errors) > 0) {
				return new Response(print_r($errors, true));
			}
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($preset);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add(
				'notice',
				'Your changes were saved!'
			);
		   return $this->redirect($this->generateUrl('acme_image_homepage'));
		}
		
        return $this->render('AcmeImageBundle:Preset:new.html.twig', array(
            'form' => $form->createView(),
        ));
	}
	
	public function testAction()
	{
		$preset = new Preset2();
		
		$preset->setName('test');
		$preset->setHeight(190);
		$preset->setWidth(190);
		$validator = $this->get('validator');
		$errors = $validator->validate($preset);
		
		if (count($errors) > 0) {
			return new Response(print_r($errors, true));
		}
		return new Response(var_dump($errors));
		
	}
    
}
