<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Dictionary;
use AppBundle\Form\DictionaryType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dictionary controller.
 */
class DictionariesController extends FOSRestController
{
    /**
     * @return Response
     */
    public function getDictionariesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dictionaries = $em->getRepository('AppBundle:Dictionary')->findAll();

        return $this->handleView($this->view($dictionaries, 200));
    }

    /**
     * Creates a new dictionary entity.
     *
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return Response
     */
    public function postDictionariesAction(Request $request)
    {
        $dictionary = new Dictionary();
        $form = $this->createForm(DictionaryType::class, $dictionary);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();

            return $this->redirectToRoute('get_dictionary', ['dictionary' => $dictionary->getId()]);
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * @param Dictionary $dictionary
     * @return Response
     */
    public function getDictionaryAction(Dictionary $dictionary)
    {
        return $this->handleView($this->view($dictionary, 200));
    }

    /**
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Dictionary $dictionary
     * @param Request $request
     * @return Response
     */
    public function putDictionaryAction(Dictionary $dictionary, Request $request)
    {
        $form = $this->createForm(DictionaryType::class, $dictionary);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dictionary);
            $em->flush();

            return $this->redirectToRoute('get_dictionary', ['dictionary' => $dictionary->getId()]);
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * Deletes a dictionary entity.
     *
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Dictionary $dictionary
     * @return Response
     */
    public function deleteDictionaryAction(Dictionary $dictionary)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($dictionary);
        $em->flush();

        return $this->handleView($this->view(null, 204));
    }
}
