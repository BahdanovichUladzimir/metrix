<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 13.03.2015
 */

class FavoritesCommand extends CConsoleCommand{

    public function actionClearCookiesFavorites(){
        $now = time();
        $outdatedCookies = FavoritesCookies::model()->findAll("expire<:expire", array(":expire" => $now));
        if(sizeof($outdatedCookies)>0){
            foreach($outdatedCookies as $cookie){
                $cookie->delete();
            }
        }
    }
}