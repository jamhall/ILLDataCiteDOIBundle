Introduction
============

## Logging

The bundle uses a separate logging file. All requests that are made to the [mds.datacite.org](Datacite API) are logged into a file in your `app/logs` directory.

### Naming convention
The naming convention is `{env}.doi.log`. For example if a request is made in the dev environment, you should look into the `dev.doi.log` file for any debugging purposes.

### Example content of the log
`[2013-02-27 09:40:05] doi.INFO: The DOI with the identifier of 10.5072/TESTDOI was retrieved [] []`

