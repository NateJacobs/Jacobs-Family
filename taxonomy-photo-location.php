<header class="page-header">
	<?php $queried_object = get_queried_object(); ?>
	<h1 class="page-title">Family Photos &mdash; <?php echo $queried_object->name ?></h1>
</header>
<?php $attachment_iterator = 0; ?>
<div class="row">
	<?php while(have_posts()) : the_post(); ?>
		<div class="col-sm-3">
			<div class="entry-content">
				<?php $image_meta = wp_get_attachment_metadata(); ?>
				<p class="attachment">
					<a href ="<?php echo get_attachment_link(); ?>" class="thumbnail">
					<?php echo wp_get_attachment_image( $post->id, 'medium', false, [ 'class' => 'img-responsive wp-attachment-large' ] ); ?>
					</a>
				</p>
				<?php if(!empty($post->post_excerpt)): ?>
					<figure <?php echo $post->id ?> class="bg-warning">
						<figcaption class="wp-caption-text"><?php echo $post->post_excerpt; ?></figcaption>
					</figure>
					<br>
				<?php endif; ?>
		    </div>
		</div>
		<?php $attachment_iterator++; if ( $attachment_iterator % 4 == 0 ) echo '<div class="clearfix"></div>'; ?>
	<?php endwhile; ?>
</div>
<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('<span class="glyphicon glyphicon-arrow-left"></span> Older images', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer images <span class="glyphicon glyphicon-arrow-right"></span>', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>