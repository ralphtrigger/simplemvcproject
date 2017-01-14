<?php
namespace SimpleMVCProject\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use SimpleMVCProject\Domain\Article;

/**
 *
 * @author trigger
 *        
 */
class ApiController
{

    /**
     * API articles controller.
     *
     * @param Application $app
     *            Silex application
     * @return \Symfony\Component\HttpFoundation\JsonResponse All articles in JSON format
     */
    public function getArticlesAction(Application $app)
    {
        $articles = $app['dao.article']->findAll();
        // Convert an array of objects ($articles) to an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($articles as $article) {
            $responseData[] = $this->buildArticleArray($article);
        }
        // create and return JSON response
        return $app->json($responseData);
    }

    /**
     * API article details controller.
     *
     * @param integer $id Article id
     * @param Application $app Silex application        
     * @return \Symfony\Component\HttpFoundation\JsonResponse Article details in JSON format
     */
    public function getArticleAction($id, Application $app)
    {
        $article = $app['dao.article']->find($id);
        $responseData = $this->buildArticleArray($article);
        // create and return JSON response
        return $app->json($responseData);
    }

    /**
     * API create article controller.
     *
     * @param Request $request
     *            Incoming request
     * @param Application $app
     *            Silex application
     * @return \Symfony\Component\HttpFoundation\JsonResponse Article details in JSON format
     */
    public function addArticleAction(Request $request, Application $app)
    {
        // Check request parameters
        if (! $request->request->has('title')) {
            return $app->json('Missing required parameter: title', 400);
        }
        if (! $request->request->has('content')) {
            return $app->json('Missing required parameter: content', 400);
        }
        // Build and save a new article
        $article = new Article();
        $article->setTitle($request->request->get('title'));
        $article->setContent($request->request->get('content'));
        $app['dao.article']->save($article);
        // Convert an object ($article) to an associative array ($responseData)
        $responseData = $this->buildArticleArray($article);
        return $app->json($responseData, 201); // 201 = created
    }

    /**
     * API delete article controller.
     *
     * @param integer $id
     *            Article id
     * @param Application $app
     *            Silex application
     */
    public function deleteArticleAction($id, Application $app)
    {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByArticle($id);
        // Delete the article
        $app['dao.article']->delete($id);
        return $app->json('No content', 204); // 204 = no Content
    }

    /**
     * Convert an object ($article) to an associative array for JSON encoding
     *
     * @param Article $article
     *            Article object
     *            
     * @return array Associative array whose fields are the article properties
     */
    private function buildArticleArray(Article $article)
    {
        $data = array(
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        );
        return $data;
    }
}