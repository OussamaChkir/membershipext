<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3Fluid\Fluid\View\StandaloneView;
use \Membershipext\Domain\Repository\MembershipRepository;
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
        $memberships = $this->membershipRepository->findByFilters($search, $categories, $query);

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
        $selectedCategories = $this->request->hasArgument('categories') ? (array)$this->request->getArgument('categories') : [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $categories = $queryBuilder->select('title', 'uid')->from('sys_category')->executeQuery()->fetchAllAssociative();
        if (!empty($search)) {
            $memberships = $this->membershipRepository->findByFilters($search, $selectedCategories);
            
        } else {
            $memberships = $this->membershipRepository->findByFilters($search, $selectedCategories);
        }

        $this->view->assignMultiple([
            'memberships' => $memberships,
            'search' => $search,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
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