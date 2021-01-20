<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Mime\Email;
use App\Repository\BookingRepository;
use App\Service\PaginationService;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads")
     */
    public function indexAds(AdRepository $adRepo, $page, PaginationService $pagination) {

        $pagination->setEntityClass(Ad::class)
                   ->SetPage($page);

        $ads = $pagination->getData();
     
        return $this->render('admin/ad/index.html.twig', [
            'ads' => $ads,
            'pages' => $pagination->getPages(),
            'page' => $page,
            'limit' => $pagination->GetLimit(),
            
        ]);
    }


     /**
     * @Route("/admin/bookings", name="admin_bookings")
     */
    public function indexBookings(BookingRepository $bkRepo) {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bkRepo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/delete", name="admin_delete_ad")
     * @return void 
     */

     public function RemoveAd(Ad $ad, ObjectManager $em,  \Swift_Mailer $mailer) {
            //$em->remove($ad);
            //$em->flush();
            $mail = $ad->getAuthor()->getEmail();
            dump($mail);
            $message = (new \Swift_Message('Notification de suppression '))
            ->setFrom('noreply@afbnb.com')
            ->setTo($mail)
            ->setBody('test email');
    
           
    
        $mailer->send($message);
            return $this->redirectToRoute('admin_ads');
    }
}
