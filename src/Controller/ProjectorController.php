<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Projector;
use US\Soporteav\Repository\ProjectorRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectorController
{

    /**
     * @var projectorRepository
     */
    #protected $personRepository;
    protected $projectorRepository;

    /**
     * @param ProjectorRepository $projectorRepository
     */
    function __construct(ProjectorRepository $projectorRepository)
    {
        $this->projectorRepository = $projectorRepository;
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
        //$orderBy = 'id desc';
        // Paginación
        $currentPage = $page;
        $total = $this->projectorRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $projectors = $this->projectorRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('projector/projector_index.html.twig', array(
            'projectors' => $projectors,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('projectors'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var Projector $projector */
        $projector = $this->projectorRepository->find($id);
        if ($projector) {
             $response = $app['twig']->render('projector/projector_view.html.twig', array(
                'projector' => $projector
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
        return $app->redirect($app['url_generator']->generate('projector'));
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
            /** @var Person $person */
            $projector = $this->projectorRepository->find($data['id']);
            $projector->setName($data['room_id']);
            $projector->setDescription($data['description']);
            $message = "Projector data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $projector = new Projector($data);
            $message = "Projector has been created"; // in case of success
            $redirect = $app['url_generator']->generate('projector_add'); // in case of failure
        }
        $this->projectorRepository->save($projector);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($projector);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->projectorRepository->save($projector);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('projector_view', array('id' => $projector->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('projector/projector_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Projector id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Projector $projector */
        $projector = $this->projectorRepository->find($id);
        if ($projector) {
            $response = $app['twig']->render('projector/projector_edit.html.twig', array(
                'projector' => $projector));
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
        /** @var Projector $projector */
        $projector = $this->projectorRepository->find($id);
        if ($projector) {
            $this->projectorRepository->delete($projector);
            $response = $app->redirect($app['url_generator']->generate('projector'));
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