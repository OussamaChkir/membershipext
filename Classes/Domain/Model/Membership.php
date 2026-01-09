<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\Category;

/**
 * This file is part of the "membershipext" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * Membership
 */


class Membership extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * street
     *
     * @var string
     */
    protected $street;

    /**
     * zip
     *
     * @var string
     */
    protected $zip;

    /**
     * city
     *
     * @var string
     */
    protected $city;

    /**
     * phone
     *
     * @var string
     */
    protected $phone;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    /**
     * www
     *
     * @var string
     */
    protected $www;

    /**
     * tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\membershipext\Membershipext\Domain\Model\Tag>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $tags;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $categories;


    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->tags = $this->tags ?: new ObjectStorage();
        $this->categories = $this->categories ?: new ObjectStorage();
    }

    /**
     * Returns the street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * Returns the zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Returns the phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns the www
     *
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * Sets the www
     *
     * @param string $www
     * @return void
     */
    public function setWww(string $www)
    {
        $this->www = $www;
    }

    /**
     * Adds a Tag
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tag
     * @return void
     */
    public function addTag(\membershipext\Membershipext\Domain\Model\Tag $tag)
    {
        $this->tags->attach($tag);
    }

    /**
     * Removes a Tag
     *
     * @param \membershipext\Membershipext\Domain\Model\Tag $tagToRemove The Tag to be removed
     * @return void
     */
    public function removeTag(\membershipext\Membershipext\Domain\Model\Tag $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }

    /**
     * Returns the tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\membershipext\Membershipext\Domain\Model\Tag>
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets the tags
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\membershipext\Membershipext\Domain\Model\Tag> $tags
     * @return void
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Adds a category
     *
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a category
     *
     * @param Category $categoryToRemove
     * @return void
     */
    public function removeCategory(Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param ObjectStorage<Category> $categories
     * @return void
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }
}
