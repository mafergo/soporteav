<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Unittech;
use US\Soporteav\Repository\UnittechRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UnittechController
{

    /**
     * @var unittechRepository
     */
    #protected $unittechRepository;
    protected $unittechRepository;

    /**
     * @param UnittechRepository $unittechRepository
     */
    function __construct(UnittechRepository $unittechRepository)
    {
        $this->unittechRepository = $unittechRepository;
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
        $total = $this->unittechRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $unittechs = $this->unittechRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('unittech/unittech_index.html.twig', array(
            'unittechs' => $unittechs,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('unittechs'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var unittech $unittech */
        $unittech = $this->unittechRepository->find($id);
        if ($unittech) {
             $response = $app['twig']->render('unittech/unittech_view.html.twig', array(
                'unittech' => $unittech
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
        return $app->redirect($app['url_generator']->generate('unittechs'));
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
            /** @var Unittech $unittech */
            $unittech = $this->unittechRepository->find($data['id']);
            $unittech->setName($data['name']);
            $unittech->setDescription($data['description']);
            $message = "Unittech data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('unittech_edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $unittech = new Unittech($data);
            $message = "Unittech has been created"; // in case of success
            $redirect = $app['url_generator']->generate('unittech_add'); // in case of failure
        }
        $this->unittechRepository->save($unittech);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($unittech);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->unittechRepository->save($unittech);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('unittech_view', array('id' => $unittech->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('unittech/unittech_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Unittech id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Penter $unittech */
        $unittech = $this->unittechRepository->find($id);
        if ($unittech) {
            $response = $app['twig']->render('unittech/unittech_edit.html.twig', array(
                'unittech' => $unittech));
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
        /** @var Unittech $unittech */
        $unittech = $this->unittechRepository->find($id);
        if ($unittech) {
            $this->unittechRepository->delete($unittech);
            $response = $app->redirect($app['url_generator']->generate('unittech'));
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