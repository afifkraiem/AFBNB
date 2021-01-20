<?php

namespace App\Service ;

use Doctrine\Persistence\ObjectManager;

class PaginationService {

    private $entityClass;
    private $limit = 5;
    private $currentPage = 1;
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getData() {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],[],$this->limit,$offset);
        return $data;
    }

    public function getPages() {

        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        $pages = ceil( $total / $this->limit);

        return $pages;

    }

    public function setEntityClass($entityClass ) {
        $this->entityClass = $entityClass;
        return $this;    
    }

    public function getEntityClass() {

        return $this->entityClass;
    }
    
    public function SetLimit($limit) {
        $this->limit = $limit;
    }

    public function GetLimit() {
        return $this->limit;
    }

    public function SetPage($page) {
        $this->currentPage = $page;
    }

    public function getPage() {
        return $this->currentPage;
    }
}
