<?php

namespace Acme\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\ImageBundle\Entity\Preset2;
use Acme\ImageBundle\Form\Type\PresetType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Exception\IOException;

class PresetController extends Controller
{	
    public function indexAction()
    {
		$resize = $this->get('image_resize');
        $presets = $this->getDoctrine()
			->getRepository('AcmeImageBundle:Preset2')
			->findAll();
/*
		if (!$presets) {
			throw $this->createNotFoundException(
				'No presets found :('
			);
		}*/
		//получаем список файлов в \images\origins
		$dir = getcwd() . '\images\origins';
		$origins = $resize->find_all_files($dir);
		
        return $this->render('AcmeImageBundle:Preset:index.html.twig', array('presets' => $presets, 'origins' => $origins));
    }

	 public function showAction($id)
    {	
		$preset = $this->getDoctrine()
			->getRepository('AcmeImageBundle:Preset2')
			->find($id);
		$dir = getcwd() . '\\images\\cache\\' . $preset->getName();
		$resize = $this->get('image_resize');
		$size = 0;
		$count = 0;
		if (file_exists($dir)) {
			$files = $resize->find_all_files($dir);
			$count = count($files);
			foreach ($files as &$file) {
			  $size += filesize($dir . "\\" . $file);
			}
		}
		
		//return new Response($count);
		return $this->render('AcmeImageBundle:Preset:show.html.twig', array('preset' => $preset, 'count' => $count, 'size' => $size));

    }
	
	public function newAction(Request $request)
    {
        $preset = new Preset2();

		$form = $this->createForm(new PresetType(), $preset);
				
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
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$preset = $em->getRepository('AcmeImageBundle:Preset2')
			->find($id);
		$form = $this->createForm(new PresetType(), $preset);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {

			$validator = $this->get('validator');
			$errors = $validator->validate($preset);

			if (count($errors) > 0) {
				return new Response(print_r($errors, true));
			}
			
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
	public function destroyAction()
	{
		$request = $this->container->get('request');    
		$id = $request->request->get('id');
		$em = $this->getDoctrine()->getManager();
		$preset = $em->getRepository('AcmeImageBundle:Preset2')->find($id);
		//формируем путь к директории пресета и удаляем её, если она существует
		$dir = getcwd() . '\\images\\cache\\' . $preset->getName();
		$img_resize = $this->get('image_resize');
		if (is_dir($dir)) $img_resize->deleteDir($dir);
		//удаляем пресет из БД
		$em->remove($preset);
		$em->flush();
	    $response = array("code" => 100, "success" => true);
	    return new Response(json_encode($response)); 
	}
	
    public function testAction()
	{
		$fs = new Filesystem();
		$resize = $this->get('image_resize');
		//$resize->find_all_files(__DIR__);
		try {
			$fs->mkdir('new');
		} catch (IOException $e) {
			echo "An error occurred while creating your directory";
		}
		$dir = getcwd() . '\images\origins';
		//return new Response($dir);
		return new Response($dir);
	}

}
