<?php
/**
 * @package Unlimited Elements
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');


class UniteCreatorAddonViewChildParams{
	
	const PARAM_PREFIX = "[param_prefix]";
	const PARAM_NAME = "[param_name]";
	const PARENT_NAME = "[parent_name]";
	
	
	/**
	 * create child param
	 */
	protected function createChildParam($param, $type = null, $addParams = false){
		
		$arr = array("name"=>$param, "type"=>$type);
				
		if(!empty($addParams))
			$arr = array_merge($arr, $addParams);
		
		return($arr);
	}
	
	
	
	/**
	 * create add param
	 */
	private function createAddParam($param = null,$addParams = array()){
		
		if(empty($addParams)){
			
			$addParams = array(
				"rawvisual"=>true,
			);
			
			if(!empty($param)){
				if($param == "|raw")
					$param = self::PARENT_NAME."|raw";
				else
					$param = self::PARENT_NAME."_".$param;
			}
			
		}
		
		$type = null;
		
		$arr = array("name"=>$param, "type"=>$type);
		$arr = array_merge($arr, $addParams);
		
		return($arr);
	}
	
	/**
	 * create child param
	 */
	protected function createChildParam_code($key, $text, $noslashes = false, $rawvisual = true){
		
	    $arguments = array(
		    	"raw_insert_text" => $text, 
		    	"rawvisual"=>$rawvisual,
	    	);		
		
	    if($noslashes == true)
	    	 $arguments["noslashes"] = true;
	    
	    	
	    $arr = $this->createChildParam($key, null, $arguments);		
		
		return($arr);
	}
	
	/**
	 * get code example php params
	 */
	protected function getCodeExamplesParams_php($arrParams){
		
			$key = "Run PHP Function (pro)";
			$text = "
			
{# This functionality exists only in the PRO version #}
{# run any wp action, and any custom PHP function. Use add_action to create the actions. \n The function support up to 3 custom params #}
\n
{{ do_action('some_action') }}
{{ do_action('some_action','param1','param2','param3') }}
";
		
			$arrParams[] = $this->createChildParam_code($key, $text);
		
			$key = "Data From PHP (pro)";
			$text = "
{# This functionality exists only in the PRO version #}			
{# apply any WordPress filters, and any custom PHP function. Use apply_filters to create the actions. \n The function support up to 2 custom params #}
\n
{% set myValue = apply_filters('my_filter') }}
{% set myValue = apply_filters('my_filter',value, param2, param3) }}

";
			$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		return($arrParams);
	}
	
	/**
	 * get post child params
	 */
	public function getChildParams_codeExamples(){
		
		$arrParams = array();
		
		//----- show data --------
		
		$key = "showData()";
		$text = "
{# This function will show all data in that you can use #} \n 
{{showData()}}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//---- show debug -----
		
		$key = "showDebug()";
		$text = "
{# This function show you some debug (with post list for example) #} \n 
{{showDebug()}}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);

		//---- printVar -----
		
		$key = "printVar()";
		$text = "
{# This function will print any variable #} \n	
{{printVar(somevar)}}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//------ if empty ------
		
		$key = "IF Empty";
		$text = "
{% if some_attribute is empty %}
	<!-- put your empty case html -->   
{% else %} 
	<!-- put your not empty html here -->   
{% endif %}	
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- simple if ------
		
		$key = "IF";
		$text = "
{% if some_attribute == \"some_value\" %}
	<!-- put your html here -->   
{% endif %}	
";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//----- if else ------
		
		$key = "IF - Else";
		$text = "
{% if product_stock == 0 %}
	<!-- not available html -->   
{% else %}
	<!-- available html -->
{% endif %}
";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//----- complex if ------
		
		$key = "IF - Else - Elseif";
		$text = "
{% if product_stock == 0 %}
	<!-- put your 0 html here -->   
{% elseif product_stock > 0 and product_stock < 20 %}
	<!-- put your 0-20 html here -->   
{% elseif product_stock >= 20 %}
	<!-- put your >20 html here -->   
{% endif %}	
";

		$arrParams[] = $this->createChildParam_code($key, $text);


		//----- for in (loop) ------
		
		$key = "For In (loop)";
		$text = "
{% for product in woo_products %}
	
	<!-- use attributes inside the product, works if the product is array -->   
	<span> {{ product.title }} </span>
	<span> {{ product.price }} </span>
	
{% endfor %}	
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- html output raw filter ------
		
		$key = "HTML Output - |raw";
		$text = "
{# use the raw filter for printing attribute with html tags#}
{{ some_attribute|raw }}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);

		//----- truncate text filter ------
		
		$key = "Truncate Text Filter - |truncate";
		$text = "
{# use the truncate filter for lower the text length. arguments are: (numchars, preserve words(true|false), separator=\"...\")#}
{{ some_attribute|truncate }}
{{ some_attribute|truncate(50) }}
{{ some_attribute|truncate(100, false) }}
{{ some_attribute|truncate(150, true, \"...\") }}
";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		//----- default value ------
		
		$key = "Default Value";
		$text = "
{# use the default value filter in case that no default value provided (like in acf fields) #}
{{ cf_attribute|default('text in case that not defined') }}
";

		$arrParams[] = $this->createChildParam_code($key, $text);

		//----- get user data ------
		
		$arrParams = $this->getCodeExamplesParams_php($arrParams);

		$key = "getUserData()";
		$text = "
{# Use this function this way:  getUserData(username, getMeta=true/false, getAvatar=true/false) #}
\n
{% set userData = getUserData('admin',true, true) %}
{{printVar(userData)}}

";
		
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		//----- output ------
		
		return($arrParams);
	}
	

	/**
	 * get post child params
	 */
	public function getChildParams_codeExamplesJS(){
		
		$arrParams = array();
		
		//----- show data --------
		
		$key = "jQuery(document).ready()";
		$text = " 
jQuery(document).ready(function(){

	/* put your code here, a must wrapper for every jQuery enabled widget */

});
		";
		$arrParams[] = $this->createChildParam_code($key, $text);
		
		
		return($arrParams);
	}
	
	
	/**
	 * create category child params
	 */
	public function createChildParams_category($arrParams){
		
		$arrParams[] = $this->createChildParam("category_id");
		$arrParams[] = $this->createChildParam("category_name");
		$arrParams[] = $this->createChildParam("category_slug");
		$arrParams[] = $this->createChildParam("category_link");
		
		//create categories array foreach
		
		$strCode = "";
		$strCode .= "{% for cat in [param_prefix].categories %}\n";
										
		$strCode .= "	<span> {{cat.id}} , {{cat.name}} , {{cat.slug}} , {{cat.description}}, {{cat.link}} </span> <br>\n\n ";
		
		$strCode .= "	{# also you can use category custom fields #} \n";
		$strCode .= "	{% set custom_fields = getTermCustomFields(cat.id) %} \n";
		$strCode .= "	{{custom_fields.cf_fieldname}} \n\n";
		
		$strCode .= "{% endfor %}\n";

		
	    $arrParams[] = $this->createChildParam("categories", null, array("raw_insert_text" => $strCode));		
		
	    $arrParams = $this->getChildParams_termCustomFields($arrParams);
	    $arrParams = $this->getChildParams_termMeta($arrParams);
		
		return($arrParams);
	}
	
	/**
	 * create child param with underscore
	 */
	protected function createChildParam_underscore($key){
		
		$value = "{{".self::PARAM_PREFIX."_$key}}";
		
		if(empty($key))
			$value = "{{".self::PARAM_PREFIX."}}";
		
		$param = $this->createChildParam($value, null, array(
		    	"raw_insert_text" => $value, 
		    	"rawvisual"=>true,
		));
		
		return($param);
	}
	
	/**
	 * add image child params
	 */
	public function getChildParams_image(){
		
		$arrParams = array();
		
		$arrParams = $this->addPostImageChildParams($arrParams, true);
		
		
		return($arrParams);
	}
	
	
	private function __________POST_FIELDS_________(){}
		
	/**
	 * get post add data code
	 */
	protected function getPostItemAddDataCode(){
		
		$str = "\n{# get additional data , the function defenition is:  getPostData(postID, getCustomFields [true/false] , getCategory [true/false])  #}\n\n";
		$str .= "{% set postData = getPostData(item.post_id, false, false) %}\n\n";
		$str .= "{{postData[\"image\"]}}\n\n";
		$str .= "{{printVar(postData)}}\n\n";
		
		return($str);
	}
	
	
	/**
	 * add custom fields
	 */
	protected function addCustomFieldsParams($arrParams, $postID){
		
		if(empty($postID))
			return($arrParams);
		
		$isAcfExists = UniteCreatorAcfIntegrate::isAcfActive();
		
		$prefix = "cf_";
			
		//take from pods
		$isPodsExists = UniteCreatorPodsIntegrate::isPodsExists();
		
		$takeFromACF = true;
		if($isPodsExists == true){
			$arrMetaKeys = UniteFunctionsWPUC::getPostMetaKeys_PODS($postID);
			if(!empty($arrMetaKeys))
				$takeFromACF = false;
		}
		
		//take from toolset
		$isToolsetExists = UniteCreatorToolsetIntegrate::isToolsetExists();
		if($isToolsetExists == true){
			
			$objToolset = new UniteCreatorToolsetIntegrate();
			$arrMetaKeys = $objToolset->getPostFieldsKeys($postID);
			$takeFromACF = false;
		}
		
		
		//acf custom fields
		if($isAcfExists == true && $takeFromACF == true){
			
			$arrMetaKeys = UniteFunctionsWPUC::getAcfFieldsKeys($postID);
			$title = "acf field";
			
			if(empty($arrMetaKeys))
				return($arrParams);
			
			$firstKey = UniteFunctionsUC::getFirstNotEmptyKey($arrMetaKeys);
			
			foreach($arrMetaKeys as $key=>$type){
				
				//complex code (repeater) 
				
				if(is_array($type)){
					
					$strCode = "";
					$strCode .= "{% for item in [param_prefix].{$key} %}\n";
					
					$typeKeys = array_keys($type);
					
					foreach($typeKeys as $postItemKey){
						
						if($postItemKey == "put_post_add_data")
							$strCode .= $this->getPostItemAddDataCode();
						else
							$strCode .= "<span> {{item.$postItemKey}} </span>\n";
					}
					
					
					$strCode .= "{% endfor %}\n";
					
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strCode));
					
				    continue;
				}
				
				//array code 
				
				if($type == "array"){
					
					$strCode = "";
					$strCode .= "{% for value in [param_prefix].{$key} %}\n";
					$strCode .= "<span> {{item}} </span>\n";
					$strCode .= "{% endfor %}\n";
					
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strCode));
					
					continue;
				}
				
				if($type == "empty_repeater"){
					
					$strText = "<!-- Please add some values to this field repeater in demo post in order to see the fields here -->";
				    $arrParams[] = $this->createChildParam($key, null, array("raw_insert_text"=>$strText));
					
					continue;
				}
				
				//simple param
				
				$arrParams[] = $this->createChildParam($key);
			}
			
			
		}else{	//regular custom fields
			
			//should be $arrMetaKeys from pods
			
			if(empty($arrMetaKeys))
				$arrMetaKeys = UniteFunctionsWPUC::getPostMetaKeys($postID, "cf_");
							
			$title = "custom field";
			
			if(empty($arrMetaKeys))
				return($arrParams);
			
			$firstKey = $arrMetaKeys[0];
				
			foreach($arrMetaKeys as $key)
				$arrParams[] = $this->createChildParam($key);
			
		}
		
		//add functions
		$arrParams[] = $this->createChildParam("$title example with default",null,array("raw_insert_text"=>"{{ [param_prefix].$firstKey|default('default text') }}"));
				
		
		return($arrParams);
	}
	
	/**
	 * add put post meta function params
	 */
	private function getChildParams_post_addPostMeta($arrParams){
		
		$strText = "{# Put post meta value #} \n\n";
		
		$strText .= "{{putPostMeta([param_prefix].id,\"metakey\")}} \n\n";
		
		$strText .= "{# Set variable with post meta value, and use it later #} \n\n";
		
		$strText .= "{% set myField = getPostMeta([param_prefix].id,\"metakey\") %} \n";
		$strText .= "{{myField}} \n\n";
		
		$strText .= "{# Print all post meta data #} \n\n";
		
		$strText .= "{{printPostMeta([param_prefix].id)}} \n";
		
		$arrParams[] = $this->createChildParam("putPostMeta", null, array("raw_insert_text"=>$strText));
		
		return($arrParams);
	}

	/**
	 * get custom fields text
	 */
	private function getTermCustomFieldsText($field = null, $linePrefix = ""){
		
		if(empty($field))
			$field = "[param_prefix].category_id";
				
		$strText = $linePrefix."{% set custom_fields = getTermCustomFields($field) %} \n\n";
						
		$strText .= $linePrefix."{{custom_fields.cf_fieldname}} \n\n";
		
		$strText .= $linePrefix."{{printVar(custom_fields)}} \n\n";
				
		return($strText);
	}
	
	/**
	 * add put post meta function params
	 */
	private function getChildParams_termCustomFields($arrParams){
		
		$strText = $this->getTermCustomFieldsText();
		
		$arrParams[] = $this->createChildParam("categoryCustomFields", null, array("raw_insert_text"=>$strText));
		
		return($arrParams);
	}
	
	/**
	 * add term meta function output
	 */
	private function getChildParams_termMeta($arrParams, $field = null, $linePrefix = ""){
		
		if(empty($field))
			$field = "[param_prefix].category_id";
		
		$strText = $linePrefix."{% set meta_fields = getTermMeta($field) %} \n\n";
		
		$strText .= $linePrefix."{{meta_fields.fieldname}} \n\n";
		
		$strText .= $linePrefix."{{printVar(meta_fields)}} \n\n";
		
		$arrParams[] = $this->createChildParam("categoryMetaFields", null, array("raw_insert_text"=>$strText));
		
		return($arrParams);
	}
	
	
	/**
	 * add post terms function
	 */
	private function getChildParams_post_addTerms($arrParams){
		
		$strCode = "";
		
		$strCode .= "{# for get with custom fields write \"true\" in 3-th attribute: getPostTerms([param_prefix].id, \"post_tag\", true) #}\n\n";

		$strCode .= "{% set terms = getPostTerms([param_prefix].id, \"post_tag\", false) %}\n\n";
		
		$strCode .= "{% for term in terms %}\n\n";
		$strCode .= "	{{term.id}}, {{term.name}}, {{term.slug}}\n";
		$strCode .= "	{{printVar(term)}}\n\n";

		$strCode .= "	{# also you can use term meta fields #} \n";
		$strCode .= "	{% set meta_fields = getTermMeta(term.id) %} \n";
		$strCode .= "	{{meta_fields.fieldname}} \n\n";
		
		$strCode .= "{% endfor %}\n";
		
	    $arrParams[] = $this->createChildParam("putPostTerms", null, array("raw_insert_text"=>$strCode));
		
		return($arrParams);
	}

	
	/**
	 * add post terms function
	 */
	private function getChildParams_post_addAuthor($arrParams){
		
		$strCode = "";
		$strCode .= "{% set author = getPostAuthor([param_prefix].author_id) %}\n\n";
		$strCode .= "{{author.id}} {{author.name}} {{author.email}}\n";
		
	    $arrParams[] = $this->createChildParam("getPostAuthor", null, array("raw_insert_text"=>$strCode));
		
		return($arrParams);
	}
	
	
	/**
	 * create add child products param
	 */
	private function createWooPostParam_getChildProducts(){
				
		$strCode = "";
		$strCode .= "{# Get child products for 'grouped' product type. The function defenition is:  getWooChildProducts(postID, getCustomFields [true/false] , getCategory [true/false])  #}\n\n";
		
		$strCode .= "{% set child_products = getWooChildProducts([param_prefix].id, false, false) %}\n\n";
		
		$strCode .= "{% for product in child_products %}\n\n";
		
		$strCode .= "	Child Product: {{ product.title }}<br>\n\n";
		
		$strCode .= "	{# For other fields please look at output of this function #}<br>\n ";
		$strCode .= "	{{printVar(product)}} <br>\n\n ";
		
		$strCode .= "{% endfor %}\n";
		
	    $arrParam = $this->createChildParam("getWooChildProducts", null, array("raw_insert_text"=>$strCode));
		
	    return($arrParam);
	}
	
	
	/**
	 * check and add woo post params
	 */
	private function checkAddWooPostParams($postID, $arrParams){
		
		$arrKeys = UniteCreatorWooIntegrate::getWooKeysByPostID($postID);
		
		if(empty($arrKeys))
			return($arrParams);
		
		$arrParams[] = $this->createWooPostParam_getChildProducts();
		
		//dmp($arrKeys);exit();
		
		foreach($arrKeys as $key){			
			$arrParams[] = $this->createChildParam($key);
		}
		
		return($arrParams);
	}
	
	/**
	 * get thumb sizes array
	 */
	private function getArrImageThumbSizes(){
		
		$arrSizesOutput = array();
		$arrSizesOutput["thumb"] = __("Thumb (max width 300)", "unlimited_elements");
		
		$arrSizes = UniteFunctionsWPUC::getArrThumbSizes();
		
		//add large
		$sizeLargeDesc = UniteFunctionsUC::getVal($arrSizes, "large");
		if(empty($sizeLargeDesc))
			$sizeLargeDesc = __("Large (max width 780)");
		
		$arrSizesOutput["thumb_large"] = $sizeLargeDesc;
			
		foreach($arrSizes as $size=>$desc){
			
			if($size == "medium")
				continue;
				
			if($size == "large")
				continue;
				
			$arrSizesOutput["thumb_".$size] = $desc;
			
		}
		
		return($arrSizesOutput);
	}
	
	/**
	 * add image child param
	 */
	private function createChildParam_image($key, $isSingle = false){
		
		if($isSingle == false)
			$param = $this->createChildParam($key);
		else
			$param = $this->createChildParam_underscore($key);
		
		return($param);
	}
	
	
	/**
	 * add post child params
	 */
	private function addPostImageChildParams($arrParams, $isSingle = false){
		
		if($isSingle == false)
			$arrParams[] = $this->createChildParam_image("image", $isSingle);
		else
			$arrParams[] = $this->createChildParam_underscore(null);
		
		$arrSizes = $this->getArrImageThumbSizes();

		foreach($arrSizes as $size=>$desc){
			
			if($isSingle == false){
				$key = "image_{$size}";
				$sap = ".";
			}
			else{
				$key = $size;
				$sap = "_";
			}
			
			$thumbCode = "{{".self::PARAM_PREFIX."{$sap}$key}}\n";
			$thumbCode .= "{{".self::PARAM_PREFIX."{$sap}{$key}_width}}\n";;
			$thumbCode .= "{{".self::PARAM_PREFIX."{$sap}{$key}_height}}\n";;
			
			$arrParams[] = $this->createChildParam_code("{{".self::PARAM_PREFIX."_".$key."}}", $thumbCode, false, true);
		}
		
		$prefix = "image_";
		if($isSingle == true)
			$prefix = "";
		
		$arrParams[] = $this->createChildParam_image("{$prefix}title", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}alt", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}description", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}caption", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}imageid", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}width", $isSingle);
		$arrParams[] = $this->createChildParam_image("{$prefix}height", $isSingle);
		
		return($arrParams);
	}
	
	/**
	 * get post child params
	 */
	public function getChildParams_post($postID = null, $arrAdditions = array()){
				
		$arrParams = array();
		$arrParams[] = $this->createChildParam("id");
		$arrParams[] = $this->createChildParam("title",UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("alias");
		$arrParams[] = $this->createChildParam("content", UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("content|wpautop", UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("intro", UniteCreatorDialogParam::PARAM_EDITOR);
		$arrParams[] = $this->createChildParam("link");
		$arrParams[] = $this->createChildParam("date",null,array("raw_insert_text"=>"{{[param_name]|ucdate(\"d F Y, H:i\")|raw}}"));
		
		//ucdate replaces
		//$arrParams[] = $this->createChildParam("postdate",null,array("raw_insert_text"=>"{{putPostDate([param_prefix].id,\"d F Y, H:i\")}}"));
		
		$arrParams[] = $this->createChildParam("tagslist",null,array("raw_insert_text"=>"{{putPostTags([param_prefix].id)}}"));		
		$arrParams = $this->getChildParams_post_addTerms($arrParams);
		$arrParams = $this->getChildParams_post_addAuthor($arrParams);
		$arrParams = $this->getChildParams_post_addPostMeta($arrParams);
		
		
		if(!empty($postID))
			$arrParams = $this->checkAddWooPostParams($postID, $arrParams);
		
		$arrParams = $this->addPostImageChildParams($arrParams);
		
		
		//add post additions
		if(empty($arrAdditions))
			return($arrParams);
				
		foreach($arrAdditions as $addition){
			
			switch($addition){
				case GlobalsProviderUC::POST_ADDITION_CATEGORY:
					
					$arrParams = $this->createChildParams_category($arrParams);
					
				break;
				case GlobalsProviderUC::POST_ADDITION_CUSTOMFIELDS:
					
					if(!empty($postID))
						$arrParams = $this->addCustomFieldsParams($arrParams, $postID);
					
				break;
			}
		}
		
		
		return($arrParams);
	}
	
	private function __________POST_FIELDS_END_________(){}
	
	
	/**
	 * get term code
	 */
	private function getTermCode($itemName, $parentName, $isWoo = false){
		
		$strCode = "";
		$strCode .= "{% for $itemName in $parentName %}\n";
		$strCode .= "\n";
		$strCode .= "	Term ID: {{{$itemName}.id}} <br>\n ";
		$strCode .= "	Name: {{{$itemName}.name|raw}} <br>\n ";
		$strCode .= "	Slug: {{{$itemName}.slug}} <br>\n ";
		$strCode .= "	Description: {{{$itemName}.description}} <br>\n ";
		$strCode .= "	Link: {{{$itemName}.link}} <br>\n ";
		
		if($isWoo == false)
			$strCode .= "	Num posts: {{{$itemName}.num_posts}} <br>\n ";
		else
			$strCode .= "	Num products: {{{$itemName}.num_products}} <br>\n ";
		
		$strCode .= "	Is Current: {{{$itemName}.iscurrent}} <br>\n ";
		$strCode .= "	Selected Class: {{{$itemName}.class_selected}} <br>\n ";
		
		if($isWoo == true){
			$strCode .= "	Image: {{{$itemName}.image}} <br>\n ";
			$strCode .= "	Image Thumb: {{{$itemName}.image_thumb}} <br>\n\n ";
		}
		
		$strCode .= "\n	{# For other fields please look at output of this function #}<br>\n\n ";
		$strCode .= "	{{printVar({$itemName})}} <br>\n\n ";

		$strCode .= "	{# Also you can use the getTermMeta() #}\n\n";
		
		$strCode .= "	{% set meta_fields = getTermMeta({$itemName}.id) %}\n ";
		$strCode .= "	{{ meta_fields.fieldname }}<br>\n\n ";
		
		$strCode .= "	<hr>\n";
		
		$strCode .= "\n";
		
		$strCode .= "{% endfor %}\n";
		
		return($strCode);
	}
	
	
	/**
	 * get term code
	 */
	private function getUsersCode($itemName, $parentName){
		
		$strCode = "";
		$strCode .= "{% for $itemName in $parentName %}\n";
		$strCode .= "\n";
		$strCode .= "	User ID: {{{$itemName}.id}} <br>\n ";
		$strCode .= "	Username: {{{$itemName}.username}} <br>\n ";
		$strCode .= "	Name: {{{$itemName}.name|raw}} <br>\n ";
		$strCode .= "	Email: {{{$itemName}.email}} <br>\n ";
		$strCode .= "	Role: {{{$itemName}.role}} <br>\n ";
		
		$strCode .= "\n";
		$strCode .= "	<hr>\n";
		
		$strCode .= "	# ---- Avatar Fields: ----- \n\n";
		
		$arrAvatarKeys = UniteFunctionsWPUC::getUserAvatarKeys();
		
		foreach($arrAvatarKeys as $key){
			$title = UniteFunctionsUC::convertHandleToTitle($key);
		
			$strCode .= "	$title: {{{$itemName}.{$key}}} <br>\n ";
		}
		
		$strCode .= "\n";
		$strCode .= "	<hr>\n";
		
		$strCode .= "	# ---- User Meta Fields: ----- \n\n";
		
		$arrMetaKeys = UniteFunctionsWPUC::getUserMetaKeys();
		
		foreach($arrMetaKeys as $key){
			$title = UniteFunctionsUC::convertHandleToTitle($key);
		
			$strCode .= "	$title: {{{$itemName}.{$key}}} <br>\n ";
		}
		
		
		$strCode .= "\n";
		
		$strCode .= "{% endfor %}\n";
		
		return($strCode);
	}
	
	
	/**
	 * get post child params
	 */
	public function getAddParams_terms($isWoo = false){
		
		$arrParams = array();
		
		$strCode = $this->getTermCode("term", "[parent_name]", $isWoo);
		
		$arrParams[] = $this->createChildParam_code("[parent_name]_output", $strCode);
		
				
		return($arrParams);
	}

	/**
	 * get users child params
	 */
	public function getAddParams_users(){
		
		$arrParams = array();
		
		$strCode = $this->getUsersCode("user", "[parent_name]");
		
		$arrParams[] = $this->createChildParam_code("[parent_name]_output", $strCode);
		
		return($arrParams);
	}
	
	
	/**
	 * get post child params
	 */
	public function getAddParams_link(){

		$arrParams = array();
			
		$arrParams[] = $this->createAddParam();
		$arrParams[] = $this->createAddParam("html_attributes|raw");
		
		return($arrParams);
	}

	/**
	 * get post child params
	 */
	public function getAddParams_slider(){

		$arrParams = array();
		
		$arrParams[] = $this->createAddParam();
		$arrParams[] = $this->createAddParam("nounit");

		$addParams = array("condition"=>"responsive");
		
		$arrParams[] = $this->createAddParam("tablet", $addParams);
		$arrParams[] = $this->createAddParam("mobile", $addParams);
		
		return($arrParams);
	}
	
	/**
	 * get post child params
	 */
	public function getAddParams_menu(){

		$arrParams = array();
		
		$arrParams[] = $this->createAddParam("|raw");
		
		return($arrParams);
	}
	
	
	/**
	 * icon library add params
	 */
	public function getAddParams_iconLibrary(){
		
		$arrParams = array();
		
		$arrParams[] = $this->createAddParam(null);
		$arrParams[] = $this->createAddParam("html|raw");

		
		return($arrParams);
	}
	
	
	
}

