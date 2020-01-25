<?php

namespace App\Controller;

use App\Entity\Shiritori;
use App\Entity\Word;
use App\Form\WordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShiritoriController extends AbstractController
{
    /**
     * @Route("/shiritori/{id}", name="shiritori")
     * @param Shiritori $shiritori
     * @param Request $request
     * @return Response
     */
    public function index(Shiritori $shiritori, Request $request)
    {
        $newWord = new Word();
        $newWord->setShiritori($shiritori);

        $form = $this->createForm(WordType::class, $newWord);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($newWord);
            $em->flush();

            return $this->redirectToRoute('shiritori', ['id' => $shiritori->getId()]);
        }

        return $this->render('shiritori/index.html.twig', [
            'controller_name' => 'ShiritoriController',
            'shiritori' => $shiritori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_shiritori", methods={"DELETE"})
     * @param Shiritori $shiritori
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Shiritori $shiritori, Request $request){
        if($this->isCsrfTokenValid('delete', $request->get('_token'))){
            $em = $this->getDoctrine()->getManager();
            $em->remove($shiritori);
            $em->flush();
            $this->addFlash('success', "Le shiritori a bien été supprimé");
        }

        return $this->redirectToRoute('home');
    }
}
