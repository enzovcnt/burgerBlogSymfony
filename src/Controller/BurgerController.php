<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\BadUrlException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BurgerController extends AbstractController
{
    #[Route('/burger', name: 'burger')]
    public function index(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();

        return $this->render('burger/index.html.twig', [
            'controller_name' => 'BurgerController',
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burger/{id}', name: 'one', priority: -1)]
    public function show(Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    #[Route('/burger/delete/{id}', name: 'delete')]
    public function delete(Burger $burger, EntityManagerInterface $em): Response
    {

        $em->remove($burger);
        $em->flush();
        return $this->redirectToRoute('burger');
    }

    #[Route('/burger/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class, $burger);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {

            $manager->persist($burger);
            $manager->flush();
            return $this->redirectToRoute('burger');

        }

        return $this->render('burger/create.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
