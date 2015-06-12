<?php
namespace YouTubeVideoRetrieverBundle\Service;

use YouTubeVideoRetrieverBundle\Helper\Wget;
use YouTubeVideoRetrieverBundle\Parameters\Options;
use YouTubeVideoRetrieverBundle\Service\ParserService;
use YouTubeVideoRetrieverBundle\Service\URLManagerService;

/**
 * YouTube Video Retriever Service
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class YoutubeVideoRetrieverService
{
    /**
     * Container for injected URLManagerService
     * @var URLManagerService
     */
    protected $url_manager;

    /**
     * Container for Wget Helper
     * @var Wget
     */
    protected $wget_helper;

    /**
     * Container for ParserService
     * @var ParserService
     */
    protected $parser_service;

    /**
     * Search Order
     * @var int
     */
    protected $search_order = Options::ORDER_SEARCH_BY_RELEVANCY;

    /**
     * Default number of pages to be retrieved
     * @var int
     */
    protected $page_ct = 5;

    /**
     * Default offset from which to start the pagination
     * @var int
     */
    protected $offset = 0;
    
    /**
     * Inject The URL Manager Service
     * @param URLManagerService $url_manager
     */
    public function setURLManagerService(URLManagerService $url_manager)
    {
        $this->url_manager = $url_manager;
    }

    /**
     * Retrieve URLManagerService
     * @return URLManagerService
     */
    protected function getUrlManagerService()
    {
        if (empty($this->url_manager)) {
            $this->url_manager = new URLManagerService();
        }
        return $this->url_manager;
    }

    /**
     * Set Wget Helper
     * @param Wget $wget
     */
    public function setWgetHelper(Wget $wget_helper)
    {
        $this->wget_helper = $wget_helper;
    }

    /**
     * Return WgetHelper
     * @return Wget
     */
    protected function getWgetHelper()
    {
        if (empty($this->wget_helper)) {
            $this->wget_helper = new Wget();
        }
        return $this->wget_helper;
    }

    /**
     * Set ParserService
     * @param ParserService $parser_service
     */
    public function setParserService(ParserService $parser_service)
    {
        $this->parser_service = $parser_service;
    }

    /**
     * Return ParserService
     * @return ParserService
     */
    protected function getParserService()
    {
        if (empty($this->parser_service)) {
            $this->parser_service = new ParserService();
        }
        return $this->parser_service;
    }

    /**
     * Set Search Order option
     * @param int $search_order
     * @return \YouTubeVideoRetrieverBundle\Service\YoutubeVideoRetrieverService
     * @throws \Exception
     */
    public function setSearchOrder($search_order)
    {
        $available_options = new Options();
        $available_options = $available_options->getOptions(Options::OPTION_ITEM_SEARCH, Options::OPTION_TYPE_ORDER);
        if (in_array($search_order, $available_options)) {
            $this->search_order = $search_order;
            return $this;
        }
        throw new \Exception('Invalid search order option');
    }

    /**
     * Set the number of pages to be retrieved by a result
     * @param int $page_ct
     * @return \YouTubeVideoRetrieverBundle\Service\YoutubeVideoRetrieverService
     * @throws \Exception
     */
    public function setPageCount($page_ct)
    {
        if (is_int($page_ct) && $page_ct > 0) {
            $this->page_ct = $page_ct;
            return $this;
        }
        throw new \Exception('Invalid page count option');
    }

    /**
     * Set the offset from which to start pagination on page count results
     * @param type $offset
     * @return \YouTubeVideoRetrieverBundle\Service\YoutubeVideoRetrieverService
     * @throws \Exception
     */
    public function setOffset($offset)
    {
        if (is_int($offset) && $offset >= 0) {
            $this->offset = $offset;
            return $this;
        }
        throw new \Exception('Invalid offset option given');
    }

    /**
     * Retrieve a list of video Ids retrieved by a search result
     * @param string $keywords
     * @throws \Exception
     */
    public function search($keywords)
    {
        $keywords = $this->getParserService()->normalizeKeywords($keywords);
        $url_list = $this->getUrlManagerService()->getSearchURLs(
            $keywords,
            $this->search_order,
            $this->page_ct,
            $this->offset
        );
        $content = '';
        foreach ($url_list as $url) {
            $content.= $this->getWgetHelper()->getUrlContent($url);
        }
        return $this->getParserService()->getIdsFromSearch($content);
    }

    /**
     * Retrieve an array with all YouTube Video Details
     * @param string $videoId
     * @return array
     */
    public function getVideoDetails($videoId)
    {
        if (strlen($videoId) !== 11) {
            throw new \Exception('Invalid YouTube Video ID');
        }
        $videoUrl = $this->getUrlManagerService()->getVideoUrl($videoId);
        $content = $this->getWgetHelper()->getUrlContent($videoUrl);
        $videoDetails = $this->getParserService()->getVideoDetails($content);
        return $videoDetails;
    }
}
