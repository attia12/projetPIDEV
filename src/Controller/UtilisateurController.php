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
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Google;
use App\Form\UserType;
use App\Form\InscriptionType;
use Twig\Environment;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\LoginType;

class UtilisateurController extends AbstractController
{
    private $provider;
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
        $file = $form->get('Img')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move('C:\Users\user\Desktop\3eme\PI\Web\public\assets\img\upload',$fileName);
        
        $Utilisateur->setImg("assets/img/upload/".$fileName);
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
        $file = $form->get('Img')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move('C:\Users\user\Desktop\3eme\PI\Web\public\assets\img\upload',$fileName);
        
        $Utilisateur->setImg("assets/img/upload/".$fileName);
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
    #[Route('/incrit', name: 'app_inscrit')]
    public function inscription(SessionInterface $session,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request)
    {
        $Utilisateur = new Utilisateur();
        $form= $this->createForm(InscriptionType::class,$Utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $form->get('Img')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move('C:\Users\user\Desktop\3eme\PI\Web\public\assets\img\upload',$fileName);
            
            $Utilisateur->setImg("assets/img/upload/".$fileName);

            $em= $doctrine->getManager();
            $em->persist($Utilisateur);
            $em->flush();
            return  $this->redirectToRoute("app_acceuil");
        }
        
        return $this->render('/utilisateur/inscription.html.twig',array("form"=>$form->createView()));
        }
    #[Route('/acceuil', name: 'app_acceuil')]
    public function front()
    {
       
        return $this->render('front.html.twig');
      
        }
        
        #[Route('/acceuil_logged', name: 'app_acceuil_logged')]
        public function front_logged(SessionInterface $session,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request)
        {
            $myValue = $session->get('my_key')->getId();
        $u=$x->find($myValue);
            return $this->render('utilisateur/acceuil.html.twig',array("user"=>$u));
          
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
            if ($Utilisateur->getEmail()==$check_u[0]->getEmail()&& $Utilisateur->getMdp()==$check_u[0]->getMdp() && $check_u[0]->getType()=="Admin")
            return $this->redirectToRoute("app_utilisateur");
else
return $this->render('utilisateur/login.html.twig',array("form"=>$form->createView()));
        }
        return $this->render('utilisateur/login.html.twig',array("form"=>$form->createView()));

    }
    #[Route('/login_front', name: 'app_login_front')]

    public function Login_front(ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $x,SessionInterface $session):Response
    {
        $Utilisateur= new Utilisateur();
        $check_u= new Utilisateur();
        $form= $this->createForm(LoginType::class,$Utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $Utilisateur=$form->getdata();
            $check_u=$x->findByExampleField($Utilisateur->getEmail());
           $session->set('my_key',$check_u[0]);
            if ($Utilisateur->getEmail()==$check_u[0]->getEmail()&& $Utilisateur->getMdp()==$check_u[0]->getMdp() && $check_u[0]->getType()!="Admin")
            return $this->redirectToRoute("app_acceuil_logged");
else
return $this->render('utilisateur/login_front.html.twig',array("form"=>$form->createView()));
        }
        return $this->render('utilisateur/login_front.html.twig',array("form"=>$form->createView()));

    }

    #[Route('/consult_user', name: 'app_consult_user')]
    public function consult_user(SessionInterface $session,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request)
    {
        $myValue = $session->get('my_key')->getId();
        $u=$x->find($myValue);
        $Utilisateur= new Utilisateur();
        $form= $this->createForm(UserFormType::class,$Utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $Utilisateur1=$form->getdata();
            $u->setNom($Utilisateur1->getNom());
            $u->setPrenom($Utilisateur1->getPrenom());
            $u->setMdp($Utilisateur1->getMdp());
            $u->setEmail($Utilisateur1->getEmail());
            $u->setType($Utilisateur1->getType());
            $u->setAdresse($Utilisateur1->getAdresse());
            $u->setNum($Utilisateur1->getNum());
            $file = $form->get('Img')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move('C:\Users\user\Desktop\3eme\PI\Web\public\assets\img\upload',$fileName);
        
        $u->setImg("assets/img/upload/".$fileName);
            $em= $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_consult_user");}
        return $this->render('/utilisateur/consult_user.html.twig',array("user"=>$u,"form"=>$form->CreateView()));



        }


//API FB


public function __construct()
{
   $this->provider=new Google([
     'clientId'          => $_ENV['Google_ID'],
     'clientSecret'      => $_ENV['Google_SECRET'],
     'redirectUri'       => $_ENV['Google_CALLBACK'],
     'graphApiVersion'   => 'v15.0',
 ]);
}

 #[Route('/fcb-login', name: 'fcb_login')]
    public function ggleLogin(): Response
    {
         
        $helper_url=$this->provider->getAuthorizationUrl();

        return $this->redirect($helper_url);
    }


    #[Route('/fcb-callback', name: 'fcb_callback')]
    public function ggleCallBack(UtilisateurRepository $userDb,SessionInterface $session, ManagerRegistry  $doctrine)
    {
       //Récupérer le token
       $token = $this->provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
        ]);

    
           //Récupérer les informations de l'utilisateur

           $user=$this->provider->getResourceOwner($token);

           $user=$user->toArray();

           

           

           //Vérifier si l'utilisateur existe dans la base des données

           $Utilisateur=$userDb->findOneByEmail($user['email']);

           if($Utilisateur)
           {
                
            $session->set('my_key',$Utilisateur);
            return $this->redirectToRoute("app_acceuil_logged");


           }

           else
           {
               $new_user=new Utilisateur();
$new_user->setNom($user['given_name']);
$new_user->setPrenom($user['family_name']);
$new_user->setEmail($user['email']);
$new_user->setImg($user['picture']);
$new_user->setAdresse("Megrine");
$new_user->setType("Medecin");
$new_user->setNum(0000);
$new_user->setMdp(sha1(str_shuffle('abscdop123390hHHH;:::OOOI')));
               
              
$em= $doctrine->getManager();
$em->persist($new_user);
$em->flush();
$session->set('my_key',$new_user);

return $this->redirectToRoute("app_acceuil_logged");


           }


       


    }





















}

