<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category_index')]
    public function index(SessionInterface $session,CategoryRepository $categoryRepository,Request $request,ManagerRegistry $doctrine): Response
    {
        $u = $session->get('my_key');
        $category = new Category();
        $form= $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
       
    
        if ($form->isSubmitted() && $form->isValid()){
        
            $em= $doctrine->getManager();
            $em->persist($category);
            $em->flush();
            return  $this->redirectToRoute("app_category_index");
        }


       
        return $this->render('category/index.html.twig',array('categories' => $categoryRepository->findAll(), "form"=>$form->createView(),"user"=>$u) );

    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, CategoryRepository $categoryRepository): Response
    {$u = $session->get('my_key');
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(SessionInterface $session,Category $category): Response
    {$u = $session->get('my_key');
        return $this->render('category/show.html.twig', [
            'category' => $category,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {$u = $session->get('my_key');
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(SessionInterface $session,Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {$u = $session->get('my_key');
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
