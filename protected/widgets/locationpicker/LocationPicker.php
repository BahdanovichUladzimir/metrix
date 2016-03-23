<?php
/**
 * LocationPicker class file.
 *
 * @author Febrianto Arif <febri@indoartha.co.id>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * LocationPicker displays a map using Google Map
 *
 * This widget will return the output of 2 hidden textfield : lat & lon
 * These textfield will contains the coordinate of current location.
 *
 * <pre>
 * $this->widget('ext.locationpicker.LocationPicker', array(
 *			'latId' => "lat",
 *			'lonId' => "lon",
 *     ),
 * ));
 * </pre>
 *
 *
 * @author Febrianto Arif <febri@indoartha.co.id>
 * @package ext.locationpicker
 * @since 1.0
 */
class LocationPicker extends CWidget
{
	public $latId = "lat";
	public $lonId = "lng";
	public $height = "250px";
	public $searchLabel = "Search";
	public $model;
	public $ltnCenter;
	public $lngCenter;
	
	/**
	 * Initializes the menu widget.
	 * This method mainly normalizes the {@link items} property.
	 * If this method is overridden, make sure the parent implementation is invoked.
	 */
	public function init()
	{
		//echo CHtml::openTag('div', array("id"=>"divsearch",'class'=>'form-inline'));
		//echo CHtml::tag("input", array("id"=>"searchtext", "type"=>"text",'class'=>"form-control"));
		//echo CHtml::openTag("button", array("id"=>"searchbutton", "class"=>"btn btn-primary"));
		//echo $this->searchLabel;
		//echo CHtml::closeTag('button');
		//echo CHtml::closeTag('div');
		echo CHtml::openTag('div',array("id"=>"clocationmap", "style"=>"height:".$this->height))."\n";
		echo CHtml::closeTag('div');
		echo CHtml::openTag('button',array('id'=>'clear_coordinates_button', "class"=>"btn btn-primary"));
        echo Yii::t('dealsModule',"Clear coordinates");
		echo CHtml::closeTag('button');

		$randNumber = rand(0, 100000);
		$className = get_class($this->model);
		
		echo CHtml::hiddenField($className."[".$this->latId."]", $this->model->{$this->latId}, array("class"=>"lat_".$randNumber));
		echo CHtml::hiddenField($className."[".$this->lonId."]", $this->model->{$this->lonId}, array("class"=>"lon_".$randNumber));
		
/*		echo CHtml::openTag('script',array("src"=>"https://maps.googleapis.com/maps/api/js?key=AIzaSyAtc_4SE2BhMel6_WVpSBAjAeF1iczXUow&sensor=false"))."\n";
		echo CHtml::closeTag('script');*/
		//Yii::app()->getClientScript()->registerScriptFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyAtc_4SE2BhMel6_WVpSBAjAeF1iczXUow&sensor=false");
		
		echo CHtml::openTag('style');
		echo "#clocationmap img { max-width: none; }
			#divsearch { text-align : right }
			#divsearch input { margin : 5px }";
		echo CHtml::closeTag('style');
		
		ob_start();
		include("picker.js");
		$picker = ob_get_clean();
		
		Yii::app()->getClientScript()->registerScript('CLocationPicker',$picker, CClientScript::POS_BEGIN);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		
	}
}