<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(ObjectManager $manager, StatsService $statsService): Response
    {

        
        

        return $this->render('admin/dashboard/dashboard.html.twig', [

            'stats' =>  $statsService->getStats(),
            'bestAds' => $statsService->getBestAds(),
            'worstAds' => $statsService->getWorstAds()

            ]);
    }
}
