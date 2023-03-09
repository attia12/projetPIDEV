<?php

namespace App\Controller;
use App\Entity\Don;
use App\Form\DonType;
use Endroid\QrCode\QrCode;
use App\Repository\DonRepository;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Form\LocalType;
use App\Form\ReserveType;
use App\Entity\Local;



use App\Repository\LocalRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/front')]
class FrontController extends AbstractController
{
    #[Route('/local/local', name: 'app_front')]
    public function index(SessionInterface $session,LocalRepository $localRepository,Request $request,ConsultationRepository $consultationRepository): Response
    {
        $u = $session->get('my_key');
        $form1= $this->createForm(LocalType::class);
        $form1->handleRequest($request);
        $consultation = new Consultation();
        $form = $this->createForm(ReserveType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $consultation->setnomPatient("N/A");
            $consultation->setnomPatient($u->getNom()." ".$u->getPrenom());
            $consultationRepository->save($consultation, true);

            return $this->redirectToRoute('app_front', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('local/show_front.html.twig' ,array('locals' => $localRepository->findAll(),"form"=>$form->createView()));
    }
    #[Route('/ajouter', name: 'app_front_index', methods: ['GET', 'POST'])]
    public function frnot(Request $request, ConsultationRepository $consultationRepository): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ReserveType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $consultationRepository->save($consultation, true);

            return $this->redirectToRoute('app_front_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('consultation/new.html.twig' ,array('consultations' => $consultationRepository->findAll(), "form"=>$form->createView()));
      }


      #[Route('map/show_in_mapp/{id}', name: 'app_local_mapp', methods: ['GET'])]
      public function Map( Local $id,EntityManagerInterface $entityManager ): Response
      {
  
          $Consultation = $entityManager
              ->getRepository(Local::class)->findall();
          return $this->render('front/map.html.twig', [
              'Consultation' => $Consultation,
          ]);
          
      }
      #[Route('/consultation', name: 'app_consult', methods: ['GET'])]
      public function affichageee(SessionInterface $session,EntityManagerInterface $entityManager ,ConsultationRepository $consultationRepository): Response
      {
        $u = $session->get('my_key');
$consult=$consultationRepository->findAll();
$i=0;
$test=0;
foreach ($consult as $c)
{
if ($c->getnomMedecin()=="N/A")
{$tab[$i]=$c;
$i=$i+1;
$test=1;}
}
if($test==1)

        return $this->render('front/affichage_cons.html.twig' ,array('consultations' => $tab,"user"=>$u));
      
else 
return $this->render('front/affichage_cons.html.twig' ,array('consultations' => $consultationRepository->findAll(),"user"=>$u));    
    }





      #[Route('/affectation/{id}', name: 'app_consultt', methods: ['GET'])]
      public function affectation($id,SessionInterface $session,EntityManagerInterface $entityManager ,ConsultationRepository $consultationRepository): Response
      {
        $u = $session->get('my_key');

$consult=$consultationRepository->find($id);
$consult->setnomMedecin($u->getNom()." ".$u->getPrenom());
$consultationRepository->save($consult, true);
        return $this->redirectToRoute('app_consult');
      }


      #[Route('/affichage_don_front', name: 'app_affichage_don')]
      public function affichage_don(DonRepository $donRepository,Request $request,SluggerInterface $slugger): Response
      {
          $don = new Don();
          $form = $this->createForm(donType::class, $don);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $photo = $form->get('imge')->getData();
          
              // this condition is needed because the 'brochure' field is not required
              // so the PDF file must be processed only when a file is uploaded
              if ($photo) {
                  $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                  // this is needed to safely include the file name as part of the URL
                  $safeFilename = $slugger->slug($originalFilename);
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
          
                  // Move the file to the directory where brochures are stored
                  try {
                      $photo->move(
                          $this->getParameter('don_directory'),
                          $newFilename
                      );
                  } catch (FileException $e) {
                      // ... handle exception if something happens during file upload
                  }
          
                  // updates the 'brochureFilename' property to store the PDF file name
                  // instead of its contents
                  $don->setImge($newFilename);
              }
          
                      $donRepository->save($don, true);
          
                      return $this->redirectToRoute('app_front');
                  }
  
  
  
          return $this->render('front/affichage_don.html.twig', array("dons"=> $donRepository->findAll(),"form"=>$form->CreateView()));
      }
      
  // #[Route('/Qrcode', name: 'Qrcode')]
  
  public function getQrCodeForProduct(int $id): Response
  {
      // Récupérer les informations du compte bancaire à partir de la base de données
      $pr = $this->getDoctrine()->getRepository(Don::class)->find($id);
  
      if (!$pr) {
          throw $this->createNotFoundException('Le  produit  n\'existe pas');
      }
      $qrText = sprintf(
          "Nom : %s\n Id benovole : mahdii %s",
          $pr->getIdBen(),
          $pr->getTitre(),
         
      );
  
  $qrCode = new QrCode($qrText);
      // Générer le code QR à partir des informations du compte bancaire
     
      $qrCode->setSize(300);
      $qrCode->setMargin(10);
  
      $pngWriter = new PngWriter();
      $qrCodeResult = $pngWriter->write($qrCode);
  
       // Générer la réponse HTTP contenant le code QR
       $response = new QrCodeResponse($qrCodeResult);
       $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
           ResponseHeaderBag::DISPOSITION_ATTACHMENT,
           'qr_code.png'
       ));
  
  
      return $response;
  }   
  

}
?>