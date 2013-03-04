<?php
/*
* This file is part of the ILLDataCiteDOIBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @License  MIT License
*/

namespace ILL\DataCiteDOIBundle\Services;

use ILL\DataCiteDOIBundle\Model\DOI;

/**
 * An interface for DOI API methods. Please refer to the API documentation:
 * https://mds.datacite.org/static/apidoc
 * @author Jamie Hall <hall@ill.eu>
 */
interface DOIManagerInterface
{
    /**
     * Create a DOI
     * @param  DOI    $doi
     * @return object DOI
     */
    public function create(DOI $doi);

    /**
     * Update a DOIs URL
     * @param  DOI    $doi;
     * @return object DOI
     */
    public function update(DOI $doi);

    /**
     * Find a DOI by its identifier
     * @param  string $id
     * @return object DOI
     */
    public function find($id);
}
