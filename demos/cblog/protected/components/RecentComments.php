<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import('zii.widgets.CPortlet');

class RecentComments extends CPortlet
{
    public $title='Последние комментарии';
    public $maxComments=10;

    public function getRecentComments()
    {
        return Comment::model()->findRecentComments($this->maxComments);
    }

    protected function renderContent()
    {
        $this->render('recentComments');
    }
}


?>
