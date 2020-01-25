<?php

namespace App\Controller;

use App\Entity\Shiritori;
use App\Repository\ShiritoriRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ShiritoriRepository $shiritoriRepository
     * @return Response
     */
    public function index(ShiritoriRepository $shiritoriRepository)
    {
        $shiritories = $shiritoriRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'shiritories' => $shiritories,
        ]);
    }

    /**
     * @Route("/new", name="create_shiritori")
     */
    public function create(){
        $shiritori = new Shiritori();
        $em = $this->getDoctrine()->getManager();
        $em->persist($shiritori);
        $em->flush();

        return $this->redirectToRoute('shiritori', ['id' => $shiritori->getId()]);
    }
}
