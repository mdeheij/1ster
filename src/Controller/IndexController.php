<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class IndexController
{
    /**
     * @Template("index.html.twig")
     * @Route("/", name="index")
     */
    public function index(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
    }
}
