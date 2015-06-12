<?php
namespace YouTubeVideoRetrieverBundle\Parameters;

/**
 * Config File - Stores constants with URL segments that builds
 * the YouTube URL that needs to be accesed
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class Config
{
    /**
     * Base YouTube URL - Can be changes with a desired TLD
     * @const string
     */
    const BASE_URL = 'http://www.youtube.com/';

    /**
     * Search Segment
     * @const string
     */
    const SEARCH_URL = 'results?search_query=';

    /**
     * Order by Relevancy URL Parameter
     * @const string
     */
    const SEARCH_BY_RELEVANCY = '';

    /**
     * Order by Date URL Parameter
     * @const string
     */
    const SEARCH_BY_DATE = '&search_sort=video_date_uploaded';

    /**
     * Order by Rating URL Parameter
     * @const string
     */
    const SEARCH_BY_RATING = '&search_sort=video_avg_rating';

    /**
     * Order by Views URL Parameter
     * @const string
     */
    const SEARCH_BY_VIEWS = '&search_sort=video_view_count';

    /**
     * Filter video URL Parameter
     * @const string
     */
    const SEARCH_FILTER_VIDEO_TYPE = '&filters=video&lclk=video';

    /**
     * Page Nr URL Parameter
     * @const string
     */
    const SEARCH_PAGE_NR_FILTER = '&page=';

    /**
     * URL Segment for Video Page
     * @const string
     */
    const VIDEO_DETAILS_PARAMETER = 'watch?v=';
}
