<?php

declare(strict_types=1);

namespace membershipext\Membershipext\Domain\Repository;


use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
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
        /** @var QuerySettingsInterface $querySettings */
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        // Show comments from all pages
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    


   public function findByFilters(string $search = '', array $categories = []): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $constraints = [];

        // Search filter
        if (!empty($search)) {
            $constraints[] = $query->logicalOr(
                $query->like('city', '%' . $search . '%'),
                $query->like('street', '%' . $search . '%'),
                $query->like('email', '%' . $search . '%'),
                $query->like('phone', '%' . $search . '%')
            );
            // Add more fields to search as needed, e.g., $query->like('city', '%' . $search . '%')
        }
        // Category filter
        if (!empty($categories)) {
            $constraints[] = $query->in('categories.uid', $categories);
        }
        
        if (!empty($constraints)) {
            $query->matching($query->logicalOr(...$constraints));
        }

        return $query->execute();

    }

}
