<?php

namespace Acme\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\ImageBundle\Entity\Preset2;
use Acme\ImageBundle\Form\Type\PresetType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Exception\IOException;

class MyajaxController extends Controller
{	
	public function updateDataAction(){
	  $request = $this->container->get('request');        
	  $preset_id = $request->request->get('preset');
	  $image = $request->request->get('image');
	  
	  $em = $this->getDoctrine()->getManager();
	  $preset = $em->getRepository('AcmeImageBundle:Preset2')
			->find($preset_id);
	  
	  $dir = getcwd() . "\\images\\cache\\" . $preset->getName();
	  if (!is_dir($dir)) {
		mkdir($dir);         
	  }
	  
	  $exist = is_dir($dir);
	  
	  $resize = $this->get('image_resize');
	  $src = "\\images\\origins\\" . $image;
	  $dest = "\\images\\cache\\" . $preset->getName() . "\\" . $image;
	  $success = $resize->img_resize($preset->getMode(), $src, $dest, $preset->getWidth(), $preset->getHeight());
	  
	  $response = array("code" => 100, "success" => $success, "image" => $image, "dir" => $dir, "exist" => $exist);
	  return new Response(json_encode($response)); 
	}   
}
