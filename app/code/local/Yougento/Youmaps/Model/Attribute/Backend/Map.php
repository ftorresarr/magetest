<?php
class Yougento_Youmaps_Model_Attribute_Backend_Map extends Mage_Eav_Model_Entity_Attribute_Backend_Default
{
		public function afterSave($object)
	{
		if($object->getData($this->getAttribute()->getName())){
			$key=$object->getData($this->getAttribute()->getName());
	        $addr = urlencode($key);
	        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.$addr.'&sensor=false';
			$ch = curl_init();
	
			    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_URL, $url);
			    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
			
			    $data = curl_exec($ch);
			    curl_close($ch);
	        $records = json_decode($data,true);
			$myLct = $records['results'][0]['geometry']['location']['lat'].', '.$records['results'][0]['geometry']['location']['lng'].'/'.$key;
			$object->setData($this->getAttribute()->getName(), $myLct);
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
		}
		return $this;
    }
	
}
