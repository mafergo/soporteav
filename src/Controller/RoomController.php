<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Room;
use US\Soporteav\Repository\RoomRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomController
{

    /**
     * @var roomRepository
     */
    #protected $roomRepository;
    protected $roomRepository;

    /**
     * @param RoomRepository $roomRepository
     */
    function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
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
        $total = $this->roomRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $rooms = $this->roomRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('room/room_index.html.twig', array(
            'rooms' => $rooms,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('rooms'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var room $room */
        $room = $this->roomRepository->find($id);
        if ($room) {
             $response = $app['twig']->render('room/room_view.html.twig', array(
                'room' => $room
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
        return $app->redirect($app['url_generator']->generate('rooms'));
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
            /** @var Room $room */
            $room = $this->roomRepository->find($data['id']);
            $room->setName($data['name']);
            $room->setDescription($data['description']);
            $message = "Room data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('room_edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $room = new Room($data);
            $message = "Room has been created"; // in case of success
            $redirect = $app['url_generator']->generate('room_add'); // in case of failure
        }
        $this->roomRepository->save($room);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($room);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->roomRepository->save($room);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('room_view', array('id' => $room->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('room/room_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Room id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Penter $room */
        $room = $this->roomRepository->find($id);
        if ($room) {
            $response = $app['twig']->render('room/room_edit.html.twig', array(
                'room' => $room));
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
        /** @var Room $room */
        $room = $this->roomRepository->find($id);
        if ($room) {
            $this->roomRepository->delete($room);
            $response = $app->redirect($app['url_generator']->generate('room'));
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