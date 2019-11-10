<?php


namespace App\Controller\Backend;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\Backend
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("",
     *     name="home",
     *     methods={"GET"})
     */
    public function index()
    {
        return $this->render("backend/index.html.twig");
    }
}
