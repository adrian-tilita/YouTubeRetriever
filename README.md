# YouTubeRetriever
Parse and retrieve youtube video details from youtube platform

## Install
Add in composer.json:
```
"require": {
    [..]
    "ytvretriever" : "dev-master"
}
[...]
"repositories" : [
    [...]
    {
        "type" : "vcs",
        "url" : "https://github.com/adrian-tilita/ytvretriever.git"
    }
]
```
Register bundle in AppKernel.php
```
$bundles = array(
    [...]
    new YouTubeVideoRetrieverBundle\YouTubeVideoRetrieverBundle(),
);
```
Clear Cache
```
app/console cache:clear
```
