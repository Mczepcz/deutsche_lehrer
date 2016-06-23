<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Repeater;
use AppBundle\Form\RepeaterType;

/**
 * Repeater controller.
 *
 * @Route("/repeater")
 */
class RepeaterController extends Controller
{

    /**
     * Lists all Repeater entities.
     *
     * @Route("/", name="repeater")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Repeater')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Repeater entity.
     *
     * @Route("/", name="repeater_create")
     * @Method("POST")
     * @Template("AppBundle:Repeater:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Repeater();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('repeater_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Repeater entity.
     *
     * @param Repeater $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Repeater $entity)
    {
        $form = $this->createForm(new RepeaterType(), $entity, array(
            'action' => $this->generateUrl('repeater_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Repeater entity.
     *
     * @Route("/new", name="repeater_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Repeater();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Repeater entity.
     *
     * @Route("/{id}", name="repeater_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Repeater')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repeater entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Repeater entity.
     *
     * @Route("/{id}/edit", name="repeater_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Repeater')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repeater entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Repeater entity.
    *
    * @param Repeater $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Repeater $entity)
    {
        $form = $this->createForm(new RepeaterType(), $entity, array(
            'action' => $this->generateUrl('repeater_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Repeater entity.
     *
     * @Route("/{id}", name="repeater_update")
     * @Method("PUT")
     * @Template("AppBundle:Repeater:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Repeater')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Repeater entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('repeater_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Repeater entity.
     *
     * @Route("/{id}", name="repeater_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Repeater')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Repeater entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('repeater'));
    }

    /**
     * Creates a form to delete a Repeater entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repeater_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
