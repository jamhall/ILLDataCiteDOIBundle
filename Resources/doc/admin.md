Web administration interface
----------------------------

We provide a web administration interface to manage your DOIs.

It allows you to upload and edit existing metadata using a dynamic AJAX driven (jQuery and knockoutjs) form and transfer direct to datacite.

You can also mark metadata as inactive, associate media to a DOI, register a DOI to metadata and much more.

It is currently a work in progress.


To enable to web interface, add this to your routing.yml file (choose any prefix you wish):

```
ill_date_cite_doi:
    resource: "@ILLDataCiteDOIBundle/Controller/"
    type:     annotation
    prefix:   /doi
```
    
The routes that are exposed:

```
/admin/doi - show all dois (including pagination)
/admin/doi/{id} - show a doi (details page)
/admin/doi/{id}/metadata - show metadata
/admin/doi/{id}/metadata.xml - show xml representation of metadata
/admin/doi/{id}/metadata/inactive - mark metadata as inactive
/admin/doi/{id}/metadata/edit - edit metadata
/admin/doi/{id}/metadata/edit.js - get json representation of metadata
/admin/doi/{id}/media - show all media
/admin/doi/{id}/media/edit - edit media
/admin/doi/{id}/media/create - create media
/admin/doi/metadata/register - register new metadata
```
If you require user authorisation to access these routes, then update the firewall settings in your security.xml file.
