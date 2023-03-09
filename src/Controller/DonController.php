<?php

namespace App\Controller;

use App\Entity\Don;
use App\Form\DonType;
use App\Repository\DonRepository;
use App\Repository\CategorieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
#[Route('/don')]
class DonController extends AbstractController
{
    


    #[Route('/', name: 'app_don_index')]
    public function index(SessionInterface $session,DonRepository $donRepository,Request $request,SluggerInterface $slugger): Response
    {$u = $session->get('my_key');
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

            return $this->redirectToRoute('app_don_index');
        }







        return $this->render('don/index.html.twig', array('dons' => $donRepository->findAll(),'form' => $form->CreateView(),"user"=>$u));
    }

    #[Route('/statisreclamation', name: 'app_reclamation_statisreclamation', methods: ['GET'])]
public function statisreclamation(SessionInterface $session,DonRepository $donRepository)
{$u = $session->get('my_key');
    //on va chercher les categories
    $rech = $donRepository->barDep();
    $arr = $donRepository->barArr();
    
    $bar = new barChart ();
    $bar->getData()->setArrayToDataTable(
        [['don', 'Type'],
         ['Collecte des déchets', intVal($rech)],
         ['Éclairage public', intVal($arr)],
        

        ]
    );

    $bar->getOptions()->setTitle('les Dons');
    $bar->getOptions()->getHAxis()->setTitle('Nombre de don');
    $bar->getOptions()->getHAxis()->setMinValue(0);
    $bar->getOptions()->getVAxis()->setTitle('Type');
    $bar->getOptions()->SetWidth(800);
    $bar->getOptions()->SetHeight(400);


    return $this->render('Don/statisDon.html.twig', array('bar'=> $bar ,"user"=>$u)); 

}

    #[Route('/new', name: 'app_don_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, DonRepository $donRepository,SluggerInterface $slugger): Response
    {$u = $session->get('my_key');
        $don = new Don();
        $form = $this->createForm(DonType::class, $don);
        $form->remove('id_ben');
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $photo = $form->get('imge')->getData();
$don->setIdBen($u->getId());
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

            return $this->redirectToRoute('app_don_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('don/new.html.twig', [
            'don' => $don,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}', name: 'app_don_show', methods: ['GET'])]
    public function show(SessionInterface $session,Don $don): Response
    {$u = $session->get('my_key');
        return $this->render('don/show.html.twig', [
            'don' => $don,
            "user"=>$u,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_don_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Don $don, DonRepository $donRepository): Response
    {$u = $session->get('my_key');
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donRepository->save($don, true);

            return $this->redirectToRoute('app_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('don/edit.html.twig', [
            'don' => $don,
            'form' => $form,
            "user"=>$u,
        ]);
    }

    #[Route('/remove/{id}', name: 'app_don_delete')]
    public function delete(SessionInterface $session,Request $request, Don $don, DonRepository $donRepository): Response
    {$u = $session->get('my_key');
       
            $donRepository->remove($don, true);
        

        return $this->redirectToRoute('app_don_index');
    }

    /**
     * @Route("/statis", name="app_stattttt")
     */
    public function statsParType(EntityManagerInterface $entityManager): Response
    {$u = $session->get('my_key');
        // Récupération des statistiques des offres par type
        $stats = $entityManager->createQuery(
            'SELECT t.nom AS categorie, COUNT(o.id) AS nbdon
             FROM Don o
             JOIN o.Categorie t
             GROUP BY t.nom'
        )->getResult();

        // Retourne une vue Twig avec les statistiques des offres par type
        return $this->render('don/statistique.html.twig', [
            'stats' => $stats,
            "user"=>$u,
        ]);
    }
    
////////////////////////json  pour mobile///////////////////////////////////////////////////


    #[Route('/affichage/mobile', name: 'app_don_allApp')]
    public function allApp(SessionInterface $session,DonRepository $donRepository,SerializerInterface $s){
        $x=$donRepository->findAll();
        $u = $session->get('my_key');
        $json=$s->serialize($x,'json',['groups'=>"dons"]);
        return new Response($json);
     
    }
    #[Route('/ajout/mobile', name: 'app_don_ajoutApp')]
    public function AjoutMobil(Request $req,NormalizerInterface $s,ManagerRegistry $doctrine){
        $u = $session->get('my_key');
        $em = $doctrine->getManager();
        $don=new Don();
        $don->setIdBen($req->get('id_ben'));
        $don->setTitre($req->get('titre'));
        $don->setQte($req->get('qte'));
        $don->setType($req->get('type'));
        $don->setDate($req->get('date'));
        $don->setIdLocal($req->get('id_local'));
        $don->setImge($req->get('imge'));
        $em -> persist($don);
        $em->flush();
        $json=$s->normalize($don,'json',['groups'=>"dons"]);
        return new Response(json_encode($json));
     
    }

    #[Route('/Update/mobile/{id}', name: 'app_don_editApp')]
    public function UpdateMobile(SessionInterface $session,Request $req,$id,NormalizerInterface $s,ManagerRegistry $doctrine){
        $u = $session->get('my_key');
        $em = $doctrine->getManager();
        $don=$em->getRepository(Don::class)->find($id);
        $don->setIdBen($req->get('id_ben'));
        $don->setTitre($req->get('titre'));
        $don->setQte($req->get('qte'));
        $don->setType($req->get('type'));
        $don->setDate($req->get('date'));
        $don->setIdLocal($req->get('id_local'));
        $don->setImge($req->get('imge'));
        $em->flush();
        $json=$s->normalize($don,'json',['groups'=>"dons"]);
        return new Response(" don updated successfully".json_encode($json));
     
    }


    #[Route('/delete/mobile/{id}', name: 'app__deleteApp')]
    public function deleteMobile(SessionInterface $session,$id,NormalizerInterface $s,ManagerRegistry $doctrine)
    {
        $u = $session->get('my_key');
        $em = $doctrine->getManager();
        $don=$em->getRepository(Don::class)->find($id);
        $em->remove($don);
        
        
        $em->flush();

        $json=$s->normalize($don,'json',['groups'=>"dons"]);
        return new Response(" don deleted successfully".json_encode($json));
     
    }
    #[Route('/stat/stat', name: 'app_don_stat', methods: ['GET'])]
    public function yourAction(SessionInterface $session,DonRepository $c)
    {
        $u = $session->get('my_key');
        $total=0;
        $tot_50=0;
        $tot_100=0;
        $tot_200=0;
        $consultations = $c->findAll();
        foreach ($consultations as $consultation) {
            if ($consultation->getQte()<50) {
                $tot_50++;
            } else if ($consultation->getQte()>50&&$consultation->getQte()<200) {
                $tot_100++;
            } else if ($consultation->getQte()>200){
                $tot_200++;
            }
            $total++;
        }
$pour_50=($tot_50*100)/$total; 
$pour_100=($tot_100*100)/$total; 
$pour_200=($tot_200*100)/$total;  

$data = array(
    '<50' => $pour_50,
    '>50 et <200' => $pour_100,
    '>200' => $pour_200
);
        return $this->render('/don/stat.html.twig', [
            'data' => $data,
            'user'=>$u,
        ]);
    }

}
