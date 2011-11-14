<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last">
            <div id="sidebar">
                <?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
            </div>
            <div id="tag-cloud">

                <?php //if($this->beginCache('tagCloud', array('duration'=>3600))) { ?>

                    <?php if(!Yii::app()->user->isGuest) $this->widget('TagCloud'); ?>

                <?php //$this->endCache(); } ?>

            </div>
            <?php $this->widget('RecentComments', array(
                'maxComments'=>Yii::app()->params['recentCommentCount'],
            )); ?>

	</div>
</div>

<?php $this->endContent(); ?>