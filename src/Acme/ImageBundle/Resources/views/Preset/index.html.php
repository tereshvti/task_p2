<?php $view->extend('AcmeImageBundle::layout.html.twig') ?>

<?php $view['slots']->start('title') ?> Symfony - Task! <?php $view['slots']->stop() ?>

<?php $view['slots']->set('content_header', '') ?>
<?php $view['slots']->start('content') ?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

	<div style="width:400px;float:left">
		<h1> List of presets: </h1> </br>
		<?php foreach($presets as &$preset) { ?>
			<li>
				<input type="radio" name="preset" value="{{preset.id}}">
				<?php echo $preset->getName() . " " . $preset->getMode() . " " . $preset->getWidth() . " " . $preset->getHeight() ?> | 

				</br>
			</li>
		<?php } ?>

		</br>
		<a href={{ path('new_preset') }}>Create preset</a>
	</div>
	
	
	
	
<script>
	function aButtonPressed(){
		$.post('{{path('ajax_update_mydata')}}',               
					{preset: $("input[name='preset']:checked").val(), image: $("input[name='origin']:checked").val()}, 
				function(response){
						if(response.code == 100 && response.success){
							alert('Image successfully resampled');
						}

		}, "json");    
	}

	$(document).ready(function() {     
	  $('.ajax').on('click', function(){aButtonPressed();});
	});	
</script>

<?php $view['slots']->stop() ?>


