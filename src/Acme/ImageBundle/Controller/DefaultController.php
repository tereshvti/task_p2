<?php

namespace Acme\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeImageBundle:Default:index.html.twig', array('name' => $name));
    }
}
