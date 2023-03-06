<?php

namespace App\Controller;
use App\Entity\Local;
use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
#[Route('/consultation')]
class ConsultationController extends AbstractController
{
    #[Route('/', name: 'app_consultation_index')]
    public function index(Local $local=null,ConsultationRepository $consultationRepository,Request $request,ManagerRegistry $doctrine): Response
    {
        $consultation = new Consultation();
         $consultation->setLocaux($local);
        $form= $this->createForm(ConsultationType::class,$consultation);
        $form->handleRequest($request);
   
    
    if ($form->isSubmitted() && $form->isValid()){
    
        $em= $doctrine->getManager();
        $em->persist($consultation);
        $em->flush();
        return  $this->redirectToRoute("app_consultation_index");
    }
    return $this->render('consultation/index.html.twig',array('consultations' => $consultationRepository->findAll(), "form"=>$form->createView()) );

    }

    #[Route('/new', name: 'app_consultation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConsultationRepository $consultationRepository): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultationRepository->save($consultation, true);

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultation_show', methods: ['GET'])]
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consultation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultation $consultation, ConsultationRepository $consultationRepository): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consultationRepository->save($consultation, true);

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultation_delete', methods: ['POST'])]
    public function delete(Request $request, Consultation $consultation, ConsultationRepository $consultationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $consultationRepository->remove($consultation, true);
        }

        return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
    }



    
    #[Route('/affichage/mobile', name: 'app_consultation_allApp')]
    public function allApp(ConsultationRepository $consultationRepository,SerializerInterface $s){
        $x=$consultationRepository->findAll();
    
        $json=$s->serialize($x,'json',['groups'=>"consultations"]);
        return new Response($json);
     
    }
    #[Route('/ajout/mobile', name: 'app_consultation_ajoutApp')]
    public function AjoutMobil(Request $req,NormalizerInterface $s,ManagerRegistry $doctrine){
        
        $em = $doctrine->getManager();
        $consultation=new Consultation();
        $consultation->setNomPatient($req->get('nomPatient'));
        $consultation->setNomMedecin($req->get('nomMedecin'));
        $consultation->setDuree($req->get('duree'));
        $consultation->setDate($req->get('date'));
        $consultation->setLocaux($req->get('locaux'));
        $em -> persist($consultation);
        $em->flush();
        $json=$s->normalize($consultation,'json',['groups'=>"consultations"]);
        return new Response(json_encode($json));
     
    }

    #[Route('/Update/mobile/{id}', name: 'app_consultation_editApp')]
    public function UpdateMobile(Request $req,$id,NormalizerInterface $s,ManagerRegistry $doctrine){
        
        $em = $doctrine->getManager();
        $consultation=$em->getRepository(Consultation::class)->find($id);
        $consultation->setNomPatient($req->get('nomPatient'));
        $consultation->setNomMedecin($req->get('nomMedecin'));
        $consultation->setDuree($req->get('duree'));
        $consultation->setDate($req->get('date'));
      
        $em->flush();
        $json=$s->normalize($consultation,'json',['groups'=>"consultations"]);
        return new Response(" Consultation updated successfully".json_encode($json));
     
    }


    #[Route('/delete/mobile/{id}', name: 'app__deleteApp')]
    public function deleteMobile($id,NormalizerInterface $s,ManagerRegistry $doctrine)
    {
        
        $em = $doctrine->getManager();
        $consultation=$em->getRepository(Consultation::class)->find($id);
        $em->remove($consultation);
        
        
        $em->flush();

        $json=$s->normalize($consultation,'json',['groups'=>"consultations"]);
        return new Response(" consultation deleted successfully".json_encode($json));
     
    }


    #[Route('/calendar/cal', name: 'calendar_events')]
    public function events(ConsultationRepository $consultationRepository): Response
    {
        $consultations=$consultationRepository->findAll();
        //TODO: Handle AJAX request for calendar events
        foreach ($consultations as $consultation)
        {


            $events = [
                ['title'=>$consultation->getNomPatient()." ".$consultation->getNomMedecin(),
                'start' =>$consultation->getDate()->format(\DateTimeInterface::ISO8601),
                'end'  =>$consultation->getDate()->format(\DateTimeInterface::ISO8601)
                
                    ]

            ];
    

        }
        
     

        //return new JsonResponse($events);
        return $this->render('consultation/calendrier.html.twig',
        ['events'=>json_encode($events),
       
        ]);
    }

    #[Route('map/show_in_map/{id}', name: 'app_local_map', methods: ['GET'])]
    public function Map( Consultation $id,EntityManagerInterface $entityManager ): Response
    {

        $Consultation = $entityManager
            ->getRepository(Consultation::class)->findBy( 
                ['id'=>$id ]
            );
        return $this->render('consultation/map_arcgis.html.twig', [
            'Consultation' => $Consultation,
        ]);
    }





}
