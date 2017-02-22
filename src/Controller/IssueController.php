<?php

namespace US\Soporteav\Controller;

use US\Soporteav\Entity\Room;
use US\Soporteav\Entity\Issue;
use US\Soporteav\Repository\IssueRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IssueController
{

    /**
     * @var issueRepository
     */
    #protected $personRepository;
    protected $issueRepository;

    /**
     * @param IssueRepository $issueRepository
     */
    function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
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
        $orderBy = array("id" => "desc");
        //$orderBy = 'id desc';
        // Paginación
        $currentPage = $page;
        $total = $this->issueRepository->count();
        $numPages = ceil($total / $limit);
        if ($currentPage < 1) {
            $currentPage = 1;
        } else if ($currentPage > $numPages) {
            $currentPage = $numPages;
        }
        $offset = ($currentPage - 1) * $limit;

        $issues = $this->issueRepository->findBy($criteria, $orderBy, $limit, $offset);
        return $app['twig']->render('issue/issue_index.html.twig', array(
            'issues' => $issues,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'url' => $app['url_generator']->generate('issues'),
        ));
    }

    /**
     * @param Application $app
     * @param $id
     * @return Response/RedirectResponse
     */
    public function viewAction(Application $app, $id)
    {
        /** @var Issue $issue */
        $issue = $this->issueRepository->find($id);
        //$issue = $this->issueRepository->find($encryptedId);
        if ($issue) {
             $response = $app['twig']->render('issue/issue_view.html.twig', array(
                'issue' => $issue
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
        return $app->redirect($app['url_generator']->generate('issue'));
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
            /** @var Issue $issue */
            $issue = $this->issueRepository->find($data['id']);
            $issue->setName($data['name']);
            $issue->setDescription($data['description']);
            $message = "Issue data has been updated"; // in case of success
            $redirect = $app['url_generator']->generate('edit', $data); // in case of failure
        } else {
            $data['startDate'] = new \DateTime();
            $issue = new Issue($data);
            $message = "Issue has been created"; // in case of success
            $redirect = $app['url_generator']->generate('issue_add'); // in case of failure
        }
        $this->issueRepository->save($issue);

        // Valida los datos
        // http://silex.sensiolabs.org/doc/providers/validator.html
        /** @var array(ConstraintViolation) $errors */
        $errors = $app['validator']->validate($issue);

        // Check for failure or success
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage();
                $app['session']->getFlashBag()->add('danger', $message);
            }
        } else {
            $this->issueRepository->save($issue);
            $app['session']->getFlashBag()->add('success', $message);
            $redirect = $app['url_generator']->generate('issue_view', array('id' => $issue->getId()));
        }

        return $app->redirect($redirect);
    }

    /**
     * @param Application $app
     * @return Response
     */
    public function addAction(Application $app)
    {

        return $app['twig']->render('issue/issue_add.html.twig');
    }

    /**
     * @param Application $app
     * @param $id Issue id
     * @return Response/ResponseRedirect
     */
    public function editAction(Application $app, $id)
    {
        /** @var Issue $issue */
        $issue = $this->issueRepository->find($id);
        if ($issue) {
            $response = $app['twig']->render('issue/issue_edit.html.twig', array(
                'issue' => $issue));
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
        /** @var Issue $issue */
        $issue = $this->issueRepository->find($id);
        if ($issue) {
            $this->issueRepository->delete($issue);
            $response = $app->redirect($app['url_generator']->generate('issue'));
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