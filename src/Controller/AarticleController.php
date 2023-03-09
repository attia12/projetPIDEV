<?php

namespace App\Controller;
use App\Entity\Like;
use Endroid\QrCode\QrCode;
use Dompdf\Dompdf;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\ComentRepository;
use App\Entity\Aarticle;
use App\Form\AarticleType;
use App\Repository\AarticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RatingType;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Seria1izer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Seria1izer\Seria1izerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use GuzzleHttp\Client;
use App\Entity\Reports;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\HttpFoundation\StreamedResponse;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
#[Route('/aarticle')]
class AarticleController extends AbstractController
{
    private $translator;
  
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    
    #[Route('/', name: 'app_aarticle_index', methods: ['GET'])]
    public function index(AarticleRepository $aarticleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $sortBy = $request->query->get('sortBy');
        
        if ($sortBy == 'title') {
            $query = $aarticleRepository->createQueryBuilder('a')
                ->orderBy('a.title', 'ASC')
                ->getQuery();
        } else {
            $query = $aarticleRepository->createQueryBuilder('a')
                ->getQuery();
        }
        
      // Utiliser le Paginator pour paginer les résultats
    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        10
    );
    

 // Créer le formulaire de recherche
 $form = $this->createForm(AarticleType::class);

 // Gérer la soumission du formulaire de recherche
 $form->handleRequest($request);
 if ($form->isSubmitted() && $form->isValid()) {
    
     $searchTerm = $form->getData()['searchTerm'];

     // Rechercher les articles selon le terme de recherche
     $aarticles = $this->getDoctrine()
         ->getRepository(Aarticle::class)
         ->findByTitle($searchTerm);
 } else {
     // Récupérer tous les articles
     $aarticles = $this->getDoctrine()
         ->getRepository(Aarticle::class)
         ->findAll();
 }

 // Afficher la page index avec les articles trouvés
 return $this->render('aarticle/index.html.twig', [
    'pagination' => $pagination,
     'aarticles' => $aarticles,
     'searchForm' => $form->createView(),
 ]);



    }

    #[Route('/new', name: 'app_aarticle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AarticleRepository $aarticleRepository): Response
    {
        $aarticle = new Aarticle();
        $form = $this->createForm(AarticleType::class, $aarticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aarticleRepository->save($aarticle, true);

            return $this->redirectToRoute('app_aarticle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aarticle/new.html.twig', [
            'aarticle' => $aarticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aarticle_show', methods: ['GET', 'POST'])]
public function show(Aarticle $aarticle, ComentRepository $comentRepository, Request $request, EntityManagerInterface $entityManager,PaginatorInterface $paginator): Response
{ 


    $likes = $aarticle->getLikes();
    $dislikes = $aarticle->getDislikes();
    $comments = $comentRepository->findBy(['id_article' => $aarticle->getId()]);
    $pagination = $paginator->paginate(
        $comments,
        $request->query->getInt('page', 1),
        10 // Number of items per page
    );
   
    $rating = new Rating();
    $form = $this->createForm(RatingType::class, $rating);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer la note depuis le formulaire
        $note = $form->get('note')->getData();

        // Enregistrer la note dans la base de données
        $rating->setArticleId($aarticle);
        $rating->setNote($note);
        $entityManager->persist($rating);
        $entityManager->flush();

        // Rediriger vers la page actuelle pour éviter la resoumission du formulaire
        return $this->redirectToRoute('app_aarticle_show', ['id' => $aarticle->getId()]);
        $client = new Client();

// Récupérer le titre et la description de l'article
$title = $aarticle->getTitle();
$description = $aarticle->getDescription();


// Appeler l'API de Google Translate pour traduire le titre et la description en anglais
$response = $client->post('https://translation.googleapis.com/language/translate/v2', [
    'form_params' => [
        'q' => [$title, $description],
        'target' => 'en',
        'format' => 'text',
        'source' => 'fr',
        'key' => 'AIzaSyBd0MRfVbQT80Ow7x4mTSlsv9NiaSryI2E', // Remplacer par votre clé d'API Google Translate
    ],
]);

// Récupérer les traductions à partir de la réponse JSON
$translations = json_decode((string) $response->getBody(), true)['data']['translations'];

// Mettre à jour le titre et la description de l'article avec les traductions
$aarticle->setTitle($translations[0]['translatedText']);
$aarticle->setDescription($translations[1]['translatedText']);
    }

    return $this->render('aarticle/show.html.twig', [
        'aarticle' => $aarticle,
        'comments' => $comments,
        'pagination' => $pagination,
        'likes' => $likes,
        'dislikes' => $dislikes,
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}/edit', name: 'app_aarticle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aarticle $aarticle, AarticleRepository $aarticleRepository): Response
    {
        $form = $this->createForm(AarticleType::class, $aarticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aarticleRepository->save($aarticle, true);

            return $this->redirectToRoute('app_aarticle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aarticle/edit.html.twig', [
            'aarticle' => $aarticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aarticle_delete', methods: ['POST'])]
    public function delete(Request $request, Aarticle $aarticle, AarticleRepository $aarticleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aarticle->getId(), $request->request->get('_token'))) {
            $aarticleRepository->remove($aarticle, true);
        }

        return $this->redirectToRoute('app_aarticle_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/{id}/report', name: 'app_aarticle_report', methods: ['POST'])]
    public function reportAarticle(Request $request, Aarticle $aarticle): Response
    {
        
        $report = new Reports();
        $report->setMessage($message);
        $report->setIdAarticle($aarticle);
        $report->setMessage($request->request->get('message'));
        $entityManager->persist($report);
        $entityManager->flush();
        
        $aarticle->setReportCount($aarticle->getReportCount() + 1);
        $entityManager->persist($aarticle);
        $entityManager->flush();
        return $this->redirectToRoute('app_aarticle_show', ['id' => $aarticle->getId()]);
    }
    #[Route('/{id}/reports', name: 'app_aarticle_report', methods: ['GET', 'POST'])]
    public function reports(Request $request, Aarticle $aarticle): Response
{
    $reports = new Reports();
    $reports->setIdAarticle($aarticle);

    

    $entityManager = $this->getDoctrine()->getManager();

    $form = $this->createFormBuilder($reports)
        ->add('message', TextareaType::class, [
            'label' => 'Message',
            'required' => true,
            'attr' => [
                'placeholder' => 'Décrivez le problème rencontré avec cet article'
            ]
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($reports);
        $entityManager->flush();
    
        $aarticle->setReportsCount($aarticle->getReportsCount() + 1);
        $entityManager->persist($aarticle);
        $entityManager->flush();
    
        $this->addFlash('success', 'L\'article a été signalé avec succès.');
    
        return $this->redirectToRoute('app_aarticle_show', ['id' => $aarticle->getId()]);
    }

    return $this->renderForm('aarticle/report.html.twig', [
        'aarticle' => $aarticle,
        'form' => $form,
    ]);
}

/**
 * @return float|null
 */
public function getAverageRating(): ?float
{
    $totalRating = 0;
    $numberOfRatings = 0;
    foreach ($this->ratings as $rating) {
        $totalRating += $rating->getValue();
        $numberOfRatings++;
    }
    if ($numberOfRatings === 0) {
        return null;
    }
    return $totalRating / $numberOfRatings;
}






public function rateAarticle(Request $request, Aarticle $aarticle, int $rating)
{
    $aarticle->addRating($rating);
    $entityManager->flush();

    $averageRating = $aarticle->getAverageRating();
    $response = new Response(json_encode(['averageRating' => $averageRating]));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
}

#[Route('/{id}/dislike', name: 'app_aarticle_dislike', methods: ['POST'])]
public function dislike(Aarticle $aarticle): Response
{
    $aarticle->setDislikes($aarticle->getDislikes() + 1);
    $this->getDoctrine()->getManager()->flush();

    return new JsonResponse(['dislikes' => $aarticle->getDislikes]);

}






/**
 * @Route("/aarticle/{id}/like", name="like_aarticle", methods={"POST"})
 */
public function likeAarticle(Request $request, Aarticle $aarticle): JsonResponse
{
    $type = $request->request->get('type');
    
    if ($type === 'like') {
        $aarticle->addLike();
    } elseif ($type === 'dislike') {
        $aarticle->addDislike();
    } else {
        return new JsonResponse(['success' => false]);
    }
    
    $this->getDoctrine()->getManager()->flush();
    
    return new JsonResponse([
        'success' => true,
        'likes' => $aarticle->getLikes(),
        'dislikes' => $aarticle->getDislikes(),
    ]);
}


 /**
     * @Route("/like/{id}", name="like_add", methods={"POST"})
     */
    public function add(Request $request, Aarticle $aarticle): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $like = new Like();
        $like->setAarticle($aarticle);
        $like->setIpAddress($request->getClientIp());
        $entityManager->persist($like);
        $entityManager->flush();
        return $this->redirectToRoute('app_aarticle_show', ['id' => $aarticle->getId()]);
    }
/**
 * @Route("/like/{id}", name="like_remove", methods={"DELETE"})
 */
public function remove(Request $request, Aarticle $aarticle): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $like = $entityManager->getRepository(Like::class)->findOneBy([
        'aarticle' => $aarticle,
        'ipAddress' => $request->getClientIp()
    ]);
    if (!$like) {
        throw $this->createNotFoundException('No like found for article '.$aarticle->getId());
    }
    $entityManager->remove($like);
    $entityManager->flush();
    return $this->redirectToRoute('app_aarticle_show', ['id' => $aarticle->getId()]);
}




#[Route('/search', name: 'app_article_search', methods: ['POST'])]
public function search(AarticleRepository $aarticleRepository, Request $request): JsonResponse
{
    $searchTerm = $request->request->get('searchTerm');
    $aarticles = $aarticleRepository->findByTitle($searchTerm);

    $response = [
        'aarticles' => [],
    ];

    foreach ($aarticles as $aarticle) {
        $response['aarticles'][] = [
            'id' => $aarticle->getId(),
            'title' => $aarticle->getTitle(),
            'content' => $aarticle->getContent(),
        ];
    }

    return new JsonResponse($response);
}



}





















