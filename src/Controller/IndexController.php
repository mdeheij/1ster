<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;


class IndexController
{
    /**
     * @Template("index.html.twig")
     * @Route("/", name="index")
     */
    public function index()
    {
    }
}
