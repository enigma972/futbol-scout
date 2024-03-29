<?php

namespace App\Controller;

use App\Events;
use App\Entity\User;
use App\Entity\ResetPassword;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UserRepository;
use App\Repository\ResetPasswordRepository;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Entity\Avatar;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    private $eventDispatcher;
    private $em;
    

    public function __construct(EventDispatcherInterface $eventDispatcher, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }  

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository,FlashBagInterface $flashBag): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }                

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userOld = $userRepository->findOneByMail($form->get('mail')->getData());

            if (!$userOld instanceOf User) {
                $category = $form->get('category')->getData();
                $user->setCategory($category);
                
                $avatar = new Avatar();
                $user->setAvatar($avatar);


                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                
                $this->em->persist($avatar);
                $this->em->persist($user);
                $this->em->flush();

                // When triggering an event, you can optionally pass some information.
                // For simple applications, use the GenericEvent object provided by Symfony
                // to pass some PHP variables. For more complex applications, define your
                // own event object classes.
                // See https://symfony.com/doc/current/components/event_dispatcher/generic_event.html
                $event = new GenericEvent($user);

                // When an event is dispatched, Symfony notifies it to all the listeners
                // and subscribers registered to it. Listeners can modify the information
                // passed in the event and they can even modify the execution flow, so
                // there's no guarantee that the rest of this controller will be executed.
                // See https://symfony.com/doc/current/components/event_dispatcher.html
                $this->eventDispatcher->dispatch($event, Events::USER_CREATED);

                $flashBag->add('info', 'Votre compte a bien été créé!');

                return $this->redirectToRoute('app_login');
            }else{
                $flashBag->add('success', 'Cette adresse email est déjà utiliser par un autre compte !');
            }
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {    
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }


        // get the login error if there is one
        if ($error = $authenticationUtils->getLastAuthenticationError()) {
            $error = 'Veuillez verifier vos informations';
        }else{
            $error = '';
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     * 
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/reset/password", name="app_reset_pass")
     */
    public function resetPass(Request $request, UserRepository $userRepository, FlashBagInterface $flashBag)
    {
        $resetLinkIsSended = false;
        $mail = '';

        if ($request->isMethod('POST')) {
            $mail = $request->request->get('mail');
            $user = $userRepository->findOneByMail($mail);

            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                if ($user instanceOf User) {
                    $resetpass = (new ResetPassword())->setUser($user);


                    $this->em->persist($resetpass);
                    $this->em->flush();

                    // When triggering an event, you can optionally pass some information.
                    // For simple applications, use the GenericEvent object provided by Symfony
                    // to pass some PHP variables. For more complex applications, define your
                    // own event object classes.
                    // See https://symfony.com/doc/current/components/event_dispatcher/generic_event.html
                    $event = new GenericEvent($resetpass);

                    // When an event is dispatched, Symfony notifies it to all the listeners
                    // and subscribers registered to it. Listeners can modify the information
                    // passed in the event and they can even modify the execution flow, so
                    // there's no guarantee that the rest of this controller will be executed.
                    // See https://symfony.com/doc/current/components/event_dispatcher.html
                    $this->eventDispatcher->dispatch($event, Events::USER_RESET_PASS);

                    $resetLinkIsSended = true;
                }else{
                    $flashBag->add('info', 'Aucun compte ne correspond à ce mail');
                }
            }else{
                $flashBag->add('info', 'Le mail que vous avez saisi n\'est pas correct !');
            }
        }

        return $this->render('security/reset_pass.html.twig', [
            'resetLinkIsSended' => $resetLinkIsSended,
            'mail'              => $mail
        ]);
    }

    /**
     * @Route("/reset/password/complete/{mail}/{token}", name="app_complete_reset_pass")
     */
    public function completeResetPass($mail, $token, ResetPasswordRepository $resetPasswordRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $rp = $resetPasswordRepository->findOneForValidateReseting($token, $mail);

            if ($rp instanceOf ResetPassword and $rp->isValide()) {
                if ($request->isMethod('POST')) {
                    //TODO: Add Password Greatest Validator
                    $firstPassword = $request->request->get('password_first');
                    $secondPassword = $request->request->get('password_second');

                    if ($firstPassword === $secondPassword) {
                        $user = $rp->getUser();
                        // encode the plain password
                        $user->setPassword(
                            $passwordEncoder->encodePassword(
                                $user,
                                $firstPassword
                            )
                        );

                        //Invalidate reset password token
                        $rp->setIsUsed(true);

    
                        $this->em->flush();

                        // When triggering an event, you can optionally pass some information.
                        // For simple applications, use the GenericEvent object provided by Symfony
                        // to pass some PHP variables. For more complex applications, define your
                        // own event object classes.
                        // See https://symfony.com/doc/current/components/event_dispatcher/generic_event.html
                        $event = new GenericEvent($user);

                        // When an event is dispatched, Symfony notifies it to all the listeners
                        // and subscribers registered to it. Listeners can modify the information
                        // passed in the event and they can even modify the execution flow, so
                        // there's no guarantee that the rest of this controller will be executed.
                        // See https://symfony.com/doc/current/components/event_dispatcher.html
                        $this->eventDispatcher->dispatch($event, Events::USER_PASS_RESETED);
                        

                        return $this->redirectToRoute('app_login');
                    }
                }
                $isValideToken = true;
            }
            else {$isValideToken = false;}
        }
        

        return $this->render('security/reset_pass_new.html.twig', [
            'isValideToken' => $isValideToken,
            'token'        => $token,
            'mail'          => $mail
        ]);
    }

    /**
     * @Route("/accounts/change/password", name="app_change_pass")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder, FlashBagInterface $flashBag)
    {
        if ($request->isMethod('post')) {
            $user = $this->getUser();

            $oldPassorwd = $request->request->get('old_password');
            $newPasswordFirst = $request->request->get('new_password_first');
            $newPasswordSecond = $request->request->get('new_password_second');

            if ($encoder->isPasswordValid($user, $oldPassorwd)) {
                if ($newPasswordFirst === $newPasswordSecond) {
                    if (strlen($newPasswordFirst) >= 6) {
                        $user->setPassword($encoder->encodePassword($user, $newPasswordFirst));

                        $this->em->flush();

                        $flashBag->add('success', 'Votre mot de passe a bien été changé.');

                        return $this->redirectToRoute('account_settings');
                    }else {
                        $flashBag->add('warning', 'Votre nouveau mot de passe est trop faible !');
                    }
                }else {
                    $flashBag->add('warning', 'Les nouveaux mots de passe saisi ne sont pas pareil !');
                }
            }else{
                // TODO: add reset password link in message
                $flashBag->add('danger', 'Le mot de passe saisi est incorrect !');
            }
        }else {
            $flashBag->add('warning', 'Un problème est survenu lors du traitement de votre requête. Veuillez reesayer plus tard !');
        }

        
        return $this->redirectToRoute('account_settings');
    }
}
