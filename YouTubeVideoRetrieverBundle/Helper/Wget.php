<?php
namespace YouTubeVideoRetrieverBundle\Helper;

/**
 * Retrieve URL Content using either file_get_contents either curl
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class Wget
{
    /**
     * file_get_contents() method identifier
     * @const int
     */
    const FILE_GET_CONTENTS = 1;

    /**
     * curl method identifier
     * @const int
     */
    const CURL = 2;

    /**
     * Get Content based on it's URL
     *
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function getUrlContent($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('Invalid URL!');
        }
        $method = $this->getMethod();
        switch ($method) {
            case (self::FILE_GET_CONTENTS):
                $content = file_get_contents($url);
                break;
            case (self::CURL):
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_AUTOREFERER, true);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                $content = curl_exec($curl);
                curl_close($curl);
                break;
        }
        return $content;
    }

    /**
     * Identify if any method of accessing external URL
     *
     * @return int
     * @throws \Exception
     */
    protected function getMethod()
    {
        $file_open = ini_get('allow_url_fopen');
        if ($file_open != '1') {
            if (function_exists('curl_version')) {
                return self::CURL;
            }
            throw new \Exception('No available URL Open method.');
        }
        return self::FILE_GET_CONTENTS;
    }
}
