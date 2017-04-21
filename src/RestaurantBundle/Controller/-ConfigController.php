<?php

namespace RestaurantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RestaurantBundle\Entity\Config;
use RestaurantBundle\Form\ConfigType;

/**
 * Config controller.
 *
 * @Route("/configcrud")
 */
class ConfigController extends Controller
{
    /**
     * Lists all Config entities.
     *
     * @Route("/", name="configcrud_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $configs = $em->getRepository('RestaurantBundle:Config')->findAll();

        return $this->render('config/index.html.twig', array(
            'configs' => $configs,
        ));
    }

    /**
     * Creates a new Config entity.
     *
     * @Route("/new", name="configcrud_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $config = new Config();
        $form = $this->createForm('RestaurantBundle\Form\ConfigType', $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('configcrud_show', array('id' => $config->getId()));
        }

        return $this->render('config/new.html.twig', array(
            'config' => $config,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Config entity.
     *
     * @Route("/{id}", name="configcrud_show")
     * @Method("GET")
     */
    public function showAction(Config $config)
    {
        $deleteForm = $this->createDeleteForm($config);

        return $this->render('config/show.html.twig', array(
            'config' => $config,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Config entity.
     *
     * @Route("/{id}/edit", name="configcrud_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Config $config)
    {
        $deleteForm = $this->createDeleteForm($config);
        $editForm = $this->createForm('RestaurantBundle\Form\ConfigType', $config);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($config);
            $em->flush();

            return $this->redirectToRoute('configcrud_edit', array('id' => $config->getId()));
        }

        return $this->render('config/edit.html.twig', array(
            'config' => $config,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Config entity.
     *
     * @Route("/{id}", name="configcrud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Config $config)
    {
        $form = $this->createDeleteForm($config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($config);
            $em->flush();
        }

        return $this->redirectToRoute('configcrud_index');
    }

    /**
     * Creates a form to delete a Config entity.
     *
     * @param Config $config The Config entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Config $config)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configcrud_delete', array('id' => $config->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
