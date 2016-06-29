<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Deck;
use AppBundle\Form\DeckType;

/**
 * Deck controller.
 *
 * @Route("/deck")
 */
class DeckController extends Controller
{

    /**
     * Lists all Deck entities.
     *
     * @Route("/", name="deck")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Deck')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Deck entity.
     *
     * @Route("/", name="deck_create")
     * @Method("POST")
     * @Template("AppBundle:Deck:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Deck();
        $loggedUser = $this->getUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setUser($loggedUser);
            $loggedUser->addDeck($entity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mainPage'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Deck entity.
     *
     * @param Deck $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Deck $entity)
    {
        $form = $this->createForm(new DeckType(), $entity, array(
            'action' => $this->generateUrl('deck_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Deck entity.
     *
     * @Route("/new", name="deck_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Deck();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Deck entity.
     *
     * @Route("/{id}", name="deck_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Deck')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deck entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Deck entity.
     *
     * @Route("/{id}/edit", name="deck_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Deck')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deck entity.');
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
    * Creates a form to edit a Deck entity.
    *
    * @param Deck $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Deck $entity)
    {
        $form = $this->createForm(new DeckType(), $entity, array(
            'action' => $this->generateUrl('deck_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Deck entity.
     *
     * @Route("/{id}", name="deck_update")
     * @Method("PUT")
     * @Template("AppBundle:Deck:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Deck')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deck entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('deck_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Deck entity.
     *
     * @Route("/{id}", name="deck_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Deck')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Deck entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('deck'));
    }

    /**
     * Creates a form to delete a Deck entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deck_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
