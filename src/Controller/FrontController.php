<?php

namespace App\Controller;
use App\Entity\Local;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LocalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
#[Route('/front')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(LocalRepository $localRepository): Response
    {
        return $this->render('local/show_front.html.twig' ,array('locals' => $localRepository->findAll()));
    
    }
    #[Route('/ajouter', name: 'app_front_index')]
    public function frnot(LocalRepository $localRepository,Request $request,ManagerRegistry $doctrine): Response
    {
        $local = new Local();
        $form= $this->createForm(LocalType::class,$local);
        $form->handleRequest($request);
       
    
        if ($form->isSubmitted() && $form->isValid()){
        
            $em= $doctrine->getManager();
            $em->persist($local);
            $em->flush();
            return  $this->redirectToRoute("app_local_index");
        }}

}
