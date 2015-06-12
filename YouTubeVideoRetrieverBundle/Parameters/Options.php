<?php
namespace YouTubeVideoRetrieverBundle\Parameters;

/**
 * List of all sorting parameters and options.
 * These are the parameters used to identify the method request
 *
 * @package YouTubeVideoRetriever
 * @author Adrian Tilita <adrian@tilita.ro>
 * @version 1.0 2015-05-25
 **/
class Options
{
    /**
     * Option Type
     * @const string
     */
    const OPTION_TYPE_ORDER = 'ORDER_';

    /**
     * Item identifier
     * @const string
     */
    const OPTION_ITEM_SEARCH = 'SEARCH_';

    /**
     * Relevancy selector
     * @const int
     */
    const ORDER_SEARCH_BY_RELEVANCY = 1;

    /**
     * Date selector
     * @const int
     */
    const ORDER_SEARCH_BY_DATE = 2;

    /**
     * View Selector
     * @const int
     */
    const ORDER_SEARCH_BY_VIEWS = 3;

    /**
     * Rating Selector
     * @const int
     */
    const ORDER_SEARCH_BY_RATING = 4;

    /**
     * Return an array of available Search Order options
     * Constants should be formatted using "[OPTION_ITEM]_[OPTION_TYPE]_[IDENTIFIER]" format
     *
     * @param string $optionItem
     * @param string $optionType
     * @return type
     * @throws \Exception
     */
    public function getOptions($optionItem, $optionType)
    {
        $constants = $this->parseResults($this->getDefinedConstants(), $optionItem . $optionType);
        if (empty($constants)) {
            throw new \Exception('No option constants defined for Search Order!');
        }
        return $constants;
    }

    /**
     * Search in defined constants for a list of constants with
     * the name containing the given string
     *
     * @param array $constants
     * @param string $string
     * @return array
     */
    private function parseResults($constants, $string)
    {
        $results = array();
        if (!empty($constants)) {
            foreach (array_keys($constants) as $constant) {
                if (strpos($constant, $string) !== false) {
                    $results[] = $constant;
                }
            }
        }
        return $results;
    }

    /**
     * Return all defined constants in the current class
     *
     * @return array
     */
    private function getDefinedConstants()
    {
        $reflection = new \ReflectionClass(__CLASS__);
        return $reflection->getConstants();
    }
}
