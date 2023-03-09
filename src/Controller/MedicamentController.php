<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\CategoryRepository;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/medicament')]
class MedicamentController extends AbstractController
{
    #[Route('/', name: 'app_medicament_index')]
    public function index(SessionInterface $session,MedicamentRepository $medicamentRepository,Request $request,ManagerRegistry $doctrine): Response
    {$u = $session->get('my_key');
        $medicament = new Medicament();
        $form= $this->createForm(MedicamentType::class,$medicament);
        $form->handleRequest($request);
       
    
        if ($form->isSubmitted() && $form->isValid()){
        
            $em= $doctrine->getManager();
            $em->persist($medicament);
            $em->flush();
            $accountSid='ACcc341ed39fdef1a8e7bd5f78de612ab9';
            $authToken='5a11180d13ed8ca01fea9c8098195fc6';
            $twilio= new Client($accountSid,$authToken);
            $message = $twilio->messages->create('+21655024331',array( 'from'=>'+15075126980','body'=>'A new medicamentt was detected!',"user"=>$u,));
            return  $this->redirectToRoute("app_medicament_index");
        }


       
        return $this->render('medicament/index.html.twig',array('medicaments' => $medicamentRepository->findAll(), "form"=>$form->createView(),"user"=>$u) );
       
       
    }
    
#[Route('/search', name: 'app_medicament_search', methods: ['GET'])]
    public function search(SessionInterface $session,Request $request,MedicamentRepository $medicamentRepository, CategoryRepository $categorieRepository): Response
    {$u = $session->get('my_key');
        $categories = $categorieRepository->findAll();
        $search = $request->query->get('search');
        $medicament= $medicamentRepository->findByNom($search);
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicament,
            'categories' => $categories,
            "user"=>$u,
        ]);
    }


    #[Route('/new', name: 'app_medicament_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, MedicamentRepository $medicamentRepository): Response
    {$u = $session->get('my_key');
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicamentRepository->save($medicament, true);

            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_medicament_show', methods: ['GET'])]
    public function show(SessionInterface $session,Medicament $medicament): Response
    {$u = $session->get('my_key');
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medicament_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Medicament $medicament, MedicamentRepository $medicamentRepository): Response
    {$u = $session->get('my_key');
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicamentRepository->save($medicament, true);

            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_medicament_delete', methods: ['POST'])]
    public function delete(SessionInterface $session,Request $request, Medicament $medicament, MedicamentRepository $medicamentRepository): Response
    {$u = $session->get('my_key');
        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $medicamentRepository->remove($medicament, true);
        }

        return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
    }
}
