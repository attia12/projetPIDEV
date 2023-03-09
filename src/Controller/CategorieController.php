<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_categorie_index')]
    public function index(SessionInterface $session,CategorieRepository $categorieRepository,Request $request): Response
    {$u = $session->get('my_key');
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_categorie_index');
        }
        return $this->render('categorie/index.html.twig', array(
            'categories' => $categorieRepository->findAll(),
            "form"=> $form->CreateView() ,"user"=>$u));
    }

    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, CategorieRepository $categorieRepository): Response
    {$u = $session->get('my_key');
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(SessionInterface $session,Categorie $categorie): Response
    {$u = $session->get('my_key');
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {$u = $session->get('my_key');
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/remove/{id}', name: 'app_categorie_delete')]
    public function delete(SessionInterface $session,Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {$u = $session->get('my_key');
       
            $categorieRepository->remove($categorie, true);
        

        return $this->redirectToRoute('app_categorie_index');
    }
}
