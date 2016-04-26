<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 20.05.2015
 */

class CurrenciesCommand extends CConsoleCommand{


    public function actionParse(){
        Yii::import('vendor.CBRAgent.CBRAgent');
        $cbr = new CBRAgent();
        if ($cbr->load()){
            $usdRate = $cbr->get('USD');
            $eurRate = $cbr->get('EUR');
            $byrRate = $cbr->get('BYR');
            $kztRate = $cbr->get('KZT');
            echo "USD \r\n";
            echo $usdRate."\r\n";
            echo "EUR \r\n";
            echo $eurRate."\r\n";
            echo "BYR \r\n";
            echo $byrRate."\r\n";
            echo "KZT \r\n";
            echo $kztRate."\r\n";
            $byr = Currencies::model()->find('t.key=:key',array(":key" => "BYR"));
            $usd = Currencies::model()->find('t.key=:key',array(":key" => 'USD'));
            $eur = Currencies::model()->find('t.key=:key',array(":key" => 'EUR'));
            $kzt = Currencies::model()->find('t.key=:key',array(":key" => 'KZT'));

            if(!is_null($byr)){
                $byr->rate = (float)$byrRate;
                $byr->date = time();
                $byr->save();
            }
            if(!is_null($eur)){
                $eur->rate = (float)$eurRate;
                $eur->date = time();
                $eur->save();
            }
            if(!is_null($usd)){
                $usd->rate = (float)$usdRate;
                $usd->date = time();
                $usd->save();
            }
            if(!is_null($kzt)){
                $kzt->rate = (float)$usdRate;
                $kzt->date = time();
                $kzt->save();
            }
        }
    }
}