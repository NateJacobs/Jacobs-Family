<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
  	<?php $image_meta = wp_get_attachment_metadata(); ?>
    <header>
		
    </header>
    <div class="entry-content">
		<p class="attachment">
			<?php echo wp_get_attachment_image( $post->ID, 'full', false, [ 'class' => 'jfg-single-image img-responsive wp-attachment-large' ] ); ?>
		</p>
		<?php if(!empty($post->post_excerpt)): ?>
			<?php $width = $image_meta['width'] > '1000' ? '' : 'style="width: ' . (int) $image_meta['width'] . 'px;"';?>
			<figure <?php echo $post->ID ?> <?php echo $width; ?> class="bg-warning">
				<figcaption class="wp-caption-text"><?php echo $post->post_excerpt; ?></figcaption>
			</figure>
			<br>
		<?php endif; ?>
		<?php the_content(); ?>
    </div>
    <footer class="well">
    		<div class="row">
    			<?php $camera_details =  empty($image_meta['image_meta']['camera']) ? false : true; ?>
    			<div class="col-sm-6">
    				<h4><span class="glyphicon glyphicon-picture"></span> Image Details</h4>
    				<?php $upload_date = get_post_meta( $post->ID, '_original_upload', true ) ? mysql2date( get_option( 'date_format' ), get_post_meta( $post->ID, '_original_upload', true ) ) : get_the_date(); ?>
		    		<ul>
		    			<li>Title: <?php the_title(); ?></li>
		    			<li>Uploaded by: <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></li>
		    			<li>Upload Date: <?php echo $upload_date; ?></li>
		    			<br>
		    			<?php if( $camera_details ): ?>
	    				<li>Date/Time: <?php echo date( 'l F d, Y @ h:i a', $image_meta['image_meta']['created_timestamp'] ); ?></li>
		    			<li>Aperture: <?php echo $image_meta['image_meta']['aperture']; ?></li>
		    			<li>Focal Length: <?php echo $image_meta['image_meta']['focal_length']; ?></li>
		    			<li>Shutter Speed: <?php echo $image_meta['image_meta']['shutter_speed']; ?></li>
		    			<li>Camera: <?php echo ucwords( strtolower( $image_meta['image_meta']['camera'] ) ); ?></li>
					<?php endif; ?>
		    		</ul>
		    		<h4><span class="glyphicon glyphicon-download"></span> Image Sizes</h4>
    				<p>The image is available in the following sizes.</p>
				<p><?php echo jfg_get_image_size_links(); ?></p>
    			</div>
    			<div class="col-sm-6">
    				<h4><span class="glyphicon glyphicon-user"></span> People</h4>
    				<?php $terms = wp_get_post_terms($post->ID, 'photo-people'); ?>
    				<?php if(empty($terms)): ?>
    					<p>No people have been tagged.</p>
    				<?php else: ?>
    					<ul class="list-inline">
	    				<?php foreach($terms as $term): ?>
	    					<li><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name ?></a></li>
	    				<?php endforeach; ?>
	    				</ul>
    				<?php endif; ?>
    				<h4><span class="glyphicon glyphicon-globe"></span> Locations</h4>
    				<?php $terms = wp_get_post_terms($post->ID, 'photo-location'); ?>
    				<?php if(empty($terms)): ?>
    					<p>No locations have been added.</p>
    				<?php else: ?>
    					<ul class="list-inline">
	    				<?php foreach($terms as $term): ?>
	    					<li><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name ?></a></li>
	    				<?php endforeach; ?>
	    				</ul>
    				<?php endif; ?>
    				<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-location">Add locations</button>
    				<div id="add-location" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Add a Location</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<span id="photo-attachment-id" data-photo="<?php echo esc_attr( $post->ID ); ?>"></span>
										<?php wp_dropdown_categories(['taxonomy' => 'photo-location', 'hide_empty' => false, 'class' => 'form-control', 'id' => 'photo-location-select', 'show_option_none' => 'Pick a location']); ?>
										<br>
										<label for="person-name">Location not in the list?</label>
										<input type="text" class="form-control" id="location-name" name="location-name">
									</div>
									<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary btn-sm">Add</button>
								</form>
							</div>
						</div>
					</div>
				</div>
    			</div>
    		</div>
    </footer>
    <footer>
	    <ul role="navigation" id="<?php echo esc_attr( $post->ID ); ?>" class="post-navigation pager hidden-print">
	        <li class="nav-previous previous"><?php previous_image_link( false, '<span class="glyphicon glyphicon-arrow-left"></span> Previous Image' ); ?></li>
	        <li class="nav-next next"><?php next_image_link( false, 'Next Image <span class="glyphicon glyphicon-arrow-right"></span>' ); ?></li>
		</ul>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
  	<div id="photo-people-json" class="hidden"><?php echo get_post_meta($post->ID, '_jfg_photo_people', true); ?></div>
	<div id="image-add-person" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Who is this?</h4>
				</div>
				<div class="modal-body">
					<span id="photo-attachment-id" data-photo="<?php echo esc_attr( $post->ID ); ?>"></span>
					<?php wp_dropdown_categories(['taxonomy' => 'photo-people', 'hide_empty' => false, 'class' => 'form-control', 'id' => 'photo-people-select', 'show_option_none' => 'Pick a name']); ?>
					<br>
					<label for="person-name">Name not in the list?</label>
					<input type="text" class="form-control" id="person-name" name="person-name">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-photo-tag">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<?php endwhile; ?>