<?php $this->beginContent(Rights::module()->appLayout); ?>


<?php if( $this->id!=='install' ): ?>
	<div class="row">
		<div class="col-xs-12">
			<?php $this->renderPartial('/_menu'); ?>
		</div>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-xs-12">
		<?php $this->renderPartial('/_flash'); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo $content; ?>
	</div>
</div>


<?php $this->endContent(); ?>