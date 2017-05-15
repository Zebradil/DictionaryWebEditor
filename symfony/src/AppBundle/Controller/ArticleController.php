<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleComment;
use AppBundle\Entity\Dictionary;
use AppBundle\Entity\Meaning;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Article controller.
 *
 * @Route("dictionary/{dictionary}/article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="article_index")
     * @Method("GET")
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Dictionary $dictionary)
    {
        return $this->render('article/index.html.twig', [
            'articles' => $dictionary->getArticles(),
            'dictionary' => $dictionary,
        ]);
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     *
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @param Dictionary $dictionary
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Dictionary $dictionary)
    {
        $article = new Article();

        $article->setDictionary($dictionary);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute(
                'article_show',
                [
                    'id' => $article->getId(),
                    'dictionary' => $dictionary->getId(),
                ]
            );
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Search article by title
     *
     * @Route("/search", name="article_search")
     * @Method({"GET", "POST"})
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchArticleAction(Request $request)
    {
        $q = $request->query->get('term');
        $results = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findLikeTitle($q);
        return $this->render('article/list_for_select2.json.twig', ['results' => $results]);
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="article_show")
     * @Method("GET")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'delete_form' => $this->createDeleteForm($article)->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     *
     * TODO check article owner
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Article $article)
    {
        $editForm = $this->createForm(ArticleType::class, $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'article_show',
                [
                    'id' => $article->getId(),
                    'dictionary' => $article->getDictionary()->getId(),
                ]
            );
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $editForm->createView(),
            'delete_form' => $this->createDeleteForm($article)->createView(),
        ]);
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     *
     * TODO check article owner
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('dictionary_show', ['dictionary' => $article->getDictionary()]);
    }

    /**
     * Retrieves article's title.
     *
     * @Route("/get_title/{id}", name="article_get_title", defaults={"id": 0})
     * @Method("GET")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param Article $article
     * @return Response
     */
    public function getTitleAction(Article $article = null)
    {
        return new Response($article ? $article->getTitle() : '');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'article_delete',
                    [
                        'id' => $article->getId(),
                        'dictionary' => $article->getDictionary()->getId(),
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
    }
}
