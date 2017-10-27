<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Dictionary;
use AppBundle\Form\ArticleType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
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

            return $this->redirectToRoute('get_article', ['article' => $article->getId()]);
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * @Rest\Get("/articles/{articleId}", name="get_article", options={ "method_prefix" = false })
     *
     * @param Article $article
     * @return Response
     */
    public function getArticleAction(Article $article)
    {
        return $this->handleView($this->view($article, 200));
    }

    /**
     * @Rest\Put("/articles/{articleId}", name="put_article", options={ "method_prefix" = false })
     *
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function putArticleAction(Article $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('get_article', ['article' => $article->getId()]);
        }

        return $this->handleView($this->view($form, 406));
    }

    /**
     * @Rest\Delete("/articles/{articleId}", name="delete_article", options={ "method_prefix" = false })
     * @ Security("has_role('ROLE_ADMIN')")
     * @param Article $article
     * @return Response
     */
    public function deleteArticleAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->handleView($this->view(null, 204));
    }

    /**
     * Search article by title
     *
     * @Rest\Get("articles/search")
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
