<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 09.07.2015
 */
;?>
<script>
    if (window.location.hash) {
        var lochash = location.hash.substr(1);
        window.location.href = '<?=Yii::app()->createUrl("/user/login/vkAuthenticate");?>?'+lochash;
    }
</script>
