<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Domain\Model;


/**
 * This file is part of the "membershipext" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * Tag
 */
class Tag extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * nametag
     *
     * @var string
     */
    protected $nametag;

    /**
     * descriptiontag
     *
     * @var string
     */
    protected $descriptiontag;

    /**
     * Returns the nametag
     *
     * @return string
     */
    public function getNametag()
    {
        return $this->nametag;
    }

    /**
     * Sets the nametag
     *
     * @param string $nametag
     * @return void
     */
    public function setNametag(string $nametag)
    {
        $this->nametag = $nametag;
    }

    /**
     * Returns the descriptiontag
     *
     * @return string
     */
    public function getDescriptiontag()
    {
        return $this->descriptiontag;
    }

    /**
     * Sets the descriptiontag
     *
     * @param string $descriptiontag
     * @return void
     */
    public function setDescriptiontag(string $descriptiontag)
    {
        $this->descriptiontag = $descriptiontag;
    }
}
