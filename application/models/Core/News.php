<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_News extends Base_Db_Table_Abstract {


/********************************************************************
* Define table News
********************************************************************/
    protected $_name        = 'News';
    protected $_primary     = array('NewsId',);

    protected $_dependentTables = array(

    );

    protected $_referenceMap    = array(

    );


/********************************************************************
* Define field search, sort
********************************************************************/
    public $searchFields = array();
    public $sortFields   = array();

    public function init() {
        parent::init();

         /* Define field to search */
        $this->searchFields = array(
            "NewsId"                       => "News.NewsId                    = '{{param}}'",
            "Title"                        => "News.Title                     LIKE '%{{param}}%'",
            "Summary"                      => "News.Summary                   LIKE '%{{param}}%'",
            "UserId"                      => "News.UserId                   = '{{param}}'",
            "Content"                      => "News.Content                   LIKE '%{{param}}%'",
            "ImageUrl"                     => "News.ImageUrl                  LIKE '%{{param}}%'",
            "CreatedDate"                  => "News.CreatedDate               = '{{param}}'",
            "IsPrivate"                    => "News.IsPrivate                 = '{{param}}'",
            "NewsCategoryId"               => "News.NewsCategoryId            = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "NewsId_Sort"                  => "News.NewsId                    {{param}}",
            "Title_Sort"                   => "News.Title                     {{param}}",
            "Summary_Sort"                 => "News.Summary                   {{param}}",
            "UserId_Sort"                 => "News.UserId                   {{param}}",
            "Content_Sort"                 => "News.Content                   {{param}}",
            "ImageUrl_Sort"                => "News.ImageUrl                  {{param}}",
            "CreatedDate_Sort"             => "News.CreatedDate               {{param}}",
            "IsPrivate_Sort"               => "News.IsPrivate                 {{param}}",
            "NewsCategoryId_Sort"          => "News.NewsCategoryId            {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/

    public function groupMenuByParent(Zend_Db_Table_Rowset_Abstract $news) {
    	$data = array();
    
    	foreach ($news as $new) {
    		if ($new->NewsCategoryId) {
    			if (! isset($data[$new->NewsCategoryId])) $data[$new->NewsCategoryId] = array();
    
    			$data[$new->NewsCategoryId]['childs'][] = $new->toArray();
    		} else {
    			if (! isset($data[$new->NewsId])) {
    				$data[$new->NewsId] = array_merge($new->toArray(), array('childs' => array()));
    			} else {
    				$data[$new->NewsId] = array_merge($new->toArray(), array('childs' => $data[$new->NewsId]['childs']));
    			}
    		}
    	}
    
    	return $data;
    }
    
    public function getNewsByCate($cateId) {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate");
    }
    
    public function getAllNews() {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate DESC");
    }
    
}