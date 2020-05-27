<?php 
 namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends AbstractController{

    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request){

        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());

            $article = $form->getData();
            
            $article->setAuthor($this->getUser());
            $article->setHeartCount(0);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article Created');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig',[
            'articleForm' => $form->createView()
        ]);

    }

    /**
     * @Route("admin/article/{id}/edit", name="admin_article_edit")
     * @param Article $article
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em){

        /*if(!$this->isGranted('MANAGE', $article)){
            throw $this->createAccessDeniedException('No Access!');
        }*/

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());

            $article = $form->getData();
            
            $article->setAuthor($this->getUser());
            $article->setHeartCount(0);

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article Updated');

            return $this->redirectToRoute('admin_article_edit', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('article_admin/edit.html.twig',[
            'articleForm' => $form->createView()
        ]);

    }

    /**
     * @Route("admin/article", name="admin_article_list")
     * @param ArticleRepository $articleRepo
     */
    public function list(ArticleRepository $articleRepo){
        $articles = $articleRepo->findAll();

        return $this->render('article_admin/list.html.twig', [
            'articles' => $articles
        ]);
    }
    
 }
