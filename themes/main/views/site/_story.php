<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.06.2015
 * @var $data CmsPage
 */
;?>
<?php /*
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1><?=$data->name;?></h1>
        <p><?=$data->content->body;?></p>
        <a rel="nofollow" href="<?=Yii::app()->cms->createUrl($data->name);?>"><?=$data->content->heading;?></a>
    </div>
</div>*/?>

<?php $title = $data->content->heading == null ? $data->name : $data->content->heading;
$str = $data->content->body;?>
<div class="row news">
    <?php /*<div class="col-md-3 col-sm-5 col-xs-6">
        <?php

        preg_match('/<img[^>]+>/i', $str, $media);

        if ($media[0] != '') {
            $media[0] = preg_replace('/<img.*?src="(.*?)".*?>/im', '<img src="$1" />', $media[0]);
            echo CHtml::link($media[0], Yii::app()->cms->createUrl($data->name));
        } else
            echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/nofoto.jpg'), Yii::app()->cms->createUrl($data->name));
        ?>
    </div>*/?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php echo CHtml::link(CHtml::encode($title), Yii::app()->cms->createUrl($data->name)); ?>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>
                    <?php
                    $str = strip_tags($str);
                    if (strlen($str) > 700) {
                        $str = preg_replace("#(https?|ftp)://\S+[^\s.,>)\];'\"!?]#", '<a href="\\0">\\0</a>', $str);
                        $str = substr($str, 0, 700);
                        $str = substr($str, 0, strrpos($str, ' '));
                    }
                    echo $str . '...';
                    ?>
                </p>

                <div style="margin-top: 10px;">
                    <div class="pull-left">
                        <?php echo 'Опубликовано: ' . date('d.m.y H:i:s', strtotime($data->created)); ?>
                    </div>
                    <div class="pull-right">
                        <?php echo CHtml::link('подробнее', Yii::app()->cms->createUrl($data->name)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>