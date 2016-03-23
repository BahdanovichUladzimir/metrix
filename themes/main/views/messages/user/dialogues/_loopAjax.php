<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 01.05.2015
 * @var $dataProvider CActiveDataProvider
 */
;?>
<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'dialog_messages_list',
    'dataProvider'=>$dataProvider,
    'itemView'=>'//messages/user/userMessages/_message',
    'ajaxUpdate'=>true,
    'template' => "{items}",
    'emptyText' => ''
)); ?>