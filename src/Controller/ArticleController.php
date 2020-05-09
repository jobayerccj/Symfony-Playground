<?php 
 namespace App\Controller;

use App\Entity\Article;
use App\Helper\LoggerTrait;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Http\Discovery\Exception\NotFoundException;

class ArticleController extends AbstractController{

    use LoggerTrait;
    
    public function __construct(bool $isDebug)
    {
        //dump($isDebug);die;
    }


    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository){

        $articles = $repository->findAllPublishedOrderByNewest();
        return $this->render('article/homepage.html.twig',[
            'articles' => $articles
        ]);
    }

    /** 
     * @Route("show/{slug}", name="article_show")
    */
    public function show(Article $article, SlackClient $slack){

        if($article->getSlug() == 'khan'){
            $slack->sendMessage('John Doe', 'Welcome from Symfony Slack Bundle!');

            $this->logInfo("Logging Slack Testing", [
                'status' => 'successful'
            ]);
        }

        /*$repository = $em->getRepository(Article::class);

        $article = $repository->findOneBy(['slug'=> $slug]);
        
        if(!$article){
            throw $this->createNotFoundException(sprintf('No Article found using slug %s', $slug));
        }*/

        //dump($article);die;
        
        
        
        //var_dump($articleContent);exit;
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /** 
     * @Route("show/{slug}/heart", name="article_toggle_heart", methods={"POST"})
    */
    public function toggleArtcileHeart(Article $article, EntityManagerInterface $em){
        
        $article->updateHeartCount();
        $em->flush();

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
 }
