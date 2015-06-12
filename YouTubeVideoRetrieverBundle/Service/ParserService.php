<?php
namespace YouTubeVideoRetrieverBundle\Service;

use YouTubeVideoRetrieverBundle\Parameters\RegExList;

/**
 * Normalize and handle string chunks
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class ParserService
{
    /**
     * Format Keywords for url insertion
     * @param string $keywords
     * @return string
     */
    public function normalizeKeywords($keywords)
    {
        $keywords = trim($keywords);
        $keywords = preg_replace('/[^(A-Za-z0-9-_#?\s)+]/', '', $keywords);
        $keywords = preg_replace('!\s+!', ' ', $keywords);
        $keywords = str_replace(' ', '+', $keywords);
        return $keywords;
    }

    /**
     * Parse and extract Ids and Title from a listing HTML String
     * @param string $content
     * @return array
     * @throws \Exception
     */
    public function getIdsFromSearch($content)
    {
        return $this->extractFromList($content);
    }

    /**
     * Get Details of a Video
     *
     * @param string $content
     * @return array
     * @throws \Exception
     */
    public function getVideoDetails($content)
    {
        $listExpressions = RegExList::getVideoDetailsExpressions();
        if (empty($listExpressions)) {
            throw new \Exception('No expressions defined for video_details!');
        }
        $results = array();
        foreach ($listExpressions as $member) {
            $exp = RegExList::$$member;
            switch ($exp['type']) {
                case ('single'):
                    $search_results = $this->handleSingleResultSearch($exp, $content);
                    break;
                case ('multiple'):
                    $search_results = $this->handleMultipleResultSearch($exp, $content);
                    break;
            }
            $results = array_merge($results, $search_results);
        }
        return $results;
    }

    /**
     * Does single line matches for an expression
     * @param array $expression
     * @param string $content
     * @return array
     */
    private function handleSingleResultSearch($expression, $content)
    {
        $results = array();
        $preg_results = array();
        \preg_match($expression['expr'], $content, $preg_results);
        $results[$expression['key']] = false;
        if (!is_array($expression['result_key'])) {
            if (isset($preg_results[$expression['result_key']])) {
                $results[$expression['key']] = $preg_results[$expression['result_key']];
            }
        } else {
            foreach ($expression['result_key'] as $key => $result_key) {
                $results[$expression['key']][$key] = false;
                if (isset($preg_results[$result_key])) {
                    $results[$expression['key']][$key] = $preg_results[$result_key];
                }
            }
        }
        return $results;
    }

    /**
     * Does multple line matches for an expression
     * @param array $expression
     * @param string $content
     * @return array
     */
    protected function handleMultipleResultSearch($expression, $content)
    {
        $results = array();
        $preg_results = array();
        \preg_match_all($expression['expr'], $content, $preg_results);
        $results[$expression['key']] = false;
        if (isset($preg_results[$expression['result_key']])) {
            $results[$expression['key']] = $preg_results[$expression['result_key']];
        }
        return $results;
    }

    /**
     * Parse and extract YouTube Video IDs from a listing HTML String
     * @param string $content
     * @return array
     * @throws \Exception
     */
    protected function extractFromList($content)
    {
        $results = array();
        \preg_match_all(RegExList::$video_list['expr'], $content, $results, \PREG_SET_ORDER);
        if (empty($results)) {
            throw new \Exception('No items found for current content!');
        }
        foreach ($results as $key => $result) {
            $results[$key] = $result[RegExList::$video_list['result_key']];
        }
        return $results;
    }
}
