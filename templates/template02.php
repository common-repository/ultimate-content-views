<?php
$_wpucv_grid_columns_num = (empty($_wpucv_grid_columns_num)) ? '3' : $_wpucv_grid_columns_num;
switch ($_wpucv_grid_columns_num) {
	case '1':
		$grid_classes = 'small-12';
		break;

	case '2':
		$grid_classes = 'small-12 medium-6';
		break;

	case '3':
		$grid_classes = 'small-12 medium-6 large-4';
		break;

	case '4':
		$grid_classes = 'small-12 medium-6 large-3';
		break;

	case '6':
		$grid_classes = 'small-12 medium-6 large-2';
		break;
}
?>

<div class="wpucv-list wpucv-style02">
	<?php if ($the_query->have_posts()) : ?>
		<div class="grid-x">
			<?php while ($the_query->have_posts()) : ?>
				<?php $the_query->the_post(); ?>
				<?php
				$large_image = get_the_post_thumbnail_url(get_the_ID(), 'wpucv-grid-one');
				$medium_image = get_the_post_thumbnail_url(get_the_ID(), 'wpucv-grid-two');
				$small_image = get_the_post_thumbnail_url(get_the_ID(), 'wpucv-grid-three');

				switch ($_wpucv_grid_columns_num) {
					case '1':
						$src = $large_image;
						$srcset = $medium_image . ' 600w, ' . $large_image . ' 800w';
						$sizes = '(max-width: 639px) 600w, (min-width: 640px) 800w';
						break;

					case '2':
						$src = $medium_image;
						$srcset = $small_image . ' 360w, ' . $medium_image . ' 600w';
						$sizes = '(max-width: 639px) 600w, (min-width: 1023px) 360w, (min-width: 1024px) 600w';
						break;

					case '3':
					case '4':
					case '6':
						$src = $small_image;
						$srcset = $small_image . ' 360w, ' . $medium_image . ' 600w';
						$sizes = '(max-width: 639px) 600w, (min-width: 640px) 360w';
						break;
				}
				?>

				<?php $title_attr = the_title_attribute(array('echo' => false)); ?>
				<?php $post_id = get_the_ID(); ?>
				<?php $post_permalink = esc_url(get_the_permalink()); ?>

				<?php $post_thumbnail_url = esc_url(get_the_post_thumbnail_url($post_id, 'wpucv-classic')); ?>

				<article id="post-<?php esc_attr(the_ID()); ?>" class="cell <?php echo esc_attr($grid_classes); ?>" itemscope itemtype="http://schema.org/Article">
					<a class="wpucv-image-link-wrapper" href="<?php echo $post_permalink; ?>" title="<?php echo esc_attr($title_attr); ?>">
						<?php if (has_post_thumbnail()) : ?>
							<img class="wpucv-image-responsive" src="<?php echo esc_url($src); ?>" srcset="<?php echo esc_attr($srcset); ?>" sizes="<?php echo esc_attr($sizes); ?>" title="<?php echo esc_attr($title_attr); ?>" alt="<?php echo esc_attr($title_attr); ?>" itemprop="image">
						<?php endif; ?>
					</a>
					<h2 class="wpucv-post-title" itemprop="name headline">
						<a href="<?php echo $post_permalink; ?>"><?php echo wpucv_esc(get_the_title()); ?></a>
					</h2>

					<?php $this->get_post_meta(); ?>

					<?php $this->get_excerpt(get_the_ID()); ?>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<p class="wpucv-no-found"><?php echo wpucv_esc($this->options['_wpucv_notfound_text']); ?></p>
	<?php endif; ?>
</div>