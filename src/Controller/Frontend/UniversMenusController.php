<?php

namespace App\Controller\Frontend;

use App\Entity\Category;
use App\Entity\Subcategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UniversMenusController extends AbstractController
{
    /**
     * @Route("/{type}/{id}",
     *     name="showlist",
     *     methods={"GET"},
     *     requirements={"type": "(subcategory|category)", "id": "\d+"})
     *
     * @param $id
     * @param $type
     *
     * @return Response
     */
    public function index($id, $type)
    {
        switch ($type) {

            case "subcategory":
                $repository = $this->getDoctrine()->getRepository(Subcategory::class);
                break;

            case "category" :
                $repository = $this->getDoctrine()->getRepository(Category::class);
                break;
        }
        $rubric = $repository->getRubricWithProducts($id);

        return $this->render('frontend/univers_menus/showlist.html.twig', [
            'type'      => $rubric,
            'type_name' => $type,
        ]);
    }
}
