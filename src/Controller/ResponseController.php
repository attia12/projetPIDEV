<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use App\Service\WordFilterService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

#[Route('/response')]

class ResponseController extends AbstractController
{
    #[Route('/', name: 'app_response')]
    public function index(): Response
    {
        return $this->render('response/index.html.twig', [
            'controller_name' => 'ResponseController',
        ]);
    }

    #[Route('/addresponse/{id?0}', name: 'app_addresponse')]
    public function addResponse(Reclamation $reclamation=null,\App\Entity\Response $response=null,ManagerRegistry $doctrine,Request $request,WordFilterService $wordFilter):Response
    {
        $new=false;
        if(!$response)
        {    $new=true;
            $response=new \App\Entity\Response();


        }



        $response->setReclamation($reclamation);

        //$ersonne est l image de formulaire
        $form=$this->createForm(ResponseType::class,$response);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {//recuperer les data

            $entitymanager=$doctrine->getManager();


            $response->setDescription($wordFilter->filterWords($response->getDescription()));
            $entitymanager->persist($response);
            $entitymanager->flush();
            if($new)
            {
                $message="a eté ajouté avec succes";
            }
            else
            {$message="a eté modifié avec succes";

            }

            $this->addFlash('success', $message);
            //$form->getData();
            return $this->redirectToRoute('app_afficheresponse');

        }
        else {
            return $this->render('response/addresponse.html.twig',[
                    'form'=>$form->createView(),

                ]

            );

        }

    }

    #[Route('/afficheresponse', name: 'app_afficheresponse')]
    public function afficherResponse(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(\App\Entity\Response::class);
        $response=$repository->findAll();
        return $this->render('response/afficherresponse.html.twig', [
            'responses' => $response,
        ]);
    }
    #[Route('/deleteresponse/{id}', name: 'app_deleteresponse')]
    public function deleteResponse(\App\Entity\Response $response = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($response) {
            $manager = $doctrine->getManager();

            $manager->remove($response);
            $manager->flush();
            $this->addFlash('success', 'la response a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'la reclamation inexistant');

        }
        return $this->redirectToRoute('app_afficheresponse');

    }
    #[Route('/detailresponse/{id<\d+>}', name: 'app_detailresponse')]
    public function detailResponse(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(\App\Entity\Response::class);
        $response = $repository->find($id);

        if (!$response) {
            $this->addFlash('error', "la response d'id $id n'existe pas");
            return $this->redirectToRoute('app_afficheresponse');
        }
        return $this->render('response/detailresponse.html.twig', [

            'response' => $response
        ]);


    }
    #[Route('/triec', name: 'triecroissant')]
    public function trierpardescriptioncroissant(ResponseRepository $repository): Response
    {
      $responsecroissant=$repository->triecroissant();
        return $this->render('response/afficherresponse.html.twig', [
            "responses"=>$responsecroissant
        ]);

    }
    #[Route('/tried', name: 'triedecroissant')]
    public function trierpardescriptiondecroissant(ResponseRepository $repository): Response
    {
        $responsedecroissant=$repository->triedecroissant();
        return $this->render('response/afficherresponse.html.twig', [
            "responses"=>$responsedecroissant
        ]);

    }
    #[Route('/ajax', name: 'recherchebyajax')]
    public function searchbyajax(Request $request,NormalizableInterface $Normalizer,ResponseRepository $repo)
    {
        $requeststring=$request->get('searchvValue');
        $response=$repo->findResponsebydescription($requeststring);

        $jsonContent = $Normalizer->normalize($response, 'json', ['groups' => 'response']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }



}
