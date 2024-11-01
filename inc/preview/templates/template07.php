<div class="wpucv-list wpucv-style07">
	<?php for( $i = 0; $i < $_wpucv_posts_per_page; $i++ ): ?>
	<?php $dp = $demo_posts[ $i ]; ?>
	<article class="clearfix" itemscope itemtype="http://schema.org/Article">
		<h2 class="wpucv-post-title" itemprop="name headline">
			<a href="javascript:void(0);"><?php echo wpucv_esc($dp['title']); ?></a>
		</h2>
		<?php $this->get_preview_post_meta( $dp['author'], $dp['date']); ?>
	</article>
	<?php endfor; ?>
</div>