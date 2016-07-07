# Dropbox-API-v2
PHP class for Dropbox API v.2
Class for working with Second Version of Dropbox API. It uses POST method by Curl library.

For running the function <b>get_shared_links</b> 
wich post data from https://api.dropboxapi.com/2/sharing/get_shared_links 
use this: $dbxAPI->sharing->get_shared_links($yourData);

You can put an array or separated values as agruments to functions.
For example, you can use:

  $yourData = array('path'=>'/SomeFolder/subFolder');
  $dbxAPI->sharing->get_shared_links($yourData);
  
or simple

  $dbxAPI->sharing->get_shared_links('/SomeFolder/subFolder');

Both aproaches are the same.

Please use an array as input agrument if you want to set flags.
