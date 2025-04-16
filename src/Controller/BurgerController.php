<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use http\Exception\BadUrlException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/burger/{id}', name: 'one')]
    public function show(Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', [
            'burger' => $burger,
        ]);
    }
}
