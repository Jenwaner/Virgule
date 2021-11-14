<?php

namespace App\Controller;

use App\Entity\Admin\Ccard;
use App\Form\Ccard1Type;
use App\Repository\CcardRepository;
use App\Repository\Admin\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ccard")
 */
class CcardController extends AbstractController
{
    /**
     * @Route("/", name="ccard_index", methods={"GET"})
     */


    public function index(ProductRepository $productRepository, CcardRepository $ccardRepository): Response
    {
        $user = $this->getUser();
        $cards = $ccardRepository->findBy(['userid'=>$user->getId()]);
        $products = $productRepository->getUserProduct($user->getId());
        return $this->render('ccard/index.html.twig', [
            'products' => $products,
            'cards' => $cards,
        ]);
    }

    /**
     * @Route("/new", name="ccard_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ccard = new Ccard();
        $form = $this->createForm(Ccard1Type::class, $ccard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $ccard->setUserid($user->getId());
            $entityManager->persist($ccard);
            $entityManager->flush();

            return $this->redirectToRoute('ccard_index');
        }

        return $this->render('ccard/new.html.twig', [
            'ccard' => $ccard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ccard_show", methods={"GET"})
     */
    public function show(Ccard $ccard): Response
    {
        return $this->render('ccard/show.html.twig', [
            'ccard' => $ccard,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ccard_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ccard $ccard): Response
    {
        $form = $this->createForm(Ccard1Type::class, $ccard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_account');
        }

        return $this->render('ccard/edit.html.twig', [
            'ccard' => $ccard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ccard_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ccard $ccard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ccard->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ccard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ccard_index');
    }
}
