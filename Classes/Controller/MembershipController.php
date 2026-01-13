<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Fluid\View\StandaloneView;
use \Membershipext\Domain\Repository\MembershipRepository;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * This file is part of the "membershipext" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * MembershipController
 */
class MembershipController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $nonCacheableActions = ['ajaxList'];
    /**
     * @var \membershipext\Membershipext\Domain\Repository\MembershipRepository
     */
    protected $membershipRepository;

    protected $categoryRepository;

    public function __construct()
    {
    }

    /**
     * @param \membershipext\Membershipext\Domain\Repository\MembershipRepository $membershipRepository
     */
    public function injectMembershipRepository(\membershipext\Membershipext\Domain\Repository\MembershipRepository $membershipRepository)
    {
        $this->membershipRepository = $membershipRepository;
    }

    /**
     * New AJAX action for filtering
     */
    public function ajaxListAction(): \Psr\Http\Message\ResponseInterface
    {
        $search = $this->request->hasArgument('search') ? trim($this->request->getArgument('search')) : '';
        $categories = $this->request->hasArgument('categories') ? (array) $this->request->getArgument('categories') : [];

        // Fetch memberships with limit
        $query = $this->membershipRepository->createQuery();
        $query->setLimit(50); // Prevent timeout; adjust as needed
        $memberships = $this->membershipRepository->findByFilters($search, $categories);

        // Render Fluid template
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename('EXT:membershipext/Resources/Private/Templates/Membership/AjaxList.html');
        $view->assignMultiple([
            'memberships' => $memberships,
            'search' => $search
        ]);

        return new JsonResponse([
            'success' => true,
            'html' => $view->render(),
            'count' => count($memberships)
        ]);
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $search = $this->request->hasArgument('search') ? $this->request->getArgument('search') : '';
        $selectedCategories = $this->request->hasArgument('categories') ? (array) $this->request->getArgument('categories') : [];
        $offset = $this->request->hasArgument('offset') ? (int) $this->request->getArgument('offset') : 0;
        $limit = 3;

        file_put_contents(
            \TYPO3\CMS\Core\Core\Environment::getProjectPath() . '/var/debug_members.txt',
            "Args: " . print_r($this->request->getArguments(), true) . "\n" .
            "Offset: $offset\n",
            FILE_APPEND
        );

        // pagination
        $limit = 3;
        $offset = $this->request->hasArgument('offset') ? (int) $this->request->getArgument('offset') : 0;

        // categories
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $categories = $queryBuilder->select('title', 'uid')->from('sys_category')->executeQuery()->fetchAllAssociative();
        // memberships
        $memberships = $this->membershipRepository
            ->findByFiltersPaginated($search, $selectedCategories, $limit, $offset);

        $totalCount = $this->membershipRepository
            ->countByFilters($search, $selectedCategories);

        file_put_contents(
            \TYPO3\CMS\Core\Core\Environment::getProjectPath() . '/var/debug_members.txt',
            "--- AJAX CALL ---\n" .
            "Offset: $offset\n" .
            "Limit: $limit\n" .
            "Total Count: $totalCount\n" .
            "Result Count: " . count($memberships) . "\n" .
            "Search: $search\n" .
            "Categories: " . print_r($selectedCategories, true) . "\n",
            FILE_APPEND
        );

        // AJAX request → return only HTML
        $isAjax = $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';

        if ($isAjax) {
            $view = GeneralUtility::makeInstance(StandaloneView::class);
            $view->setRequest($this->request);
            $view->setTemplatePathAndFilename(
                'EXT:membershipext/Resources/Private/Templates/Membership/_Items.html'
            );
            $view->assign('memberships', $memberships);

            $response = new JsonResponse([
                'html' => $view->render(),
                'hasMore' => ($offset + $limit) < $totalCount
            ]);

            // Force early exit in TYPO3 v12 by propagating the response
            throw new \TYPO3\CMS\Core\Http\PropagateResponseException($response);
        }

        // normal page load
        $this->view->assignMultiple([
            'memberships' => $memberships,
            'categories' => $categories,
            'search' => $search,
            'selectedCategories' => $selectedCategories,
            'selectedCategoriesString' => implode(',', $selectedCategories),
            'totalCount' => $totalCount,
            'limit' => $limit
        ]);

        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \membershipext\Membershipext\Domain\Model\Membership $membership
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\membershipext\Membershipext\Domain\Model\Membership $membership): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('membership', $membership);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \membershipext\Membershipext\Domain\Model\Membership $newMembership
     */
    public function createAction(\membershipext\Membershipext\Domain\Model\Membership $newMembership): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage(
            'The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html',
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
        );
        $this->membershipRepository->add($newMembership);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \membershipext\Membershipext\Domain\Model\Membership $membership
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("membership")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\membershipext\Membershipext\Domain\Model\Membership $membership): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('membership', $membership);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \membershipext\Membershipext\Domain\Model\Membership $membership
     */
    public function updateAction(\membershipext\Membershipext\Domain\Model\Membership $membership): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage(
            'The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html',
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
        );
        $this->membershipRepository->update($membership);
        return $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \membershipext\Membershipext\Domain\Model\Membership $membership
     */
    public function deleteAction(\membershipext\Membershipext\Domain\Model\Membership $membership): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage(
            'The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html',
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
        );
        $this->membershipRepository->remove($membership);
        return $this->redirect('list');
    }
}