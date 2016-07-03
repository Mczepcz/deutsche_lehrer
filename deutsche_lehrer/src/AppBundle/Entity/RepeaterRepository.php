<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RepeaterRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RepeaterRepository extends EntityRepository
{
    public function findNewWords($user, $deck){
        $dql='SELECT r,w FROM AppBundle:Repeater r JOIN r.word w WHERE r.user = :user AND r.repeatCode = 0 AND w.deck = :deck ';
        $query=$this->getEntityManager()->createQuery($dql);
        $query->setParameter("user",$user);
         $query->setParameter("deck",$deck);
        return $query->getResult();
    }
    public function findtoRepeatWords($user, $deck){
        $date = new \DateTime();
        $dql='SELECT r,w FROM AppBundle:Repeater r JOIN r.word w WHERE r.user = :user AND r.repeatDate <= :date AND w.deck = :deck ';
        $query=$this->getEntityManager()->createQuery($dql);
        $query->setParameter("user",$user);
        $query->setParameter("deck",$deck);
        $query->setParameter("date",$date);
        return $query->getResult();
    }
}
