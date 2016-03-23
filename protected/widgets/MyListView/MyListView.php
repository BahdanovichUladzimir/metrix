<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 21.05.2015
 */
Yii::import('zii.widgets.CListView');
class MyListView extends CListView{

    public $counter;
    public function run(){
        $this->registerClientScript();
        // this line renders the first div
        //echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

        $this->renderContent();
        $this->renderKeys();

        //echo CHtml::closeTag($this->tagName);
    }

    public function renderItems(){
        //this line renders the second div
        //echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $viewFile=$owner->getViewFile($this->itemView);
            $j=0;
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->renderFile($viewFile,$data);
                if($this->counter>4){

                }
                if($j++ < $n-1)
                    echo $this->separator;
            }
        }
        else
            $this->renderEmptyText();
        //echo CHtml::closeTag($this->itemsTagName);
    }
}