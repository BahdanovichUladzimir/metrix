<?php /* @var $this RController */ ?>
<?php $moduleId = Yii::app()->controller->module->getId();?>
<?php $controllerId = Yii::app()->controller->getId();?>
<?php $actionId = Yii::app()->controller->action->getId();?>
<html lang="en">
	<head>
        <?php $this->renderPartial("//layouts/partials/_frontend_head");?>
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

					<div class="col-xs-4 col-sm-4">

					</div>

					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<?php echo $content; ?>
					</div>

					<div class="col-xs-4 col-sm-4">

					</div>


				</div>

				<hr>

				<footer>
					<p>&copy; <?=Yii::app()->name;?></p>
				</footer>

			</div>
	</body>
</html>
