<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function PHPUnit\Framework\assertIsNotInt;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class SecurityController extends AbstractController
    {
        

    #[Route('/registration', 'app_registration')]
    public function registration(Request $request, UserRepository $repository, MailerInterface $mailer, UserPasswordHasherInterface $hasher)
    {
        $form = $this->createForm(RegistrationType::class);
        $userInfo = $form->handleRequest($request);
        
        if($form->isSubmitted()&& $form->isValid()){
            $userTest= $repository->findByEmail($userInfo->get('email')->getData());
            if(empty($userTest) == true ){         
                $user = $form->getData();
                $cryptedPassword = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($cryptedPassword);
                $repository->add($user, true);

                $email = (new TemplatedEmail())
                    ->from('contact@coach-art-paris.fr')
                    ->to($user->getEmail())
                    ->subject('Bienvenue à coachArt '.$user->getName())
                    ->htmlTemplate('emails/security/registration.html.twig')
                    ->context([
                        'name'=>$user->getName()
                    ]);
                    $mailer->send($email);
                return $this->redirectToRoute('app_login');
            }
            return $this->redirectToRoute('app_security_mailNotApprouved');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/registration/echec', name: 'app_security_mailNotApprouved')]
    public function testMailNotApprouved(): Response
    {
        return $this->render('security/emailNotNew.html.twig');
    }
   

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/profil/show', name: 'app_security_showProfil')]
        public function showProfile(): Response
    {
        /** @var User $user */

        $user =$this->getUser();
           
        return $this->render('security/show_profil.html.twig', [   
        'user' =>$user
        ]);
    }

        #[Route('/profil/change', 'app_security_changeProfil')]
        public function changeProfil(Request $request, UserRepository $repository):Response
        {
            /** @var User $user */

            $user =$this->getUser();
            $form = $this->createForm(ProfilType::class, $user);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
               $repository->add($user, true);
               return $this->redirectToRoute('app_security_showProfil');
            }
                return $this->render('security/change_profil.html.twig', [
                    'form' =>$form->createView(),
                    'user' =>$user
                ]);
            
        }
    

   


}
