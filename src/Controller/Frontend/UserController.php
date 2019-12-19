<?php

namespace App\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserUpdateProfilType;

class UserController extends AbstractController
{
    /**
     * @Route("/profil",
     *     name="profil_user",
     *     methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @return Response
     */
    public function profile()
    {
        return $this->render('frontend/user/profil.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/profil/update",
     *     name="profil_update",
     *     methods={"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function profileUpdate(Request $request)
    {
        $updateForm = $this->createForm(UserUpdateProfilType::class, $this->getUser());
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash(
                    'success',
                    'Votre modification de profil a bien été enregistrée'
            );

            return $this->redirectToRoute('profil_user');
        }

        return $this->render('frontend/user/profil_update.html.twig', [
            'update_form' => $updateForm->createView(),
        ]);
    }
}
