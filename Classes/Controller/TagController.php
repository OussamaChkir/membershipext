<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Controller;


/**
 * This file is part of the "membershipext" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * TagController
 */
class TagController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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
        $tags = $this->tagRepository->findAll();
        $this->view->assign('tags', $tags);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tag
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\membershipext\Membershipext\Domain\Model\Tag $tag): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('tag', $tag);
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
     * @param \membershipext\Membershipext\Domain\Model\Tag $newTag
     */
    public function createAction(\membershipext\Membershipext\Domain\Model\Tag $newTag): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tagRepository->add($newTag);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tag
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("tag")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\membershipext\Membershipext\Domain\Model\Tag $tag): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('tag', $tag);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tag
     */
    public function updateAction(\membershipext\Membershipext\Domain\Model\Tag $tag): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tagRepository->update($tag);
        return $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tag
     */
    public function deleteAction(\membershipext\Membershipext\Domain\Model\Tag $tag): \Psr\Http\Message\ResponseInterface
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->tagRepository->remove($tag);
        return $this->redirect('list');
    }
}
