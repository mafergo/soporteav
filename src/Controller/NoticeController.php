<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Notice;
use US\Soporteav\Repository\NoticeRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NoticeController
{

    /**
     * @var noticeRepository
     */
    protected $noticeRepository;

    /**
     * @param NoticeRepository $noticeRepository
     */
    function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
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
        $total = $this->noticeRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $notices = $this->noticeRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('notice/notice_index.html.twig', array(
            'notices' => $notices,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('notices'),
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
        $notice = $this->noticeRepository->find($id);
        if ($notice) {
             $response = $app['twig']->render('notice/notice_view.html.twig', array(
                'notice' => $notice
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
            $notice = $this->centerRepository->find($data['id']);
            $notice->setTitle($data['title']);
            $notice->setSubtitle($data['subtitle']);
            $notice->setContent($data['content']);
            $notice->setData($data['date']);
            $notice->setDataStart($data['date_start']);
            $notice->setDataEnd($data['date_end']);
            $notice->setCorrect($data['correct']);
            $notice->setAuthor($data['Author']);
            $message = "Notice data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('notice_edit', $data); // in case of failure
        } else {
            $data['startDate'] = notice \DateTime();
            $notice = new Notice($data);
            $message = "Center has been created"; // in case of success
            $redirect = $app['url_generator']->generate('notice_add'); // in case of failure
        }
        $this->noticeRepository->save($notice);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($notice);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->noticeRepository->save($notice);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('notice_view', array('id' => $notice->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('notice/notice_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Notice id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Person $person */
        $notice = $this->noticeRepository->find($id);
        if ($notice) {
            $response = $app['twig']->render('notice/notice_edit.html.twig', array(
                'notice' => $notice));
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
        /** @var Notice $notice */
        $notice = $this->noticeRepository->find($id);
        if ($notice) {
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