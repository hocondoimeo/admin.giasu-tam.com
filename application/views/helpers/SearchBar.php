<?php

class Zend_View_Helper_SearchBar extends Zend_View_Helper_Abstract
{


    public function searchBar ($typeSearchs = null, $filters = null, $buttons = null, $params = null, $url = null)
    {
        $front = Zend_Controller_Front::getInstance();

        if(!$params){
            $params = $front->getRequest()->getParams();
			$actionUrl = "/{$params['controller']}/{$params['action']}";
			$keywordsValue = isset($params['keywords'])?$params['keywords'] : '';
			$fieldSearch = isset($params['fieldsearch'])?$params['fieldsearch'] : '';
        }else
			$actionUrl = $params;

        if(!$typeSearchs){
            $typeSearchs = array(
                'none' => 'All'
            );
        }

        if(!$filters){
            $filters = array(

            );
        }

        if(!$buttons){
            $buttons = array(

            );
        }

        $selectElement = new Zend_Form_Element_Select('fieldsearch');
        $selectElement->addMultiOptions($typeSearchs);
        $selectElement->setAttrib('class', 'input-medium');
        $selectElement->setDecorators(array('ViewHelper'));
        $selectElement->setValue( isset($fieldSearch)?$fieldSearch:'');

		if(!is_null($filters)  && is_array($filters))
			$filterElements = implode("\n",$filters);
        $buttonElements = implode("\n",$buttons);


        $variables = array(
            '%%ACTION_URL%%'           => is_null($url) ? $actionUrl : $url,
            '%%KEYWORDS%%'             => isset($keywordsValue)?$keywordsValue:'',
            '%%SELECT_ELEMENT%%'       => $selectElement,
            '%%FILTER_ELEMENTS%%'      => isset($filterElements) ? $filterElements : '',
            '%%BUTTONELEMENTS%%'       => $buttonElements,
        );
        $result = $this->getTemplate($filters);
        $result = str_replace(array_keys($variables), array_values($variables), $result);
//        echo $result;die;
        return $result;
    }

    public function getTemplate($ajax=''){
		$t = '
		<div class="row-fluid show-grid">
			<div class="span12">

			   <form class="well form-search quick-search-v2" method="post" action="%%ACTION_URL%%" name="quick-search"  >

					<label class="control-label">Keyword:</label>

					<input type="text" value="%%KEYWORDS%%" name="keywords" class="input-medium search-query"/>

					<label class="control-label">Type: </label>

					%%SELECT_ELEMENT%%
		';
		$t1='
					%%FILTER_ELEMENTS%%

					<div class="pull-right">
						%%BUTTONELEMENTS%%
					</div>

				</form>

			</div>
		</div>';
	
	if(!empty($ajax) && $ajax =='ajax'){
		$t .= '
					<button class="btn btn-primary btn-search" type="button">
						<i class="icon-search"></i> Search
					</button>

					<a class="btn btn-small btn-primary" onClick="loadPage(\'%%ACTION_URL%%\')">Clear</a>';
	}else
        $t .= '	
						<button class="btn btn-primary" type="submit">
							<i class="icon-search"></i> Search
						</button>

						<a class="btn btn-small btn-primary" href="%%ACTION_URL%%">Clear</a>
				';
        return $t.$t1;
    }

}