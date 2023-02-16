<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/reclamation')]

class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    #[Route('/template', name: 'app_template')]
    public function affiche(): Response
    {
        return $this->render('templatefront.html.twig'

        );
    }

    #[Route('/affiche', name: 'app_affiche')]
    public function afficher(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Reclamation::class);
        $reclamation = $repository->findAll();
        return $this->render('reclamation/all.html.twig', [

            'reclamations' => $reclamation
        ]);


    }

    #[Route('/detail/{id<\d+>}', name: 'app_detail')]
    public function detail(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Reclamation::class);
        $reclamation = $repository->find($id);

        if (!$reclamation) {
            $this->addFlash('error', "la reclamation d'id $id n'existe pas");
            return $this->redirectToRoute('app_indexall');
        }
        return $this->render('reclamation/detail.html.twig', [

            'reclamation' => $reclamation
        ]);


    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteReclamation(Reclamation $reclamation = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($reclamation) {
            $manager = $doctrine->getManager();

            $manager->remove($reclamation);
            $manager->flush();
            $this->addFlash('success', 'la reclamation a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'la reclamation inexistant');

        }
        return $this->redirectToRoute('app_indexall');

    }

    #[Route('/addreclamation', name: 'app_addreclaamtion')]
    public function addReclamation(ManagerRegistry $doctrine, Request $request): Response
    {

        $reclamation = new Reclamation();
        //$ersonne est l image de formulaire
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->remove('status');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {//recuperer les data
            $entitymanager = $doctrine->getManager();
            $entitymanager->persist($reclamation);
            $entitymanager->flush();
            $this->addFlash('success', " la reclamation a ete envoyée avec succeée");
            //$form->getData();
            return $this->redirectToRoute('app_indexall');

        } else {
            return $this->render('reclamation/add-reclamation.html.twig', [
                    'form' => $form->createView()

                ]

            );

        }


    }


    #[Route('/edit/{id?0}', name: 'app_edit')]
    public function editReclamation(Reclamation $reclamation=null,ManagerRegistry $doctrine,Request $request): Response
    {$new=false;
        if(!$reclamation)
        {    $new=true;
            $reclamation=new Reclamation();
        }


        //$ersonne est l image de formulaire
        $form=$this->createForm(ReclamationType::class,$reclamation);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {//recuperer les data
            $entitymanager=$doctrine->getManager();
            $entitymanager->persist($reclamation);
            $entitymanager->flush();
            if($new)
            {
                $message="a eté ajouté avec succes";
            }
            else
            {$message="a eté modifié avec succes";

            }
            $this->addFlash('success', $reclamation->getNom().$reclamation->getPrenom() .$message);
            //$form->getData();
            return $this->redirectToRoute('app_indexall');

        }
        else {
            return $this->render('reclamation/add-personne2.html.twig',[
                    'form'=>$form->createView()

                ]

            );

        }





    }
    #[Route('/indecall/{page?1}/{nbre?12}', name: 'app_indexall')]
    public function indexall(ManagerRegistry $doctrine,$nbre,$page):Response
    {
        $repository=$doctrine->getRepository(Reclamation::class);
        //calculer le nombre de personne
        $nbrereclamation=$repository->count([]);
        $nbrepage=ceil($nbrereclamation / $nbre);
        //dd($nbrepage);
        $reclamation=$repository->findBy([],[],$nbre,($page-1)*$nbre);
        return $this->render('reclamation/all.html.twig',[

            'reclamations'=>$reclamation,
            'isPaginated'=>true,
            'nbrepage'=>$nbrepage,
            'page'=>$page,

            'nbre'=>$nbre

        ]);


    }

}
