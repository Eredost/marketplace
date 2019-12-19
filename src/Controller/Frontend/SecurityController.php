<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\RegistrationType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration",
     *     name="app_registration",
     *     methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function registration(Request $request)
    {
        $user = new User();
        $registrationForm = $this->createForm(RegistrationType::class, $user);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre inscription est effectuée !'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('frontend/security/registration.html.twig', [
            'registration_form' => $registrationForm->createView(),
        ]);
    }

    /**
     * @Route("/login",
     *     name="app_login",
     *     methods={"GET", "POST"})
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('frontend/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @Route("/logout",
     *     name="app_logout",
     *     methods={"GET"})
     *
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
