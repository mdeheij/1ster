<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


class IndexController
{
    /**
     * @Template("index.html.twig")
     * @Route("/", name="index")
     */
    public function index(RouterInterface $router)
    {
        return new RedirectResponse($router->generate('dinner_index'), 302);
    }
}
