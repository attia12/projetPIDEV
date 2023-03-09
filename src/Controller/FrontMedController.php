<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MedicamentType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/frontt')]
class FrontMedController extends AbstractController
{
    #[Route('/med', name: 'app_front_med')]
    public function index(SessionInterface $session,MedicamentRepository $medicamentRepository,Request $request): Response
    {$u = $session->get('my_key');
        $form= $this->createForm(MedicamentType::class);
        $form->handleRequest($request);
        return $this->render('medicament/show_front.html.twig' ,array('medicaments' => $medicamentRepository->findAll(),"form"=>$form,"user"=>$u));

     
    }



    // #[Route('/ajouter', name: 'app_front_index', methods: ['GET', 'POST'])]
    // public function frnot(Request $request, MedicamentRepository $medicamentRepository): Response
    // {
    //     $medicament = new Medicament();
    //     $form = $this->createForm(MedicamentType::class, $medicament);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $medicamentRepository->save($medicament, true);

    //         return $this->redirectToRoute('app_front_index', [], Response::HTTP_SEE_OTHER);
    //     }
    //     return $this->render('medicament/new.html.twig' ,array('medicaments' => $medicamentRepository->findAll(),"form"=>$form));
    //   }
}
