<?php

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager as PersistenceObjectManager;
use Doctrine\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\Article as EntityArticle;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{   
    private static $articleTitles = [
        'What is Lorem Ipsum?',
        'Why do we use it?',
        'Where does it come from?',
        'Where can I get some?'
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png'
    ];

    private static $artcileAuthors = [
        'Mike Ferengi',
        'Amy Oort'
    ];

   

    protected function loadData(PersistenceObjectManager $manager)
    {   
        
        
        $this->createMany(Article::class, 10, function(Article $article) use ($manager){
            
            $article->setTitle($this->faker->randomElement(self::$articleTitles));


            //newly added fields
            $article->setAuthor($this->faker->randomElement(self::$artcileAuthors));
            $article->setHeartCount($this->faker->numberBetween(5,100));
            $article->setIamgeFilename($this->faker->randomElement(self::$articleImages));
            //end

            //$article->setSlug($this->faker->slug());
            $article->setContent('
            Spicy <b>alapeno bacon</b> ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
            lorem proident beef ribs aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
            <a href="https://jobayerislam.com">labore</a> minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
            turkey shank eu pork belly meatball non cupim.

            Laboris **beef** ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
            laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
            capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
            picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
            occaecat lorem meatball prosciutto quis strip steak.

            Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
            mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
            strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
            cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
            fugiat.

            Sausage tenderloin officia jerky nostrud. Laborum elit pastrami non, pig kevin buffalo minim ex quis. Pork belly
            pork chop officia anim. Irure tempor leberkas kevin adipisicing cupidatat qui buffalo ham aliqua pork belly
            exercitation eiusmod. Exercitation incididunt rump laborum, t-bone short ribs buffalo ut shankle pork chop
            bresaola shoulder burgdoggen fugiat. Adipisicing nostrud chicken consequat beef ribs, quis filet mignon do.
            Prosciutto capicola mollit shankle aliquip do dolore hamburger brisket turducken eu.

            Do mollit deserunt prosciutto laborum. Duis sint tongue quis nisi. Capicola qui beef ribs dolore pariatur.
            Minim strip steak fugiat nisi est, meatloaf pig aute. Swine rump turducken nulla sausage. Reprehenderit pork
            belly tongue alcatra, shoulder excepteur in beef bresaola duis ham bacon eiusmod. Doner drumstick short loin,
            adipisicing cow cillum tenderloin
            ');

            if($this->faker->boolean(70)){
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $total_comment = rand(5,15);

            for($i = 0 ; $i < $total_comment; $i++){
                $comment1 = new Comment();
                $comment1->setAuthorName($this->faker->name);
                $comment1->setContent(
                    $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
                );
                $comment1->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
                $comment1->setArticle($article);
                $comment1->setIsDeleted($this->faker->boolean(20));
                $manager->persist($comment1);
            }

            $total_tag = rand(1,5);

            for($i = 0 ; $i < $total_tag; $i++){
                $tag = new Tag();
                $tag->setName($this->faker->name);
                $tag->addArticle($article);
             
                $manager->persist($tag);
            }

            /*$comment1 = new Comment();
            $comment1->setAuthorName('Mike Ferengi');
            $comment1->setContent('It is a long established fact that a reader will be distracted by the readable content');
            $comment1->setArticle($article);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthorName('Mike Ferengi');
            $comment2->setContent('page when looking at its layout. The point of as opposed to using');
            $comment2->setArticle($article);
            $manager->persist($comment2);*/

            //$tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0, 5));
            //var_dump($tags);die();
        });
        
        
        $manager->flush();

        //$this->manager->persist(new Article());
        //$this->addReference('Article_0', new Article());

        //echo 'test '. json_encode($this->getReference('Article_0'));

        //var_dump($this->getReference('App\Entity\Article_0'));
    }

    public function getDependencies()
    {
        return [
            TagFixture::class
        ];
    }

    
}
