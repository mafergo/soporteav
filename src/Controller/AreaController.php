<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Area;
use US\Soporteav\Repository\AreaRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AreaController
{

    /**
     * @var areaRepository
     */
    #protected $areaRepository;
    protected $areaRepository;

    /**
     * @param AreaRepository $areaRepository
     */
    function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
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
        $total = $this->areaRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $areas = $this->areaRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('area/area_index.html.twig', array(
            'areas' => $areas,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('areas'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var area $area */
        $area = $this->areaRepository->find($id);
        if ($area) {
             $response = $app['twig']->render('area/area_view.html.twig', array(
                'area' => $area
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
        return $app->redirect($app['url_generator']->generate('areas'));
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
            /** @var Area $area */
            $area = $this->areaRepository->find($data['id']);
            $area->setName($data['name']);
            $area->setDescription($data['description']);
            $message = "Area data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('area_edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $area = new Area($data);
            $message = "Area has been created"; // in case of success
            $redirect = $app['url_generator']->generate('area_add'); // in case of failure
        }
        $this->areaRepository->save($area);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($area);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->areaRepository->save($area);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('area_view', array('id' => $area->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('area/area_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Area id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Penter $area */
        $area = $this->areaRepository->find($id);
        if ($area) {
            $response = $app['twig']->render('area/area_edit.html.twig', array(
                'area' => $area));
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
        /** @var Area $area */
        $area = $this->areaRepository->find($id);
        if ($area) {
            $this->areaRepository->delete($area);
            $response = $app->redirect($app['url_generator']->generate('area'));
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