<?php $utilities = new FamilyRootsUtilities(); ?>
<?php $places = $utilities->get_all_places(); ?>
<h1>Places</h1>
<?php if($places): ?>
	<ul class="list-inline">
	<?php foreach($places as $place): ?>
	  <?php if( is_user_logged_in() ): ?>
        <li>
	        <a href="<?php echo $utilities->get_place_url($place->ID); ?>"><?php echo $place->place; ?></a>
        </li>
	  <?php else: ?>
	      <?php if( !is_numeric( substr( $place->place, 0, 1 ) ) ): ?>
		    <li>
		      <a href="<?php echo $utilities->get_place_url($place->ID); ?>"><?php echo $place->place; ?></a>
		    </li>
		    <?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
