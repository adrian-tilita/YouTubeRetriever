<?php
namespace ReadMe;

/**
 * Documentation ReadMe File
 *
 * This file is just as a ReadMe file and usage
 * examples.
 * 
 * Exmple:
 * <code>
 * $yts = $this->get('youtube.video.retriever');
 * try {
 *     $items = $yts->search('8k');
 *     if (!empty($items)) {
 *         $videoDetails = $yts->getVideoDetails($items[0]);
 *         var_dump($videoDetails);
 *     }
 * } catch (\Exception $e) {
 *     print $e->getMessage();
 * }
 * </code>
 * 
 * 
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 * 
 * @todo UnitTests for the entire bundle
 **/
class ReadMe {
    public function __construct() {
        throw new \Exception('This file is for documentation only'); 
    }
}
