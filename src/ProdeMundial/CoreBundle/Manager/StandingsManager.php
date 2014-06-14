<?php

namespace ProdeMundial\CoreBundle\Manager;


use Doctrine\ORM\EntityManager;
use ProdeMundial\CoreBundle\Entity\User;

class StandingsManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getBaseQuery()
    {
        $date = new \DateTime();
        $query = $this->em->getRepository('ProdeMundialCoreBundle:Prediction')
            ->createQueryBuilder('p')
            ->select('u.username', 'count(p.id) as points')
            ->leftJoin('p.game', 'g')
            ->leftJoin('p.user', 'u')
            ->andWhere('p.result = g.prodeResult')
            ->groupBy('u')
            ->orderBy('points', 'DESC')
        ;

        return $query;
    }

    public function getGeneralStandings()
    {
        $users = $this->em->getRepository('ProdeMundialCoreBundle:User')->findAll();
        $results = $this->getBaseQuery()->getQuery()->getResult();

        return $this->completeStandings($results, $users);
    }

    public function getPaidStandings()
    {
        $users = $this->em->getRepository('ProdeMundialCoreBundle:User')->findByPaymentDone(true);
        $results = $this->getBaseQuery()->andWhere('u.paymentDone = 1')->getQuery()->getResult();

        return $this->completeStandings($results, $users);
    }

    public function getFreeStandings()
    {
        $users = $this->em->getRepository('ProdeMundialCoreBundle:User')->findByPaymentDone(false);
        $results = $this->getBaseQuery()->andWhere('u.paymentDone = 0')->getQuery()->getResult();

        return $this->completeStandings($results, $users);
    }


    private function completeStandings($results, $users)
    {
        /** @var User $user */
        foreach($users as $user) {
            if(!$this->in_array_r($user->getUsername(), $results, true)) {
                $results[] = array(
                    'username' => $user->getUsername(),
                    'points' => 0
                );
            }
        }

        return $results;
    }


    private function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
} 