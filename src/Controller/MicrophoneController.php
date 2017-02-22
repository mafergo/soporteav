<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Microphone;
use US\Soporteav\Repository\MicrophoneRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MicrophoneController
{

    /**
     * @var microphoneRepository
     */
    #protected $personRepository;
    protected $microphoneRepository;

    /**
     * @param MicrophoneRepository $microphoneRepository
     */
    function __construct(MicrophoneRepository $microphoneRepository)
    {
        $this->microphoneRepository = $microphoneRepository;
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
        $total = $this->microphoneRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $microphones = $this->microphoneRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('microphone/microphone_index.html.twig', array(
            'microphones' => $microphones,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('microphones'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var Microphone $microphone */
        $microphone = $this->microphoneRepository->find($id);
        if ($microphone) {
             $response = $app['twig']->render('microphone/microphone_view.html.twig', array(
                'microphone' => $microphone
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
        return $app->redirect($app['url_generator']->generate('microphone'));
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
            $microphone = $this->microphoneRepository->find($data['id']);
            $microphone->setName($data['room_id']);
            $microphone->setDescription($data['description']);
            $message = "Microphone data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $microphone = new Microphone($data);
            $message = "Microphone has been created"; // in case of success
            $redirect = $app['url_generator']->generate('microphone_add'); // in case of failure
        }
        $this->microphoneRepository->save($microphone);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($microphone);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->microphoneRepository->save($microphone);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('microphone_view', array('id' => $microphone->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('microphone/microphone_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Microphone id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Microphone $microphone */
        $microphone = $this->microphoneRepository->find($id);
        if ($microphone) {
            $response = $app['twig']->render('microphone/microphone_edit.html.twig', array(
                'microphone' => $microphone));
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
        /** @var Microphone $microphone */
        $microphone = $this->microphoneRepository->find($id);
        if ($microphone) {
            $this->microphoneRepository->delete($microphone);
            $response = $app->redirect($app['url_generator']->generate('microphone'));
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