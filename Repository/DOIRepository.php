<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class DOIRepository extends EntityRepository
{
    /**
     * Get all DOIs
     * @param  boolean asPaginator
     * @return DOIs
     */

    public function findAll($asPaginator = false)
    {
        $query = $this->createQueryBuilder('d')
                        ->orderBy('d.created', 'DESC')
                        ->getQuery();

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineORMAdapter($query));
        } else {
            return $query->execute();
        }
    }
}
