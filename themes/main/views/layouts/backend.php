<?php
/**
 * @var $this RController
 * @var string $content
 */
?>
<?php $moduleId = Yii::app()->controller->module->getId();?>
<?php $controllerId = Yii::app()->controller->getId();?>
<?php $actionId = Yii::app()->controller->action->getId();?>
<html lang="en">
	<head>
        <?php $this->renderPartial("//layouts/partials/_backend_head");?>
	</head>
	<body>
		<?php $this->widget(
			'booster.widgets.TbNavbar',
			array(
				//'type' => 'inverse',
				'brand' => Yii::app()->name,
				'brandUrl' => Yii::app()->homeUrl,
				'collapse' => true, // requires bootstrap-responsive.css
				'fixed' => true,
				'fluid' => false,
				'items' => array(
					array(
						'class' => 'booster.widgets.TbMenu',
						'type' => 'navbar',
						'items' => array(
						),
					),
					array(
						'class' => 'booster.widgets.TbMenu',
						'type' => 'navbar',
						'htmlOptions' => array('class' => 'pull-right'),
						'items' => array(
							array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
							array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
							//array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
							array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
							//'---',
							/*array(
								'label' => 'Dropdown',
								'url' => '#',
								'items' => array(
									array('label' => 'Action', 'url' => '#'),
									array('label' => 'Another action', 'url' => '#'),
									array(
										'label' => 'Something else here',
										'url' => '#'
									),
									'---',
									array('label' => 'Separated link', 'url' => '#'),
								)
							),*/
						),
					),
				),
			)
		);?>
		<div class="container">
            <div class="row row-offcanvas row-offcanvas-right">
                <div class="col-sm-3 col-md-3">
                    <?php $this->renderPartial(
                        '//layouts/partials/_backend_menu',
                        array(
                            'moduleId' => $moduleId,
                            'controllerId' => $controllerId,
                            'actionId' => $actionId
                        )
                    );?>
                </div>
                <div class="col-xs-12 col-sm-9">
					<?php if (Yii::app()->user->hasFlash('success') != null): ?>
						<div class="alert alert-info" style="margin: 10px 0 0 0;">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo Yii::app()->user->getFlash('success'); ?>
						</div>
					<?php endif; ?>
					<?php
					$this->widget(
						'booster.widgets.TbBreadcrumbs',
						array(
							//'homeLink' => 'Home',
							'links' => $this->breadcrumbs
						)
					);
					;?>
					</div>

					<div class="col-xs-12 col-sm-9">
						<?php echo $content; ?>
					</div>

				</div>

				<hr>

				<footer>
					<p>&copy; <?=Yii::app()->name;?></p>
				</footer>

			<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
			<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);?>
			<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-noconflict.js', CClientScript::POS_END);?>
			<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootbox.min.js', CClientScript::POS_END);?>
			<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/notify.min.js', CClientScript::POS_END);?>

			<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-cookie/src/jquery.cookie.min.js', CClientScript::POS_END);?>
            <?php /*if(Yii::app()->user->checkAccess('Translate.Translate.Update') && Yii::app()->user->checkAccess('Translate.Translate.Create')):*/?><!--
                <?php /*Yii::app()->translate->renderMissingTranslationsEditor();;*/?>
            --><?php /*endif;*/?>

        </div>
	</body>
</html>
