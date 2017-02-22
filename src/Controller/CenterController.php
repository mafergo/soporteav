<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Center;
use US\Soporteav\Repository\CenterRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CenterController
{

    /**
     * @var centerRepository
     */
    #protected $centerRepository;
    protected $centerRepository;

    /**
     * @param CenterRepository $centerRepository
     */
    function __construct(CenterRepository $centerRepository)
    {
        $this->centerRepository = $centerRepository;
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
        $total = $this->centerRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $centers = $this->centerRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('center/center_index.html.twig', array(
            'centers' => $centers,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('centers'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var center $center */
        $center = $this->centerRepository->find($id);
        if ($center) {
             $response = $app['twig']->render('center/center_view.html.twig', array(
                'center' => $center
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
        return $app->redirect($app['url_generator']->generate('centers'));
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return RedirectResponse
     */
    public function saveAction(Request $request, Application $app)
    {
        $data['name'] = $request->get('name');
        $data['description'] = $request->get('description');

        if ($data['id'] = $request->get('id')) {
            /** @var Center $center */
            $center = $this->centerRepository->find($data['id']);
            $center->setName($data['name']);
            $center->setDescription($data['description']);
            $message = "Center data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('center_edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $center = new Center($data);
            $message = "Center has been created"; // in case of success
            $redirect = $app['url_generator']->generate('center_add'); // in case of failure
        }
        $this->centerRepository->save($center);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($center);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->centerRepository->save($center);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('center_view', array('id' => $center->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('center/center_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Center id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Penter $center */
        $center = $this->centerRepository->find($id);
        if ($center) {
            $response = $app['twig']->render('center/center_edit.html.twig', array(
                'center' => $center));
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
        /** @var Center $center */
        $center = $this->centerRepository->find($id);
        if ($center) {
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