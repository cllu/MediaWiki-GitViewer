<?php

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

function substr_startswith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

/**
 * Class GitViewerPage
 *
 * we hook the the MediaWiki::performRequest
 */
class GitViewerPage extends ErrorPageError {
    public $url;
    public $gitViewer;

    public function __construct($url) {
        $this->url = $url;

        $config = GitList\Config::fromFile(__DIR__ . '/config.ini');
        $gitViewer = new GitList\Application($config, __DIR__);
        // Mount the controllers
        $gitViewer->mount('', new GitList\Controller\MainController());
        $gitViewer->mount('', new GitList\Controller\BlobController());
        $gitViewer->mount('', new GitList\Controller\CommitController());
        $gitViewer->mount('', new GitList\Controller\TreeController());
        $gitViewer->mount('', new GitList\Controller\NetworkController());
        $gitViewer->mount('', new GitList\Controller\TreeGraphController());

        if (!is_writable(__DIR__ . DIRECTORY_SEPARATOR . 'cache')) {
            die(sprintf('The "%s" folder must be writable for GitList to run.', __DIR__ . DIRECTORY_SEPARATOR . 'cache'));
        }

        $this->gitViewer = $gitViewer;
    }

    public function report() {
        global $wgOut;

        $request = SymfonyRequest::create($this->url);
        $response = $this->gitViewer->handle($request);

        $wgOut->addHeadItem('FontAwesome', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />');
        $wgOut->addHeadItem('Bootstrap', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/css/bootstrap.min.css" />');
        $wgOut->setPageTitle("Git");
        $wgOut->addHTML($response->getContent());
        $wgOut->output();
    }
}

class GitViewer {
    /**
     * If a page title starts with git, that is a signal for us to take over control
     */
    public static function onBeforeInitialize(&$title, &$article, &$output, &$user, $request, $mediaWiki) {
        $url = $request->getRequestURL();
        //print_r($request->detectServer());
        $host = $_SERVER['HTTP_HOST'];
        if (strtolower(substr($host, 0, 4)) === "git.") {
            throw new GitViewerPage($url);
        }
        return true;
    }

    private function __construct() {
    }
}
