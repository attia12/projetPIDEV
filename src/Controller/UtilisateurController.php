<?php

namespace App\Controller;

use Nexmo\Client;


use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Utilisateur;
use Symfony\Component\Mime\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\UserFormType;
use App\Form\EmailType;
use App\Form\MdpType;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Google;
use App\Form\UserType;
use App\Form\InscriptionType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\LoginType;

class UtilisateurController extends AbstractController
{
    private $provider;
    private $providerr;
    private $u;
    private $emm;
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
    #[Route('/update/{id}', name: 'app_UpdateUser')]

    public function updateUser(SessionInterface $session,$id,ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $repository):Response
    {
        $Utilisateur= new Utilisateur();
        $form= $this->createForm(UserFormType::class,$Utilisateur);
    $form->handleRequest($request);
    $myValue = $session->get('my_key')->getId();
    $u=$repository->find($myValue);
    
    
        $Utilisateur= $repository->find($id);
        
       // $form->get('nom')->setdata($Utilisateur->getNom());

        
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

    #[Route('/User/{id}', name: 'app_RemoveUser')]
public function SuppUser(ManagerRegistry $doctrine,UtilisateurRepository $repository,$id)
{
   

    $Utilisateur1=$repository->find($id);
    $em= $doctrine->getManager();
    $em->remove($Utilisateur1);
    $em->flush();
    return  $this->redirectToRoute("app_utilisateur");
    }

    #[Route('/Bloque/{id}', name: 'app_BloqueUser')]
    public function BloqueUser(ManagerRegistry $doctrine,UtilisateurRepository $repository,$id)
    {
       
    
        $Utilisateur1=$repository->find($id);
        $Utilisateur1->setEtat(0);
        $em= $doctrine->getManager();
        
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
$Utilisateur->setEtat(0);
$session->set('my_key',$Utilisateur);
            $em= $doctrine->getManager();
            $em->persist($Utilisateur);
            $em->flush();
            $transport = Transport::fromDsn('smtp://sa7etnaa@gmail.com:xalnuexawgowijsy@smtp.gmail.com:587?verify_peer=0');
        $mailer = new Mailer($transport);
        $us=$x->findOneByEmail($Utilisateur->getEmail()); 
        { 
         {$email = (new Email());
            $email->from('Sa7etnaa@esprit.tn');
            $email->to(new Address($us->getEmail()));
            
            $email->subject('Activation de votre compte');
           // ->text('Sending emails is fun again!')
         $email->html('<h3>Bonjour '.$us->getNom().' '.$us->getPrenom().'</h3><p>
         a fin de activer le compte de ce mail:
     <code>'.$us->getEmail().'</code></p>
     <p>
     <a href="http://127.0.0.1:8000/Activation">Clicker ici pour Activer votre compte </a></p><h4>Adminstrateur Sa7etna</h4>');
          // $email->addPart((new DataPart(new File('/assetss/img/logo.png'), 'footer-signature', 'image/gif'))->asInline());
       
          
         
    
        $mailer->send($email);
            
            return  $this->render('/utilisateur/act_req.html.twig');
        }}
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
          if (isset($check_u[0])){
            if ($Utilisateur->getEmail()==$check_u[0]->getEmail()&& $Utilisateur->getMdp()==$check_u[0]->getMdp() && $check_u[0]->getType()=="Admin")
            {
                $session->set('my_key',$check_u[0]);
                return $this->redirectToRoute("app_utilisateur");}
else
return $this->render('utilisateur/login.html.twig',array("form"=>$form->createView()));}
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
          if(isset($check_u[0])){
            if ($Utilisateur->getEmail()==$check_u[0]->getEmail()&& $Utilisateur->getMdp()==$check_u[0]->getMdp() && $check_u[0]->getType()!="Admin"&& $check_u[0]->getEtat()!=0)
           { 
            $session->set('my_key',$check_u[0]);
            return $this->redirectToRoute("app_acceuil_logged");}
else
return $this->render('utilisateur/login_front.html.twig',array("form"=>$form->createView()));}
        }
        return $this->render('utilisateur/login_front.html.twig',array("form"=>$form->createView()));

    }

    #[Route('/consult_user', name: 'app_consult_user')]
    public function consult_user(SessionInterface $session,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request)
    {
        $myValue = $session->get('my_key')->getId();
        $u=$x->find($myValue);
      
        $Utilisateur= new Utilisateur();
        $form= $this->createForm(InscriptionType::class,$Utilisateur);
   
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
$new_user->setEtat(1);     
              
$em= $doctrine->getManager();
$em->persist($new_user);
$em->flush();
$session->set('my_key',$new_user);

return $this->redirectToRoute("app_acceuil_logged");


           }


       


    }

//mdp oublie

    #[Route('/forget_pass', name: 'app_mdp_oublie')]
    public function Mdp_page(ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $x,SessionInterface $session) 
    {
         $u= new Utilisateur();
         $form= $this->createForm(EmailType::class);
         $form->handleRequest($request);
        if ($form->isSubmitted()){
            
            $u=$form->getdata();   
            $session->set('u',$u);
            
            return $this->redirectToRoute("app_email");
        
        
        
        }
        
        return $this->render('/utilisateur/forget_pass.html.twig',array("form"=>$form->CreateView()));
    }



    #[Route('/forget', name: 'app_mdp')]
    public function Mdpp_page(ManagerRegistry  $doctrine,Request $request,UtilisateurRepository  $x,SessionInterface $session) 
    {
         
        $form= $this->createForm(MdpType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $myValue = $session->get('u')->getEmail();
            $us=$x->findOneByEmail($myValue);  
        $user=$form->getdata();
        
    $us->setMdp($user->getMdp());

    $em= $doctrine->getManager();
    $em->flush();

            return $this->redirectToRoute("app_login_front");
        
        
        
        
        }
        return $this->render('/utilisateur/pass_forgot.html.twig',array("form"=>$form->CreateView()));
    }


    #[Route('/email',name: 'app_email')]
    public function sendEmail(SessionInterface $session,UtilisateurRepository  $x)
    {
        $transport = Transport::fromDsn('smtp://sa7etnaa@gmail.com:xalnuexawgowijsy@smtp.gmail.com:587?verify_peer=0');
        $mailer = new Mailer($transport);
        $us=$x->findOneByEmail($session->get('u')->getEmail()); 
        if (isset($us)){ 
        try {$email = (new Email());
            $email->from('Sa7etnaa@esprit.tn');
            $email->to(new Address($session->get('u')->getEmail()));
            
            $email->subject('Réinitialiser de mot de passe');
           // ->text('Sending emails is fun again!')
         $email->html('<h3>Bonjour '.$us->getNom().' '.$us->getPrenom().'</h3><p>
         Vous avez demandez de réinitialiser votre mot de passe pour the email suivant:
     <code>'.$session->get('u')->getEmail().'</code></p>
     <p>
     <a href="http://127.0.0.1:8000/forget">Clicker ici pour réinitialiser votre mot de passe </a></p><h4>Adminstrateur Sa7etna</h4>');
          // $email->addPart((new DataPart(new File('/assetss/img/logo.png'), 'footer-signature', 'image/gif'))->asInline());
       
          
         
    
        $mailer->send($email);
       
        

        return $this->redirectToRoute("app_login_front");}
     catch (\Throwable $exception) {
        return $this->render('bas.html.twig', [
            'message' => 'An error occurred while sending the email: '.$exception->getMessage(),
        ]);}}
    
    }

    #[Route('/Activation',name: 'app_Activation')]
    public function Activation(SessionInterface $session,UtilisateurRepository  $x,ManagerRegistry  $doctrine)
    {
        
        $us=$x->findOneByEmail($session->get('my_key')->getEmail()); 
        $us->setEtat(1);
        $em= $doctrine->getManager();
    $em->flush();
        return $this->redirectToRoute("app_acceuil_logged");
    }
  









///////////////// mobile/////////////////////////////



#[Route('/utilisateur_afficher', name: 'app_utilisateur_afficher')]
public function Affichage_mobile(SerializerInterface $s,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $request): Response
{
    
    
    
    $users=$x->findAll();
    

    $json = $s->serialize($users,'json',['groups'=>"users"]);
return new Response($json);
  
}

#[Route('/utilisateur_ajouter/new', name: 'app_utilisateur_ajouter')]
public function Ajouter_mobile(NormalizerInterface $n,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req): Response
{
    
    
    
$em=$doctrine->getManager();
    $user = new Utilisateur();
    $user->setNom($req->get('nom'));
    $user->setPrenom($req->get('prenom'));
    $user->setEmail($req->get('email'));
    $user->setMdp($req->get('mdp'));
    $user->setType($req->get('type'));
    $user->setNum($req->get('num'));
    $user->setAdresse($req->get('adresse'));
    $user->setImg("Null");
    $em->persist($user);
    $em->flush();
    $json = $n->normalize($user,'json',['groups'=>"users"]);
return new Response(json_encode($json));
  
}

#[Route('/utilisateur_update/{id}', name: 'app_utilisateur_update_mobile')]
public function Update_mobile(NormalizerInterface $n,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req,$id): Response
{
    
    
    
$em=$doctrine->getManager();
    $user = new Utilisateur();
    $user =$x->find($id);
    $user->setNom($req->get('nom'));
    $user->setPrenom($req->get('prenom'));
    $user->setEmail($req->get('email'));
    $user->setMdp($req->get('mdp'));
    $user->setType($req->get('type'));
    $user->setNum($req->get('num'));
    $user->setAdresse($req->get('adresse'));
    $user->setImg("Null");
 
    $em->flush();
    $json = $n->normalize($user,'json',['groups'=>"users"]);
return new Response("Utilisateur mise à jour avec succes".json_encode($json));
  
}
#[Route('/utilisateur_supp/{id}', name: 'app_utilisateur_supp_mobile')]
public function supp_mobile(NormalizerInterface $n,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req,$id): Response
{
    
    
    
$em=$doctrine->getManager();
    $user = new Utilisateur();
    $user =$x->find($id);
    $em->remove($user);
 
    $em->flush();
    $json = $n->normalize($user,'json',['groups'=>"users"]);
return new Response("Utilisateur supprimer avec succes".json_encode($json));
  
}
#[Route('/utilisateur_login_admin', name: 'app_utilisateur_login_admin')]
public function login_admin_mobile(SessionInterface $session,SerializerInterface $s,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req): Response
{
    
    $email=$req->get('email');
    $mdp=$req->get('mdp');
    $user=$x->findByExampleField($email);
    if (isset($user))
    {
if($user[0]->getMdp()==$mdp)
{
    $session->set('my_key',$user);
}
else $session->set('my_key',"Null");
    }
    
    

    $json = $s->serialize($session->get('my_key'),'json',['groups'=>"users"]);
return new Response($json);
  
}

#[Route('/utilisateur_login', name: 'app_utilisateur_login')]
public function login_mobile(SessionInterface $session,SerializerInterface $s,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req): Response
{
    
    $email=$req->get('email');
    $mdp=$req->get('mdp');
    $user=$x->findByExampleField($email);
    if (isset($user))
    {
if($user[0]->getMdp()==$mdp&&$user[0]->getType()!="Admin")
{
    $session->set('my_key',$user);
}
else $session->set('my_key',"Null");
    }
    
    

    $json = $s->serialize($session->get('my_key'),'json',['groups'=>"users"]);
return new Response($json);
  
}

#[Route('/utilisateur_recherche/{id}', name: 'app_utilisateur_recherche')]
public function recherche_mobile($id,SessionInterface $session,SerializerInterface $s,UtilisateurRepository $x,ManagerRegistry  $doctrine,Request $req): Response
{
    
    
    $user=$x->find($id);
    
    
    

    $json = $s->serialize($user,'json',['groups'=>"users"]);
return new Response($json);
  
}

#[Route('/email_mobile',name: 'app_email')]
    public function sendEmail_mobile(NormalizerInterface $n,SessionInterface $session,UtilisateurRepository  $x,Request $req)
    {
        $transport = Transport::fromDsn('smtp://sa7etnaa@gmail.com:xalnuexawgowijsy@smtp.gmail.com:587?verify_peer=0');
        $mailer = new Mailer($transport);
        $us=$x->findOneByEmail($req->get('email')); 
        if (isset($us)){ 
        try {$email = (new Email());
            $email->from('Sa7etnaa@esprit.tn');
            $email->to(new Address($req->get('email')));
            
            $email->subject('[Important] Mot de passe');
           // ->text('Sending emails is fun again!')
         $email->html('<h3>Bonjour '.$us->getNom().' '.$us->getPrenom().'</h3><p>
         Vous avez demandez de obtenir votre mot de passe pour email suivant:
     <code>'.$us->getEmail().'</code></p>
     <p>Mot de pass : '.$us->getMdp().' </p>
     <h4>Adminstrateur Sa7etna</h4>');
          // $email->addPart((new DataPart(new File('/assetss/img/logo.png'), 'footer-signature', 'image/gif'))->asInline());
       
          
         
    
        $mailer->send($email);
       
        $json = $n->normalize($us,'json',['groups'=>"users"]);
return new Response("Email envoyer avec success".json_encode($json));

        }
     catch (\Throwable $exception) {
        return $this->render('bas.html.twig', [
            'message' => 'An error occurred while sending the email: '.$exception->getMessage(),
        ]);}}
    
    }

   
    
    #[Route('/fcb-login-json', name: 'fcb_login_json')]
    public function ggleeLogin(SerializerInterface $s): Response
    { 
        $this->providerr=new Google([
            'clientId'          => $_ENV['G_ID'],
            'clientSecret'      => $_ENV['G_SECRET'],
            'redirectUri'       => $_ENV['G_CALLBACK'],
            'graphApiVersion'   => 'v15.0',
          ]);
        $helper_url=$this->providerr->getAuthorizationUrl();
    
        // Return a JSON response
        
        $json = $s->serialize($helper_url,'json',['groups'=>"users"]);
        return new Response($json);
    }
    
    
    #[Route('/fcb-callback-json', name: 'fcb_callback_json')]
    public function ggleeCallBack(UtilisateurRepository $userDb,SessionInterface $session, ManagerRegistry  $doctrine,SerializerInterface $s)
    {
        $this->providerr=new Google([
            'clientId'          => $_ENV['G_ID'],
            'clientSecret'      => $_ENV['G_SECRET'],
            'redirectUri'       => $_ENV['G_CALLBACK'],
            'graphApiVersion'   => 'v15.0',
          ]);
        //Récupérer le token
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    
        //Récupérer les informations de l'utilisateur
        $user=$this->provider->getResourceOwner($token);
        $user=$user->toArray();
        $json = $s->serialize($user,'json',['groups'=>"users"]);
        return new Response($json);
    /*
        //Vérifier si l'utilisateur existe dans la base des données
        $Utilisateur=$userDb->findOneByEmail($user['email']);
        if($Utilisateur) {
            $session->set('my_key',$Utilisateur);
    
            // Return a JSON response
            $response = [
                'success' => true,
                'redirectUrl' => $this->generateUrl("app_acceuil_logged")
            ];
            return new JsonResponse($response);
        } else {
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
    
            // Return a JSON response
            $response = [
                'success' => true,
                'redirectUrl' => $this->generateUrl("app_acceuil_logged")
            ];
            return new JsonResponse($response);
        }*/





    }
    






}

?>