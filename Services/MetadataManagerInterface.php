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

use ILL\DataCiteDOIBundle\Model\Metadata;

/**
 * An interface for DOI Metadata API methods. Please refer to the API documentation:
 * https://mds.datacite.org/static/apidoc
 * @author Jamie Hall <hall@ill.eu>
 */
interface MetadataManagerInterface
{
    /**
     * Create metadata
     * @param  Metadata $metadata
     * @return object   Metadata
     */
    public function create(Metadata $metadata);

    /**
     * Update Metadata for a DOI
     * @param  DOI      $doi
     * @param  Metadata $metadata
     * @return object   Metadata
     */
    public function update(DOI $doi, Metadata $metadata);

    /**
     * Find metadata for a DOI
     * @param  string $id
     * @return object Metadata
     */
    public function find($id);

    /**
     * Check if metadata exists for a DOI
     * @param  string  $id
     * @return boolean
     */
    public function exists($id);

    /**
     * Delete metadata for a DOI
     * This request marks a dataset as 'inactive'.
     * To activate it again, POST new metadata or set the isActive-flag in the user interface.
     * @param  string  $id
     * @return boolean
     */
    public function delete($id);
}
