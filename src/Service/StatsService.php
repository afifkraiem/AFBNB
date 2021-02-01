<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;

class StatsService {

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getStats() {
        $users = $this->countUsers();
        $ads = $this->countAds();
        $bookings = $this->countBookings();
        $comments = $this->countComments();

        return compact('users','ads','bookings', 'comments');
    }
    public function countUsers() {
        $users = $this->manager->createQuery('SELECT  COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        return $users;
    }

    public function countAds() {
        $ads = $this->manager->createQuery('SELECT  COUNT(d) FROM App\Entity\Ad d')->getSingleScalarResult();
        return $ads;
    }

    public function countBookings() {
        $bookings = $this->manager->createQuery('SELECT  COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
        return $bookings;
    }

    public function countComments() {
        $comments = $this->manager->createQuery('SELECT  COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
        return $comments;
    }

    public function getBestAds() {
        $betsAds = $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture FROM App\Entity\Comment c 
            JOIN c.ad a
            JOIN a.author u
            GROUP BY a
            ORDER BY note DESC'
        )
        ->setMaxResults(5)
        ->getResult();

        return $betsAds;
    }


    public function getWorstAds() {

        $worstAds = $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture FROM App\Entity\Comment c 
            JOIN c.ad a
            JOIN a.author u
            GROUP BY a
            ORDER BY note ASC'
        )
        ->setMaxResults(5)
        ->getResult();

        return $worstAds;
    }
}