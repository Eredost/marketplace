<?php
namespace App\Controller\Frontend;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id<\d+>}",
     *     name="product_show",
     *     methods={"GET"})
     *
     * @param ProductRepository $productRepository
     * @param Product|null      $product
     *
     * @return Response
     *
     * @throws NotFoundHttpException when the desired product is not existing
     */
   public function show(ProductRepository $productRepository, Product $product)
   {
       $products = $productRepository->getProductsWithoutTheOneDisplayed($product->getId());

       return $this->render('frontend/product/show.html.twig', [
           'product'          => $product,
           'product_producer' => $products,
       ]);
   }

    /**
     * @Route("/product/new",
     *     name="product_new",
     *     methods={"GET","POST"})
     * @IsGranted("ROLE_PRODUCER")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws AccessDeniedException when the user is not registered as a producer
     */
   public function new(Request $request)
   {
       $producer = $this->getUser()->getProducer();
       $product = new Product();
       $productForm = $this->createForm(ProductType::class, $product);
       $productForm->handleRequest($request);

       if ($productForm->isSubmitted() && $productForm->isValid()) {
           $product->setProducer($producer);
           $manager = $this->getDoctrine()->getManager();
           $manager->persist($product);
           $manager->flush();

           $this->addFlash(
               'success',
               'Votre produit a bien été enregistré'
           );

           return $this->redirectToRoute('product_show', [
               'id' => $product->getId(),
           ]);
       }

       return $this->render('/frontend/product/new.html.twig', [
           'product' => $product,
           'form'    => $productForm->createView()
       ]);
   }

    /**
     * @Route("/product/{id<\d+>}/edit",
     *     name="product_edit",
     *     methods={"GET","POST"})
     * @IsGranted("PRODUCER_EDIT", subject="product")
     *
     * @param Request      $request
     * @param Product|null $product
     *
     * @return RedirectResponse|Response
     *
     * @throws NotFoundHttpException when the desired product does not exist
     */
    public function edit(Request $request, Product $product)
    {
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash(
                'info',
                'Mise à jour effectuée'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('frontend/product/edit.html.twig', [
            'product' => $product,
            'form'    => $productForm->createView(),
        ]);
    }

    /**
     * @Route("product/disable/{id<\d+>}",
     *     name = "disable_product",
     *     methods={"GET", "POST"})
     * @IsGranted("PRODUCER_EDIT", subject="product")
     *
     * @param EntityManagerInterface $manager
     * @param Product|null $product
     *
     * @return RedirectResponse
     */
    public function toggleProduct(EntityManagerInterface $manager, Product $product)
    {
        $toggle = !$product->getEnable();
        $product->setEnable($toggle);
        $manager->flush();

        $this->addFlash(
            $toggle ? 'success' : 'danger',
            $toggle ? 'Le produit a bien été debloquée' : 'La produit a bien été archivé'
        );

        return $this->redirectToRoute('producer_profil', [
            'id' => $product->getProducer()->getId()
        ]);
    }

    /**
     * @Route("/product/{id<\d+>}",
     *     name="product_delete",
     *     methods={"DELETE"})
     * @IsGranted("PRODUCER_EDIT", subject="product")
     *
     * @param Request      $request
     * @param Product|null $product
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException when the desired product does not exist
     */
    public function delete(Request $request, Product $product)
    {
        if ($this->isCsrfTokenValid('delete', $request->request->get('_token'))) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();

            $this->addFlash(
                'success',
                'Suppression effectuée'
            );
        } else {

            $this->addFlash(
                'danger',
                'Une erreur s\'est produite, veuillez réessayer ultérieurement'
            );
        }

        return $this->redirectToRoute('producer_profil');
    }
}
