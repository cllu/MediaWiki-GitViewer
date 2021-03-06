<?php

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Class GitViewerPage
 *
 * we hook the the MediaWiki::performRequest
 */
class GitViewerPage extends ErrorPageError {
    public $url;
    public $gitViewer;

    public function __construct($url, $prefix = '/~') {
        $this->url = $url;

        $config = GitList\Config::fromFile(__DIR__ . '/config.ini');
        $gitViewer = new GitList\Application($config, __DIR__);
        // Mount the controllers
        $gitViewer->mount($prefix, new GitList\Controller\TreeGraphController());
        $gitViewer->mount($prefix, new GitList\Controller\NetworkController());
        $gitViewer->mount($prefix, new GitList\Controller\MainController());
        $gitViewer->mount($prefix, new GitList\Controller\BlobController());
        $gitViewer->mount($prefix, new GitList\Controller\CommitController());
        $gitViewer->mount($prefix, new GitList\Controller\TreeController());

        if (!is_writable(__DIR__ . DIRECTORY_SEPARATOR . 'cache')) {
            die(sprintf('The "%s" folder must be writable for GitList to run.', __DIR__ . DIRECTORY_SEPARATOR . 'cache'));
        }

        $this->gitViewer = $gitViewer;
    }

    public function report() {
        global $wgOut;

        $request = SymfonyRequest::create($this->url);
        $response = $this->gitViewer->handle($request);

        $contentType = $response->headers->get("content-type");
        if ('text/html; charset=UTF-8' === $contentType) {
            $wgOut->addModules('ext.GitViewer');
            $wgOut->addHeadItem('FontAwesome', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />');
            $wgOut->setPageTitle("GitViewer");
            $wgOut->addHTML($response->getContent());
            $wgOut->output();
        } else {
            echo $response->getContent();
        }
    }
}

class GitViewer {
    /**
     * If a page title starts with git, that is a signal for us to take over control
     */
    public static function onBeforeInitialize(&$title, &$article, &$output, &$user, $request, $mediaWiki) {
        global $wgUser;
        // only allow sysop users to access the git pages
        if (!in_array('sysop', $wgUser->getGroups())) {
            return false;
        }
        $url = $request->getRequestURL();
        if ((substr($url, 0, 3)) === "/~/") {
            throw new GitViewerPage($url);
        }
        return true;
    }

    private function __construct() {
    }
}
