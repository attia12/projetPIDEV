<?php

namespace App\Controller;

use App\Entity\Local;
use App\Form\LocalType;
use App\Repository\LocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/local')]
class LocalController extends AbstractController
{
    #[Route('/', name: 'app_local_index', methods: ['GET', 'POST'])]
    public function index(SessionInterface $session,LocalRepository $localRepository,Request $request,ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {
        $u = $session->get('my_key');
        
        $local = new Local();
        $form= $this->createForm(LocalType::class,$local);
        $form->handleRequest($request);
       
       
    
        if ($form->isSubmitted() && $form->isValid()){
        
            $em= $doctrine->getManager();
            $em->persist($local);
            $em->flush();
            return  $this->redirectToRoute("app_local_index");
        }
      $local =$localRepository->findAll();



/////////////////////////////////////////////     Trie et Recherche        ////////////////////////////


        $back = null;
            
    if($request->isMethod("POST")){
        if ( $request->request->get('optionsRadios')){
            $SortKey = $request->request->get('optionsRadios');
            switch ($SortKey){
                case 'id':
                    $local = $localRepository->SortByid();
                    break;

                case 'nomBlock':
                    $local = $localRepository->SortBynomBlock();
                    break;

                case 'nomPatient':
                    $local = $localRepository->SortBynomPatient();
                    break;

                case 'nomMedecin':
                    $local = $localRepository->SortBynomMedecin();
                    break;


            }
        }
        else
        {
            $type = $request->request->get('optionsearch');
            $value = $request->request->get('Search');
            switch ($type){
                case 'id':
                    $local = $localRepository->findByid($value);
                    break;

                case 'nomBlock':
                    $local = $localRepository->findBynomBlock($value);
                    break;

                case 'nomPatient':
                    $local= $localRepository->findBynomPatient($value);
                    break;
                case 'nomMedecin':
                    $local = $localRepository->findBynomMedecin($value);
                    break;



            }
        }

        if ( $local){
            $back = "success";
        }else{
            $back = "failure";
        }
    }                                                       
    return $this->render('local/index.html.twig', [
      
        'locals'=> $local,
        "form"=>$form->createView(),
        "user"=>$u
    ]);
       
    }

    #[Route('/new', name: 'app_local_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, LocalRepository $localRepository): Response
    {
        $u = $session->get('my_key')->getId();
        $local = new Local();
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localRepository->save($local, true);

            return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('local/new.html.twig', [
            'local' => $local,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_local_show', methods: ['GET'])]
    public function show(SessionInterface $session,Local $local): Response
    {
        $u = $session->get('my_key');
        return $this->render('local/show.html.twig', [
            'local' => $local,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_local_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Local $local, LocalRepository $localRepository): Response
    {
        $u = $session->get('my_key');
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localRepository->save($local, true);

            return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('local/edit.html.twig', [
            'local' => $local,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_local_delete', methods: ['POST'])]
    public function delete(SessionInterface $session,Request $request, Local $local, LocalRepository $localRepository): Response
    {
        $u = $session->get('my_key');
        if ($this->isCsrfTokenValid('delete'.$local->getId(), $request->request->get('_token'))) {
            $localRepository->remove($local, true);
        }

        return $this->redirectToRoute('app_local_index', [], Response::HTTP_SEE_OTHER);
    }





    
    #[Route('/affichage/mobile', name: 'app__affichage_mobile')]

    public function indexx(LocalRepository $localRepository,SerializerInterface $s)
    {
        
        $x=$localRepository->findAll();
    
        $json=$s->serialize($x,'json',['groups'=>"locals"]);
        return new Response($json);
     
    }


    #[Route('/ajout/mobile', name: 'app__ajout_mobile')]

    public function Ajout_mobile(Request $req,NormalizerInterface $s,ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $local=new Local();
        $local->setNomBlock($req->get('nomBlock'));
        $local->setNomPatient($req->get('nomPatient'));
        $local->setNomMedecin($req->get('nomMedecin'));
        $local->setLocalisation($req->get('localisation'));
        // $local->setLocales($req->get('locales'));
        $em -> persist($local);
        $em->flush();
        $json=$s->normalize($local,'json',['groups'=>"locals"]);
        return new Response(json_encode($json));
     
    }
    #[Route('/Update/mobile/{id}', name: 'app__update_mobile')]

    public function Update_mobile(Request $req,$id,NormalizerInterface $s,ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $local=$em->getRepository(Local::class)->find($id);
        $local->setNomBlock($req->get('nomBlock'));
        $local->setNomPatient($req->get('nomPatient'));
        $local->setNomMedecin($req->get('nomMedecin'));
        $local->setLocalisation($req->get('localisation'));
        $local->setLocales($req->get('locales'));
        
        $em->flush();

        $json=$s->normalize($local,'json',['groups'=>"locals"]);
        return new Response(" local updated successfully".json_encode($json));
     
    }



    #[Route('/delete/mobile/{id}', name: 'app__delete_mobile')]

    public function delete_mobile($id,NormalizerInterface $s,ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $local=$em->getRepository(Local::class)->find($id);
        $em->remove($local);
        
        
        $em->flush();

        $json=$s->normalize($local,'json',['groups'=>"locals"]);
        return new Response(" local deleted successfully".json_encode($json));
     
    }









}
?>
