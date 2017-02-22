<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\New;
use US\Soporteav\Repository\NewRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewController
{

    /**
     * @var newRepository
     */
    protected $newRepository;

    /**
     * @param NewRepository $newRepository
     */
    function __construct(NewRepository $newRepository)
    {
        $this->newRepository = $newRepository;
    }

    /**
     * function indexAction
     * @param Application $app
     * @param $page
     * @param $limit
     * @return Response
     */
    public function indexAction(Application $app, $page, $limit)
    {
        $criteria = array();
        $orderBy = array();
        // Paginación
        $currentPage = $page;
        $total = $this->newRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $news = $this->newRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('new/new_index.html.twig', array(
            'news' => $news,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('news'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var Person $person */
        $new = $this->newRepository->find($id);
        if ($new) {
             $response = $app['twig']->render('new/new_view.html.twig', array(
                'new' => $new
            ));
        } else {
            $response = $this->redirectOnInvalidId($app, $id);
        }

        return $response;
    }

    /**
     * @param Application $app
     * @param $id
     * @return RedirectResponse
     */
    private function redirectOnInvalidId(Application $app, $id)
    {
        $message = "There is no record for ID " . $id;
        $app['session']->getFlashBag()->add('danger', $message);
        return $app->redirect($app['url_generator']->generate('people'));
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return RedirectResponse
     */
    public function saveAction(Request $request, Application $app)
    {
        $data['title'] = $request->get('title');
        $data['subtitle'] = $request->get('subtitle');
        $data['content'] = $request->get('content');
        $data['date'] = $request->get('date');
        $data['date_start'] = $request->get('date _start');
        $data['date_end'] = $request->get('date_end');
        $data['correct'] = $request->get('correct');
        $data['author'] = $request->get('author');

        if ($data['id'] = $request->get('id')) {
            /** @var Person $person */
            $new = $this->centerRepository->find($data['id']);
            $new->setTitle($data['title']);
            $new->setSubtitle($data['subtitle']);
            $new->setContent($data['content']);
            $new->setData($data['date']);
            $new->setDataStart($data['date_start']);
            $new->setDataEnd($data['date_end']);
            $new->setCorrect($data['correct']);
            $new->setAuthor($data['Author']);
            $message = "New data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('new_edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $new = new New($data);
            $message = "Center has been created"; // in case of success
            $redirect = $app['url_generator']->generate('new_add'); // in case of failure
        }
        $this->newRepository->save($new);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($new);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->newRepository->save($new);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('new_view', array('id' => $new->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('new/new_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id New id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Person $person */
        $new = $this->newRepository->find($id);
        if ($new) {
            $response = $app['twig']->render('new/new_edit.html.twig', array(
                'new' => $new));
        } else {
            $response = $this->redirectOnInvalidId($app, $id);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Application $app)
    {
        $id = $request->get('id');
        /** @var New $new */
        $new = $this->newRepository->find($id);
        if ($new) {
            $this->centerRepository->delete($center);
            $response = $app->redirect($app['url_generator']->generate('center'));
        } else {
            $response = $this->redirectOnInvalidId($app, $id);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return Response/ResponseRedirect
     */
    
}