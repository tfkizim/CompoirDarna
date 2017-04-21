<?php

namespace RestaurantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\TypeCompany;
use RestaurantBundle\Form\TypeCompanyType;

/**
 * TypeCompany controller.
 *
 * @Route("/typecompany")
 */
class TypeCompanyController extends Controller
{
    /**
     * Lists all TypeCompany entities.
     *
     * @Route("/", name="typecompany_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeCompanies = $em->getRepository('RestaurantBundle:TypeCompany')->findAll();

        return $this->render('typecompany/index.html.twig', array(
            'typeCompanies' => $typeCompanies,
        ));
    }

    /**
     * Creates a new TypeCompany entity.
     *
     * @Route("/new", name="typecompany_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeCompany = new TypeCompany();
        $form = $this->createForm('RestaurantBundle\Form\TypeCompanyType', $typeCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCompany);
            $em->flush();

            return $this->redirectToRoute('typecompany_show', array('id' => $typeCompany->getId()));
        }

        return $this->render('typecompany/new.html.twig', array(
            'typeCompany' => $typeCompany,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeCompany entity.
     *
     * @Route("/{id}", name="typecompany_show")
     * @Method("GET")
     */
    public function showAction(TypeCompany $typeCompany)
    {
        $deleteForm = $this->createDeleteForm($typeCompany);

        return $this->render('typecompany/show.html.twig', array(
            'typeCompany' => $typeCompany,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeCompany entity.
     *
     * @Route("/{id}/edit", name="typecompany_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeCompany $typeCompany)
    {
        $deleteForm = $this->createDeleteForm($typeCompany);
        $editForm = $this->createForm('RestaurantBundle\Form\TypeCompanyType', $typeCompany);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCompany);
            $em->flush();

            return $this->redirectToRoute('typecompany_edit', array('id' => $typeCompany->getId()));
        }

        return $this->render('typecompany/edit.html.twig', array(
            'typeCompany' => $typeCompany,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeCompany entity.
     *
     * @Route("/{id}", name="typecompany_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeCompany $typeCompany)
    {
        $form = $this->createDeleteForm($typeCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeCompany);
            $em->flush();
        }

        return $this->redirectToRoute('typecompany_index');
    }

    /**
     * Creates a form to delete a TypeCompany entity.
     *
     * @param TypeCompany $typeCompany The TypeCompany entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeCompany $typeCompany)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecompany_delete', array('id' => $typeCompany->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
