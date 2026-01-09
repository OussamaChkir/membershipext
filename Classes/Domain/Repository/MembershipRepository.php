<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
/**
 * This file is part of the "membershipext" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * The repository for Memberships
 */
class MembershipRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function __construct()
    {
        parent::__construct();
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    


   public function findByFilters(string $search = '', array $categories = []): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = [];

        // Search filter
        if (!empty($search)) {
            $constraints[] = $query->like('street', '%' . $search . '%');
            // Add more fields to search as needed, e.g., $query->like('city', '%' . $search . '%')
        }

        // Category filter
        if (!empty($categories)) {
            $constraints[] = $query->in('categories.uid', $categories);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd($constraints));
        }

        return $query->execute();
    }

    /**
     * Find memberships by search term and categories
     *
     * @param string $search
     * @param array $categories
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findBySearchTermAndCategories(string $search, array $categories): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = [];

        // Search term constraint
        if (!empty($search)) {
            $constraints[] = $query->like('title', '%' . $search . '%'); // Adjust 'title' to your field
        }

        // Category constraint
        if (!empty($categories)) {
            $constraints[] = $query->contains('categories', $categories);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        return $query->execute();
    }

}
