<?php
namespace YouTubeVideoRetrieverBundle\Service;

use YouTubeVideoRetrieverBundle\Parameters\Config;
use YouTubeVideoRetrieverBundle\Parameters\Options;

/**
 * URL Manager Handles and build URL acording request
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class URLManagerService
{
    /**
     * Get the list of search URLs based on keywords/order/page_ct and offset
     *
     * @param string $keywords
     * @param int $order
     * @param int $page_ct
     * @param int $offset
     * @return array()
     */
    public function getSearchURLs($keywords, $order, $page_ct, $offset)
    {
        switch ($order) {
            case (Options::ORDER_SEARCH_BY_RELEVANCY):
                $order = Config::SEARCH_BY_RELEVANCY;
                break;
            case (Options::ORDER_SEARCH_BY_DATE):
                $order = Config::SEARCH_BY_DATE;
                break;
            case (Options::ORDER_SEARCH_BY_RATING):
                $order = Config::SEARCH_BY_RATING;
                break;
            case (Options::ORDER_SEARCH_BY_VIEWS):
                $order = Config::SEARCH_BY_VIEWS;
                break;
        }
        $base_url = Config::BASE_URL . Config::SEARCH_URL . $keywords . $order . Config::SEARCH_FILTER_VIDEO_TYPE;
        $url_list = array();
        for ($i = $offset; $i <= ($offset + $page_ct) - 1; $i++) {
            $url_list[] = $base_url . Config::SEARCH_PAGE_NR_FILTER . $i;
        }
        return $url_list;
    }

    /**
     * Build the Video page URL
     *
     * @param string $videoId
     * @return string
     */
    public function getVideoUrl($videoId)
    {
        return Config::BASE_URL . Config::VIDEO_DETAILS_PARAMETER . $videoId;
    }
}
