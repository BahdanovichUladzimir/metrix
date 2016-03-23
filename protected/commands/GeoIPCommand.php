<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.05.2015
 */

class GeoIPCommand extends CConsoleCommand{


    public function actionTest(){
        Yii::import('application.vendor.ipgeobase.IPGeoBase');
        $citiesData = file("D:/OpenServer/domains/holidaysguide/protected/vendor/ipgeobase/cities.txt");
        $countriesData = file("D:/OpenServer/domains/holidaysguide/protected/vendor/ipgeobase/cidr_optim.txt");
        GeoipCities::model()->deleteAll();
        foreach($citiesData as $cityString){
            $cityArr = explode("\t", trim($cityString));
            $model = new GeoipCities();
            $model->geoip_city_id = $cityArr[0];
            $model->city_name_ru = $cityArr[1];
            $model->region = $cityArr[3];
            $model->district = $cityArr[2];
            $model->latitude = $cityArr[4];
            $model->longitude = $cityArr[5];
            $model->save();
        }
        foreach($countriesData as $countryString){
            $countryArr = explode("\t", trim($countryString));
            if($countryArr[4] != "-"){
                $city = GeoipCities::model()->findByAttributes(array('geoip_city_id' => $countryArr[4]));
                if(!is_null($city)){
                    $ipsModel = new GeoipCitiesIps();
                    $ipsModel->begin_ip = $countryArr[0];
                    $ipsModel->end_ip = $countryArr[1];
                    $ipsModel->city_id = $city->geoip_city_id;
                    $ipsModel->save();
                    $geoIpCountry = GeoipCountries::model()->findByAttributes(array('code' => $countryArr[3]));
                    if(!is_null($geoIpCountry)){
                        $city->geoip_country_id = $geoIpCountry->id;
                        $city->save();
                    }
                }
            }

        }
    }
}