<?php
namespace ProdeMundial\CoreBundle\Handler;


use Doctrine\ORM\EntityManager;

class PredictionHandler
{
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->repository = $em->getRepository('ProdeMundialCoreBundle:Prediction');
    }
} 