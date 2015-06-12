<?php
namespace YouTubeVideoRetrieverBundle\Parameters;

/**
 * Stores all regular expressions used by parse service
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class RegExList
{
    /**
     * Expression for retrieving video lists
     * @var array
     */
    public static $video_list = array(
        'expr' => '/<a href="\/watch\?v=([a-zA-Z0-9]+)"(.*)>(.*)<\/a>/msU',
        'result_key' => 1
    );

    /**
     * Expression for retrieving video title
     * @var array
     */
    public static $video_details_title = array(
        'expr' => '/<meta property="og:title" content="(.*)">/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'title'
    );

    /**
     * Expression for retrieving video description
     * @var array
     */
    public static $video_details_description = array(
        'expr' => '/<p id="eow-description" >(.*)<\/p>/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'description'
    );

    /**
     * Expression for retrieving video duration
     * @var array
     */
    public static $video_details_duration = array(
        'expr' => '/<meta itemprop="duration" content="(.*)">/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'duration'
    );

    /**
     * Expression for retrieving video image
     * @var array
     */
    public static $video_details_image = array(
        'expr' => '/<meta property="og:image" content="(.*)">/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'image'
    );

    /**
     * Expression for retrieving author
     * @var array
     */
    public static $video_details_author = array(
        'expr' => '/<div class="yt-user-info">(.*)<a href="\/channel\/(.*)" (.*)>(.*)<\/a>(.*)/msU',
        'type' => 'single',
        'result_key' => array('name' => 4, 'id' => 2),
        'key' => 'author'
    );

    /**
     * Expression for retrieving video width
     * @var array
     */
    public static $video_details_width = array(
        'expr' => '/<meta property="og:video:width" content="(.*)">/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'width'
    );
    
    /**
     * Expression for retrieving video height
     * @var array
     */
    public static $video_details_height = array(
        'expr' => '/<meta property="og:video:height" content="(.*)">/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'height'
    );

    /**
     * Expression for retrieving video views
     * @var array
     */
    public static $video_details_views = array(
        'expr' => '/<div class="watch-view-count">([0-9,.]+)<\/div>/msU',
        'type' => 'single',
        'result_key' => 1,
        'key' => 'views'
    );

    /**
     * Expression for retrieving video tags
     * @var array
     */
    public static $video_details_tags = array(
        'expr' => '/<meta property="og:video:tag" content="(.*)">/msU',
        'type' => 'multiple',
        'result_key' => 1,
        'key' => 'tags'
    );

    /**
     * Retrieve all defined expressions for video details retrieval
     * The valid format for the member is "video_details_[parameter]"
     *
     * @return array
     */
    public static function getVideoDetailsExpressions()
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $members = $reflection->getProperties(\ReflectionProperty::IS_STATIC);
        if (empty($members)) {
            return array();
        }
        $result = array();
        foreach ($members as $member) {
            if (strpos($member->name, 'video_details') !== false) {
                $result[] = $member->name;
            }
        }
        return $result;
    }
}
