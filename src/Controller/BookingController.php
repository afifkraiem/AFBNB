<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, ObjectManager $em)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
         
            $user = $this->getUser();

            $booking->setBooker($user)
                    ->setAd($ad);
            //vérifier que les dates sont disponibles
            if(!$booking->isBookableDates()) {
                $this->addFlash('warning', 'Les dates que vous avez choisi ne peuvent être réservées : elles sont déjà prises.');
            }
            else {
                $em->persist($booking);
                $em->flush();
                
                return $this->redirectToRoute('booking_show', ['id'=> $booking->getId(), 'success' => true]);
    
            }
            
        }
        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

/**
 * Undocumented function
 * @Route("/booking/{id}/show", name="booking_show")
 * @param Booking $booking
 * @return Response
 */
    public function show(Booking $booking, Request $request, ObjectManager $em) {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ) {

            $comment->setAd($booking->getAd())
                    ->setAuthor($this->getUser());
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire est bien enregistré, merci pour votre avis.');

         

        }
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);

    }
}
