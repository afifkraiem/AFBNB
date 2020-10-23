<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Afficher toutes les annonces
     * @Route("/ads", name="ads_index")
     */ 
    public function index(AdRepository $repo)
    {

        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route("/ads/new", name="ads_create")
     * 
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $em) 
    {   

        $ad = new Ad();
        
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);    
        if($form->isSubmitted()&& $form->isValid()) {

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $em->persist($image);
            }
            
            $em->persist($ad);
            $em->flush();
            $this->addFlash('success', "votre annonce <strong>{$ad->getTitle()}</strong> a été bien créee");
            return $this->redirectToRoute('ads_show',['slug' =>$ad->getSlug()]);
        }
                 
       return $this->render('ad/new.html.twig', ['form' => $form->createView()]);
    }


    /**
     * Edition d'une annonce
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Response
     */

    public function edit(Request $request, ObjectManager $em, $slug, AdRepository $adRepo) {

        $ad = $adRepo->findOneBySlug($slug);
        
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request);    
        
        if($form->isSubmitted()&& $form->isValid()) {

            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $em->persist($image);
            }
           
            $em->persist($ad);
            $em->flush();

            $this->addFlash('success', "votre annonce <strong>{$ad->getTitle()}</strong> a été bien modifiée");
            return $this->redirectToRoute('ads_show',['slug' =>$ad->getSlug()]);
        }
                 
       return $this->render('ad/edit.html.twig', ['form' => $form->createView(), 'ad'=>$ad]);

    }

    /**
     * afficher une seule annonce
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */

     public function show(Ad $ad) 
     {

        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);

     }

}
