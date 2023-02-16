<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use App\Form\UserFormType;
use App\Form\UserType;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\LoginType;

class UtilisateurController extends AbstractController
{
    private $u;
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(SessionInterface $session,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request): Response
    {
        $myValue = $session->get('my_key')->getId();
        $u=$x->find($myValue);
        
        $formations=$x->findAll();
        $Utilisateur= new Utilisateur();
$check=0;
    $form= $this->createForm(UserFormType::class,$Utilisateur);
    $form->handleRequest($request);
   

    if ($form->isSubmitted() && $form->isValid()){
    

        $em= $doctrine->getManager();
        $em->persist($Utilisateur);
        $em->flush();
        return  $this->redirectToRoute("app_utilisateur");
    }
        return $this->render('utilisateur/index.html.twig', array("tab"=>$formations,"formUtilisateur"=>$form->createView(),"user"=>$u));
    }
    #[Route('/update/{id}', name: 'app')]

    public function updateClub(SessionInterface $session,$id,ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $repository):Response
    {
        $Utilisateur= new Utilisateur();
        $form= $this->createForm(UserFormType::class,$Utilisateur);
    $form->handleRequest($request);
    $myValue = $session->get('my_key')->getId();
    $u=$repository->find($myValue);
    
    
        $Utilisateur= $repository->find($id);
        
        

        
        if ($form->isSubmitted() && $form->isValid()){
        $Utilisateur1=$form->getdata();
        $Utilisateur->setNom($Utilisateur1->getNom());
        $Utilisateur->setPrenom($Utilisateur1->getPrenom());
        $Utilisateur->setMdp($Utilisateur1->getMdp());
        $Utilisateur->setEmail($Utilisateur1->getEmail());
        $Utilisateur->setType($Utilisateur1->getType());
        $Utilisateur->setAdresse($Utilisateur1->getAdresse());
        $Utilisateur->setNum($Utilisateur1->getNum());
        $em= $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute("app_utilisateur");}
        return $this->render('utilisateur/update.html.twig', array("formUtilisateur"=>$form->createView(),"user"=>$u));

    }

    #[Route('/User/{id}', name: 'app_addStudent')]
public function addStudent(ManagerRegistry $doctrine,UtilisateurRepository $repository,$id)
{
   

    $Utilisateur1=$repository->find($id);
    $em= $doctrine->getManager();
    $em->remove($Utilisateur1);
    $em->flush();
    return  $this->redirectToRoute("app_utilisateur");
    }
    

    

    
    #[Route('/login', name: 'app_updateStudent')]

    public function Login(ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $x,SessionInterface $session):Response
    {
        $Utilisateur= new Utilisateur();
        $check_u= new Utilisateur();
        $form= $this->createForm(LoginType::class,$Utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $Utilisateur=$form->getdata();
            $check_u=$x->findByExampleField($Utilisateur->getEmail());
           $session->set('my_key',$check_u[0]);
            if ($Utilisateur->getEmail()==$check_u[0]->getEmail()&& $Utilisateur->getMdp()==$check_u[0]->getMdp())
            return $this->redirectToRoute("app_utilisateur");
else
return $this->render('utilisateur/login.html.twig',array("form"=>$form->createView()));
        }
        return $this->render('utilisateur/login.html.twig',array("form"=>$form->createView()));

    }




}

