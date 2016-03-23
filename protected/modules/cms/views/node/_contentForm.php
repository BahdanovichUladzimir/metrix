<?php
/**
 * @var PageController $this
 */
;?>
<fieldset class="form-content">
    <h2><?php echo 'Content' ?></h2>
    <?php
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'pills',
        'tabs' => $this->getLanguageTabs($form, $model),
    ));
    ?>
</fieldset>
