<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 20.04.2015
 * @var int|string $moduleId
 * @var int|string $controllerId
 * @var int|string $actionId
 */
;?>
<header class="header-navbar">
    <?php $this->renderPartial(
        '//layouts/partials/_frontend_menu_new',
        array(
            'moduleId' => $moduleId,
            'controllerId' => $controllerId,
            'actionId' => $actionId
        )
    );?>
</header>
