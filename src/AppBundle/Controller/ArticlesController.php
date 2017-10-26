<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Dictionary;
use AppBundle\Form\ArticleType;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Article controller.
 *
 * @Route("dictionary/{dictionary}/article")
 */
class ArticlesController extends FOSRestController
{
    /**
     * @param Dictionary $dictionary
     * @return Response
     */
    public function getArticlesAction(Dictionary $dictionary)
    {
        return $this->handleView($this->view($dictionary->getArticles(), 200));
    }

    /**
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Dictionary $dictionary
     * @param Request $request
     * @return Response
     */
    public function postArticlesAction(Dictionary $dictionary, Request $request)
    {
        $article = new Article();
        $article->setDictionary($dictionary);
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute(
                'get_dictionary_article',
                [
                    'dictionary' => $dictionary->getId(),
                    'article' => $article->getId(),
                ]
            );
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * @param Article $article
     * @return Response
     */
    public function getArticleAction(Dictionary $dictionary, Article $article)
    {
        return $this->handleView($this->view($article, 200));
    }

    /**
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function putArticleAction(Dictionary $dictionary, Article $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute(
                'get_dictionary_article',
                [
                    'dictionary' => $article->getDictionary()->getId(),
                    'article' => $article->getId(),
                ]
            );
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Article $article
     * @return Response
     */
    public function deleteArticleAction(Dictionary $dictionary, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->handleView($this->view(null, 204));
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
}
