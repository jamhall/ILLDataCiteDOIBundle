<?php

namespace ILL\DataCiteDOIBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DOIRepository extends EntityRepository
{
	/**
	 * Get a proposal by its DOI
	 * @param  string $proposalNumber
	 * @return DOI
	 */
	public function getProposal($proposalNumber) {
		$doi = $this->getEntityManager()
                 ->createQuery("SELECT d FROM ILLDOIBundle:DOI d WHERE d.objectId = :proposalNumber AND d.type = :type")
                 ->setParameter("proposalNumber", $proposalNumber)
                 ->setParameter("type", "PROPOSAL");
		try {
			return $doi->getSingleResult();
		} catch(\Doctrine\ORM\NoResultException $e) {
			return null;
		}
	}
}
