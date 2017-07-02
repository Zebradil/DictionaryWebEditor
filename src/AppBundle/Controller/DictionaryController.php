<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Dictionary;
use AppBundle\Form\DictionaryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Dictionary controller.
 *
 * @Route("dictionary")
 */
class DictionaryController extends Controller
{
    /**
     * Lists all dictionary entities.
     *
     * @Route("/", name="dictionary_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dictionaries = $em->getRepository('AppBundle:Dictionary')->findAll();

        return $this->render('dictionary/index.html.twig', [
            'dictionaries' => $dictionaries,
        ]);
    }

    /**
     * Creates a new dictionary entity.
     *
     * @Route("/new", name="dictionary_new")
     * @Method({"GET", "POST"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $dictionary = new Dictionary();
        $form = $this->createForm(DictionaryType::class, $dictionary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();

            return $this->redirectToRoute('dictionary_show', ['id' => $dictionary->getId()]);
        }

        return $this->render('dictionary/edit.html.twig', [
            'dictionary' => $dictionary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a dictionary entity.
     *
     * @Route("/{id}", name="dictionary_show")
     * @Method("GET")
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Dictionary $dictionary)
    {
        $deleteForm = $this->createDeleteForm($dictionary);

        return $this->render('dictionary/show.html.twig', [
            'dictionary' => $dictionary,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing dictionary entity.
     *
     * @Route("/{id}/edit", name="dictionary_edit")
     * @Method({"GET", "POST"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Dictionary $dictionary)
    {
        $editForm = $this->createForm(DictionaryType::class, $dictionary);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dictionary_edit', ['id' => $dictionary->getId()]);
        }

        return $this->render('dictionary/edit.html.twig', [
            'dictionary' => $dictionary,
            'form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a dictionary entity.
     *
     * @Route("/{id}", name="dictionary_delete")
     * @Method("DELETE")
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Dictionary $dictionary)
    {
        $form = $this->createDeleteForm($dictionary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dictionary);
            $em->flush();
        }

        return $this->redirectToRoute('dictionary_index');
    }

    /**
     * Lists all articles of particular dictionary
     *
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/article", name="dictionary_article_index")
     */
    public function articlesAction(Dictionary $dictionary)
    {
        return $this->render('dictionary/article_index.html.twig', [
            'dictionary' => $dictionary,
        ]);
    }

    /**
     * Creates a form to delete a dictionary entity.
     *
     * @param Dictionary $dictionary The dictionary entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dictionary $dictionary)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dictionary_delete', ['id' => $dictionary->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
