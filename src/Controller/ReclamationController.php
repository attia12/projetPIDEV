<?php

namespace App\Controller;

use App\Entity\Reclamation;

use App\Form\ReclamationType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Repository\ReclamationRepository;
use App\Service\PdfService;
use App\Service\WordFilterService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Twilio\Rest\Client;

#[Route('/reclamation')]

class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation')]
    public function index(SessionInterface $session): Response
    {
        $u = $session->get('my_key');
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
            "user"=>$u,
        ]);
    }

    #[Route('/template', name: 'app_template')]
    public function affiche(SessionInterface $session): Response
    {  $u = $session->get('my_key');
        return $this->render('templatefront.html.twig'

        );
    }

    #[Route('/affiche', name: 'app_affiche')]
    public function afficher(SessionInterface $session,ManagerRegistry $doctrine): Response
    {  $u = $session->get('my_key');
        $repository = $doctrine->getRepository(Reclamation::class);
        $reclamation = $repository->findAll();
        return $this->render('reclamation/all.html.twig', [

            'reclamations' => $reclamation,
            "user"=>$u,
        ]);


    }

    #[Route('/detail/{id<\d+>}', name: 'app_detail')]
    public function detail(SessionInterface $session,ManagerRegistry $doctrine, $id): Response
    {  $u = $session->get('my_key');
        $repository = $doctrine->getRepository(Reclamation::class);
        $reclamation = $repository->find($id);

        if (!$reclamation) {
            $this->addFlash('error', "la reclamation d'id $id n'existe pas");
            return $this->redirectToRoute('app_indexall');
        }
        return $this->render('reclamation/detail.html.twig', [

            'reclamation' => $reclamation
            ,"user"=>$u,
        ]);


    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteReclamation(SessionInterface $session,Reclamation $reclamation = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        $u = $session->get('my_key');
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
    public function addReclamation(SessionInterface $session,ManagerRegistry $doctrine, Request $request): Response
    {
        $u = $session->get('my_key');
        $reclamation = new Reclamation();
        //$ersonne est l image de formulaire
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->remove('status');

        $form->handleRequest($request);
        if ($form->isSubmitted()) {//recuperer les data
            $entitymanager = $doctrine->getManager();
            $reclamation->setNom($u->getNom());
            $reclamation->setPrenom($u->getPrenom());
            $reclamation->setEmail($u->getEmail());
            $entitymanager->persist($reclamation);
            $entitymanager->flush();
            //sending email
           // $email = (new Email())
               // ->from('hello@example.com')
               // ->to('you@example.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
               // ->subject('Time for Symfony Mailer!')
                //->text('Sending emails is fun again!')
                //->html('<p>See Twig integration for better HTML integration!</p>');

            //$mailer->send($email);
           /* $accountSid='AC8f3d4e9f79cf0bd67b0a93b93b1f36d2';
            $authToken='08f608bf084b546a538d3694c0f477a9';
            $twilio= new Client($accountSid,$authToken);
            $message = $twilio->messages->create("+216".$u->getNum(),array( 'from'=>'+12707138326','body'=>'A new reclamation was detected!',));
            if ($message->sid) {
                $sms= 'SMS sent successfully.';
                $this->addFlash('success', " la reclamation a ete envoyée avec succeée");
                //$form->getData();
                return $this->redirectToRoute('app_indexall');
            } else {
                $sms ='Failed to send SMS.';
            }

*/return $this->redirectToRoute('app_addreclaamtion');

        } else {
            return $this->render('reclamation/add-reclamation.html.twig', [
                    'form' => $form->createView(),
                    "user"=>$u,


                ]

            );

        }


    }


    #[Route('/edit/{id?0}', name: 'app_edit')]
    public function editReclamation(SessionInterface $session,Reclamation $reclamation=null,ManagerRegistry $doctrine,Request $request): Response
    {$new=false;
        $u = $session->get('my_key');
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
                    'form'=>$form->createView(),
                    "user"=>$u,
                ]

            );

        }





    }
    #[Route('/indecall/{page?1}/{nbre?9}', name: 'app_indexall')]
    public function indexall(SessionInterface $session,ManagerRegistry $doctrine,$nbre,$page):Response
    {
        $u = $session->get('my_key');
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
            "user"=>$u,
            'nbre'=>$nbre

        ]);


    }
    #[Route('/pdf/{id?1}', name: 'personne_pdf')]
    public function generatepdf(SessionInterface $session,Reclamation $reclamation=null,PdfService $pdf)
    {
        $u = $session->get('my_key');
        $html=$this->render('reclamation/detail.html.twig',[
            "user"=>$u,
            'reclamation'=>$reclamation
        ]);


        $pdf->showpdf($html);

    }
    #[Route('/affichejson', name: 'app_affichejson')]
    public function afficherjson(ManagerRegistry $doctrine,SerializerInterface $serializer): Response
    {
        $repository = $doctrine->getRepository(Reclamation::class);
        $reclamation = $repository->findAll();

        $reclamationNormalises = $serializer->serialize($reclamation, 'json', ['groups' => "reclamation"]);

        return new Response(json_encode($reclamationNormalises));

    }
    #[Route("/addReclamationJSON", name: "addreclamationJSON")]
    public function addReclamationJSON(Request $req,   NormalizerInterface $Normalizer,ManagerRegistry $doctrine)
    {

        //$em = $this->getDoctrine()->getManager();
        $manager=$doctrine->getManager();
        $reclamation = new Reclamation();
        //$reclamation->setNsc($req->get('nsc'));
        $reclamation->setNom($req->get('nom'));
        $reclamation->setPrenom($req->get('prenom'));
        $reclamation->setEmail($req->get('email'));
        $reclamation->setStatus(0);
        $reclamation->setDescription($req->get('description'));

        $manager->persist($reclamation);
        $manager->flush();

        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamation']);
        return new Response(json_encode($jsonContent));
    }
    #[Route("/updateReclaamtionJSON/{id}", name: "updatereclaamtionJSON")]
    public function updateReclamationJSON(Request $req, $id, NormalizerInterface $Normalizer,ManagerRegistry $doctrine)
    {

        $manager=$doctrine->getManager();
        $reclamation = $manager->getRepository(Reclamation::class)->find($id);
        $reclamation->setNom($req->get('nom'));
        $reclamation->setPrenom($req->get('prenom'));
        $reclamation->setEmail($req->get('email'));
        $reclamation->setDescription($req->get('description'));

        $manager->flush();

        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamation']);
        return new Response("Student updated successfully " . json_encode($jsonContent));
    }
    #[Route("/deleteReclamation/{id}", name: "deleteReclamationJSON")]
    public function deleteReclamationJSON(Request $req, $id, NormalizerInterface $Normalizer,ManagerRegistry $doctrine)
    {
        $manager=$doctrine->getManager();

        $reclamation = $manager->getRepository(Reclamation::class)->find($id);
        $manager->remove($reclamation);
        $manager->flush();
        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamation']);
        return new Response("Student deleted successfully " . json_encode($jsonContent));
    }
    #[Route("/detailjson/{id}", name: "detailjson")]
    public function ReclaamtionId($id, NormalizerInterface $normalizer, ReclamationRepository $repo)
    {
        $reclamation = $repo->find($id);
        $reclamationNormalises = $normalizer->normalize($reclamation, 'json', ['groups' => "reclamation"]);
        return new Response(json_encode($reclamationNormalises));
    }


    #[Route('/f', name: 'filtrer')]
    public function filterWords(SessionInterface $session,WordFilterService $wordFilter): Response
    {
        $text = 'This is some text with badword1 and badword2.';
        $filteredText = $wordFilter->filterWords($text);

        return new Response($filteredText);
    }







}
