<?php
namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security as CoreSecurity;

class MarkdownHelper{

    private $cache;
    private $parser;
    private $logger;
    private $security;

    public function __construct(AdapterInterface $cache, MarkdownInterface $parser, LoggerInterface $logger, CoreSecurity $security)
    {
        $this->cache = $cache;
        $this->parser = $parser;
        $this->logger = $logger;
        $this->security = $security;
    }

    public function parse(string $source):string
    {   
        if(strpos($source, 'bacon') !== false){
            $this->logger->info("They are talking about bacon again!", [
                'user' => $this->security->getUser()
            ]);
        }

        $item = $this->cache->getItem('markdown_'.md5($source));

        if(!$item->isHit()){
            $item->set($this->parser->transform($source) );
            $this->cache->save($item);
        }

        return $item->get();
    }
}