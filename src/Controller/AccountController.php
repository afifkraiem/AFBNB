<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\ProfilType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }


    /**
     * @Route("/logout", name="account_logout")
     * @return Void
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/register", name="account_register")
     * @return Response
     */

     public function register (Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder) {


        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "votre compte a été bien créee");
            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
     }

    

     /**
      * @Route("/account/profile", name="account_profil")
      *@return Response
      */

      public function profil(Request $request, ObjectManager $em) {

        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "vos informations ont été bien modifiées");
            return $this->redirectToRoute('account_profil');
        }
        return $this->render('account/profil.html.twig', ['form'=>$form->createView(), 'user'=>$user]);

      }

      /**
       * modification du mot de passe utilisateur
       *@Route("/account/reset-password", name="reset_password")
       * @return Response
       */
      public function resetPassword (Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder) {

        $user = $this->getUser();

        $passworUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passworUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //vérification du mot de pass actuel
          if ( !password_verify($passworUpdate->getOldPassword(), $user->getPassword())) {

           $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez tapé n'est pas correct !"));
            
              
        } else {
            $newPassword = $passworUpdate->getNewPassword();
            $password = $encoder->encodePassword($user,$newPassword);
             $user->setPassword($password);
             $em->persist($user);
             $em->flush();
             $this->addFlash('success', "Votre mot de passe a été bien modifié");
            return $this->redirectToRoute('homepage');
        }
    }
        return $this->render('account/password.html.twig', ['form'=>$form->createView()]);

      }
}
