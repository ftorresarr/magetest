<?php
class Yougento_Youmaps_Model_Attribute_Frontend_Map extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
	public function getRawValue(Varien_Object $object)
	{
		return parent::getValue($object);
	}
	
    public function getValue(Varien_Object $object)
    {
        $data  = '';
        if ($value = parent::getValue($object)) {
        	$tmp=explode('/',$value);
			$latlng=$tmp[0];
			$address=$tmp[1];
			if(Mage::getStoreConfig('youmaps/youmaps_group/youmaps_product_map_width',Mage::app()->getStore())!=NULL){
				$width=Mage::getStoreConfig('youmaps/youmaps_group/youmaps_product_map_width',Mage::app()->getStore());
			}
			else{
				$width="660";
			}
			if(Mage::getStoreConfig('youmaps/youmaps_group/youmaps_product_map_height',Mage::app()->getStore())!=NULL){
				$height=Mage::getStoreConfig('youmaps/youmaps_group/youmaps_product_map_height',Mage::app()->getStore());
			}
			else{
				$height="330";
			}
            $data = '<strong><address>'.$address.'</address></strong>
            <style type="text/css">
				#map_container { height:'.$height.'px; width:'.$width.'px;margin:0;}
				#map_canvas {width:100%;height:100%;}
			</style>
			<div id="map_container"><div id="map_canvas"></div></div>
			<script type="text/javascript"
		      src="http://maps.googleapis.com/maps/api/js?key='.Mage::getStoreConfig('youmaps/youmaps_group/youmaps_apikey',Mage::app()->getStore()).'&sensor=false">
		    </script>
		        <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"
     		 type="text/javascript"></script>
		    <script type="text/javascript">
		    var citymap = {};
			citymap["area"] = {
			  center: new google.maps.LatLng('.$latlng.')
			};
			var cityCircle;
			var myLatlng = new google.maps.LatLng('.$latlng.');
			function initialize() {
			  var mapOptions = {
			    zoom: 16,
			    center: new google.maps.LatLng('.$latlng.'),
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			  };
			
			  var map = new google.maps.Map(document.getElementById("map_canvas"),
			      mapOptions);';
			$config=Mage::getStoreConfig('youmaps/youmaps_group/youmaps_message');
				if($config==1){
					$data.= '		
									marker = new google.maps.Marker({
								      		position: myLatlng,
											map: map
								        });';
				}else{
			$data.=  '
			    // Construct the circle for each value in citymap. We scale population by 20.
			    var populationOptions = {
			      strokeColor: "#FF0000",
			      strokeOpacity: 0.8,
			      strokeWeight: 2,
			      fillColor: "#FF0000",
			      fillOpacity: 0.35,
			      map: map,
			      center: myLatlng,
			      radius: 500
			    };
			    cityCircle = new google.maps.Circle(populationOptions);';
				} 
			$data.='
			}
			google.maps.event.addDomListener(window, "load", initialize);
		   </script> ';
        }
        return $data;
    }
}