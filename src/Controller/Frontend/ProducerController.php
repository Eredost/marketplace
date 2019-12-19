<?php

namespace App\Controller\Frontend;


use App\Entity\Producer;
use App\Form\ProducerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProducerController extends AbstractController
{
    /**
     * @Route("/producer/profil",
     *     name="producer_profil",
     *     methods={"GET"})
     * @IsGranted("ROLE_PRODUCER")
     *
     * @return Response
     *
     * @throws UnauthorizedHttpException when the user is not registered as a producer
     */
    public function index()
    {
        $producer = $this->getUser()->getProducer();

        return $this->render('frontend/producer/profil.html.twig', [
            'producer' => $producer,
        ]);
    }

    /**
     * @Route("/producer/registration",
     *     name="producer_registration",
     *     methods={"GET","POST"})
     * @IsGranted("NOT_PRODUCER")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $producer = new Producer();
        $producerForm = $this->createForm(ProducerType::class, $producer);
        $producerForm->handleRequest($request);

        if ($producerForm->isSubmitted() && $producerForm->isValid()) {
            $producer->setUser($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($producer);
            $manager->flush();

            $this->addFlash(
                'success',
                'Enregistrement effectué'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontend/producer/registration.html.twig', [
            'producer' => $producer,
            'form'     => $producerForm->createView(),
        ]);
    }

    /**
     * @Route("/producer/{id<\d+>}",
     *     name="producer_show",
     *     methods={"GET"})
     *
     * @param Producer|null $producer
     *
     * @return Response
     *
     * @throws NotFoundHttpException when the desired producer is not existing
     */
    public function show(Producer $producer)
    {
        return $this->render('frontend/producer/show.html.twig', [
            'producer' => $producer,
        ]);
    }

    /**
     * @Route("/producer/edit",
     *     name="producer_edit",
     *     methods={"GET","POST"})
     * @IsGranted("ROLE_PRODUCER")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws UnauthorizedHttpException when the user is not registered as a producer
     */
    public function edit(Request $request)
    {
        $producer = $this->getUser()->getProducer();
        $producerForm = $this->createForm(ProducerType::class, $producer);
        $producerForm->handleRequest($request);

        if ($producerForm->isSubmitted() && $producerForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash(
                'success',
                'Mise à jour effectuée'
            );

            return $this->redirectToRoute('producer_profil');
        }
    
        return $this->render('frontend/producer/edit.html.twig', [
            'producer' => $producer,
            'form'     => $producerForm->createView(),
        ]);
    }
}
