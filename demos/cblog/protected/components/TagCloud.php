<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
    public $title='Tags';
    public $maxTags=20;

    protected function renderContent()
    {
        $tags=Tag::model()->findTagWeights($this->maxTags);

//        foreach ( $tags as $tag ) {
//            print $tag->name. " ";
//        }

        foreach($tags as $tag=>$weight)
        {
            $link=CHtml::link(CHtml::encode($tag), array('post/index','tag'=>$tag));
            echo CHtml::tag('span', array(
                'class'=>'tag',
                'style'=>"font-size:{$weight}pt",
            ), $link)."\n";
        }
    }
}

?>
