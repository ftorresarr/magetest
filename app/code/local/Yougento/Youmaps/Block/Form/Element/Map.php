<?php

class Yougento_Youmaps_Block_Form_Element_Map extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('youmap');
		$this->setExtType('youmap');
    }
    
    public function getHtml()
    {
        $this->addClass('input-text');
        return parent::getHtml();
		
    }
	    public function getElementHtml()
    {
        $html = $this->getAfterElementHtml();
		$html.= '';
        return $html;
    }

    public function getLabelHtml($idSuffix = ''){
        if (!is_null($this->getLabel())) {
            $html = '<label for="'.$this->getHtmlId() . $idSuffix . '" style="'.$this->getLabelStyle().'">'.$this->getLabel()
                . ( $this->getRequired() ? ' <span class="required">*</span>' : '' ).'</label>'."\n";
        }
        else {
            $html = '';
        }
        return $html;
	}
	
	public function getAddress(){
		if($this->getValue()!=NULL){
			$latng=explode('/',$this->getValue());
			$address=$latng[1];
		}else{
			$address='';
		}
		return $address;
	}
	
	public function getAfterElementHtml(){
		if($this->getValue()!=NULL){
		$latng=explode('/',$this->getValue());
		$latlng=$latng[0];
		$address=$latng[1];
		}else{
			$latlng='';
			$address='';
		}
		$html= '<input  id="searchTextField" class="input-text ';
		if($this->getRequired()){
			$html.='required-entry';
		}
		$html.='" value ="'.$this->getAddress().'" name="product['.$this->getData('name').']"/>';
		$html.= '        <style type="text/css">
						#map_container { height:500px; width:700px;margin:0;}
						#map_canvas {width:700px;height:500px;}
				    </style>
			<div id="map_container"><div id="map_canvas" ></div></div>
			<script type="text/javascript"
		      src="http://maps.googleapis.com/maps/api/js?key='.Mage::getStoreConfig('youmaps/youmaps_group/youmaps_apikey',Mage::app()->getStore()).'&sensor=false">
		    </script>
		        <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"
     		 type="text/javascript"></script>
		    <script type="text/javascript">
		    var myTabs = $$("#product_info_tabs li a.tab-item-link");
						
		    var map;
		    function resize(){
					google.maps.event.trigger(map, "resize");
					bounds.extend(myLatlng);
					map.fitBounds(bounds);';
			if($this->getValue()==NULL){
          	 $html.= ' map.setZoom(5); ';
		  } 
					
					
		    $html.= '  };
			  

			var marker;';
			if($this->getValue()!=NULL){
          	 $html.= 'var myLatlng = new google.maps.LatLng('.$latlng.');
			
			';
		  } else{
		  	 $html.= 'var myLatlng = new google.maps.LatLng(41.885921, 12.476806);
			
			';
			
		  }          	
			 $html.= 'var bounds = new google.maps.LatLngBounds();
			 function initialize() {
			      	var markerBounds = new google.maps.LatLngBounds();
        var mapOptions = {
          ';
          if($this->getValue()!=NULL){
          	 $html.= 'center: myLatlng,
          	 zoom: 16,';
		  } else{
		  	$html.=  'center: myLatlng,
		  	zoom: 3,';
		}
		  	$html.='
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
          mapOptions);

        var input = document.getElementById("searchTextField");
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo("bounds", map);

        var infowindow = new google.maps.InfoWindow();';
        if($this->getValue()!=NULL){
	    $html.=  'markerOne = new google.maps.Marker({
	       		position: myLatlng,
				map: map
	        });';
			}
		
        $html.= 'google.maps.event.addListener(autocomplete, "place_changed", function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(16);  // Why 17? Because it looks good.
          }
		  marker = new google.maps.Marker({
	       		position: place.geometry.location,
				map: map
	        });
		//	marker = new google.maps.Marker;
        //  marker.setPosition(place.geometry.location);

          var address = "";
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ""),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ""),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || "")
                      ].join(" ");
          }

          infowindow.setContent("<div><strong>" + place.name + "</strong><br>" + address);
          infowindow.open(map, marker);
        });
		autocomplete.setTypes(["geocode"]); 
        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
		function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          google.maps.event.addDomListener(radioButton, "click", function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener("changetype-all", []);
        setupClickListener("changetype-establishment", ["establishment"]);
        setupClickListener("changetype-geocode", ["geocode"]);
      }
			
			function toggleBounce() {
			
			  if (marker.getAnimation() != null) {
			    marker.setAnimation(null);
			  } else {
			    marker.setAnimation(google.maps.Animation.BOUNCE);
			  }
			}
				

			for (var i = 0; i < myTabs.length; i++) {
				google.maps.event.addDomListener(window, "load", initialize);
			    Event.observe(myTabs[i], "click", function (event) {
			        setTimeout("resize()", 500);
					Event.stopObserving(myTabs[i], "click");
			    });
			}
			 
			
		    </script>
		    
			
		';
		return $html;
	}
}
?> 