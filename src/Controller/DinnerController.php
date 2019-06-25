<?php

namespace App\Controller;

use App\Entity\Dinner;
use App\Entity\Dish;
use App\Form\DinnerType;
use App\Form\DishType;
use App\Repository\DinnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dinner")
 */
class DinnerController extends AbstractController
{
    /**
     * @Route("/", name="dinner_index", methods={"GET"})
     */
    public function index(DinnerRepository $dinnerRepository): Response
    {
        return $this->render('dinner/index.html.twig', [
            'dinners' => $dinnerRepository->findAllSortedByDate(),
        ]);
    }

    /**
     * @Route("/new", name="dinner_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dinner = new Dinner();
        $form = $this->createForm(DinnerType::class, $dinner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dinner);
            $entityManager->flush();

            return $this->redirectToRoute('dinner_index');
        }

        return $this->render('dinner/new.html.twig', [
            'dinner' => $dinner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Template("dinner/show.html.twig")
     * @Route("/{id}", name="dinner_show", methods={"GET"})
     */
    public function show(Dinner $dinner): array
    {
        return [
            'user' => $this->getUser(),
            'dinner' => $dinner,
        ];
    }

    /**
     * @Route("/{id}/edit", name="dinner_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dinner $dinner): Response
    {
        $form = $this->createForm(DinnerType::class, $dinner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dinner_index', [
                'id' => $dinner->getId(),
            ]);
        }

        return $this->render('dinner/edit.html.twig', [
            'dinner' => $dinner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dinner_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dinner $dinner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dinner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dinner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dinner_index');
    }

    /**
     * @Route("/{id}/attend", name="dinner_attend", methods={"POST"})
     */
    public function attend(Request $request, Dinner $dinner, EntityManagerInterface $em): Response
    {
        if ($request->request->getBoolean('present')) {
            $dinner->addGoing($this->getUser());
        } else {
            $dinner->removeGoing($this->getUser());
        }

        $em->persist($dinner);
        $em->flush();

        return $this->redirectToRoute('dinner_show', ['id' => $dinner->getId()]);
    }


    /**
     * @Route("/{id}/new-dish", name="dish_new", methods={"GET","POST"})
     */
    public function newDish(Dinner $dinner, Request $request): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dish->setDinner($dinner);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dish);
            $entityManager->flush();

            return $this->redirectToRoute('dinner_show', ['id' => $dinner->getId()]);
        }

        return $this->render('dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }

}
