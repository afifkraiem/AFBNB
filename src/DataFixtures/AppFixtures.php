<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Role;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture

    
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
        
    
    public function load(ObjectManager $manager)
    {


        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setRole('ADMIN_ROLE');
        $manager->persist($adminRole); 
        $admin = new User();

        $admin->setFirstName('Afif')
              ->setLastName('Krayem')
              ->setEmail('krayem.afif@gmail.com')
              ->setDescription('<p>'.join('<p></p>',$faker->paragraphs(3)).'</p>')
              ->setIntroduction($faker->sentence())
              ->setPassword($this->encoder->encodePassword($admin,'Afkr;)91'))
              ->setPicture('https://thumbs.dreamstime.com/b/business-executive-male-concept-icon-businessman-profile-cartoon-theme-design-vector-illustration-graphic-81938737.jpg')
              ->addUserRole($adminRole);

              $manager->persist($admin);


        //Gestion des utilisateurs
        $users = [];
        $genres = ['male','female'];

        for($i=1; $i<=10; $i++) {


            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuserme/api/portraits/';
            $pictureId = $faker->numberBetween(1,99).'.jpg';

            $picture .= ($genre=='male' ?'men/' : 'women/').$pictureId;
            $hash = $this->encoder->encodePassword($user,'password');

            $user->setFirstName($faker->firstName($genre))
                 ->setLastName($faker->lastName($genre))
                 ->setEmail($faker->email)
                 ->setDescription('<p>'.join('<p></p>',$faker->paragraphs(3)).'</p>')
                 ->setIntroduction($faker->sentence())
                 ->setPassword($hash)
                 ->setPicture($picture);

                 $manager->persist($user);

                 $users[] = $user; 
        }
        //Gestion des annonces
        for($i=1; $i<=30; $i++) {
            
            $title = $faker->sentence($nbWords = 4, $variableNbWords = true);
            $coverImage = $faker->imageUrl($width = 1000, $height = 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';
            $user = $users[mt_rand(0,count($users)-1)];

            $ad = new Ad;
            $ad->setTitle($title)
           ->setCoverImage($coverImage)
           ->setIntro($introduction)
           ->setContent($content)
           ->setPrice(mt_rand(40,200))
           ->setRooms(mt_rand(1,5))
           ->setAuthor($user);
          
           for($j=1; $j<=mt_rand(2,5); $j++) {
               $image = new Image();

               $image->setUrl($faker->imageUrl())
                     ->setCaption($faker->sentence())
                     ->setAd($ad);
               $manager->persist($image);         
           }

           //Gestion de reservations

           for($j=1; $j<=mt_rand(0,10); $j++) {
               $booking = new Booking();

               $createdAt = $faker->dateTimeBetween('-6 months');
               $startDate = $faker->dateTimeBetween('-3 months');

               $duration = mt_rand(3,10);

               $endDate = (clone $startDate)->modify("+$duration days");
               $amount = $ad->getPrice() * $duration ;

               $booker = $users[mt_rand(0, count($users)-1)];

               $booking->setBooker($booker)
                       ->setAd($ad)
                       ->setStartDate($startDate)
                       ->setEndDate($endDate)
                       ->setCreatedAt($createdAt)
                       ->setAmount($amount)
                       ->setCommentaire($faker->paragraph());

                $manager->persist($booking);


            //Gestion des commentaires
            if(mt_rand(0,1)) {

                $comment = new Comment();
                $comment->setContent($faker->paragraph())
                        ->setRating(mt_rand(1,5))
                        ->setAuthor($booker)
                        ->setAd($ad);

                $manager->persist($comment);
            }
           }
         $manager->persist($ad);

        }

        

        $manager->flush();
    }
}
