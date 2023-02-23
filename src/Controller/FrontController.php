<?php

namespace App\Controller;
use App\Form\LocalType;
use App\Entity\Local;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LocalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
#[Route('/front')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(LocalRepository $localRepository,Request $request): Response
    {
        $form= $this->createForm(LocalType::class);
        $form->handleRequest($request);
        return $this->render('local/show_front.html.twig' ,array('locals' => $localRepository->findAll(),"form"=>$form));
    
    }
    #[Route('/ajouter', name: 'app_front_index', methods: ['GET', 'POST'])]
    public function frnot(Request $request, ConsultationRepository $consultationRepository): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultationRepository->save($consultation, true);

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('consultation/new.html.twig' ,array('consultations' => $consultationRepository->findAll(),"form"=>$form));
      }
        //test

}
