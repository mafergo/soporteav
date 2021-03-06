<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Pc;
use US\Soporteav\Repository\PcRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PcController
{

    /**
     * @var pcRepository
     */
    #protected $personRepository;
    protected $pcRepository;

    /**
     * @param PcRepository $pcRepository
     */
    function __construct(PcRepository $pcRepository)
    {
        $this->pcRepository = $pcRepository;
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
        $total = $this->pcRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $pcs = $this->pcRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('pc/pc_index.html.twig', array(
            'pcs' => $pcs,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('pcs'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var Pc $pc */
        $pc = $this->pcRepository->find($id);
        if ($pc) {
             $response = $app['twig']->render('pc/pc_view.html.twig', array(
                'pc' => $pc
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
        return $app->redirect($app['url_generator']->generate('pc'));
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
            $pc = $this->pcRepository->find($data['id']);
            $pc->setName($data['room_id']);
            $pc->setDescription($data['description']);
            $message = "Pc data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $pc = new Pc($data);
            $message = "Pc has been created"; // in case of success
            $redirect = $app['url_generator']->generate('pc_add'); // in case of failure
        }
        $this->pcRepository->save($pc);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($pc);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->pcRepository->save($pc);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('pc_view', array('id' => $pc->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('pc/pc_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Pc id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Pc $pc */
        $pc = $this->pcRepository->find($id);
        if ($pc) {
            $response = $app['twig']->render('pc/pc_edit.html.twig', array(
                'pc' => $pc));
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
        /** @var Pc $pc */
        $pc = $this->pcRepository->find($id);
        if ($pc) {
            $this->pcRepository->delete($pc);
            $response = $app->redirect($app['url_generator']->generate('pc'));
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