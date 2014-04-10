<?php get_header(); ?>

  <!-- start -->
	<div class="container loop-<?php echo get_post_type(); ?>"> 

	<?php if( is_archive() ): ?>
		<h2 class="section_title"><?php wp_title('',true); ?></h2>
	<?php endif; ?>

	<?php if(have_posts()): ?>

      <?php while(have_posts()):the_post(); ?>
      
      <div <?php post_class(); ?>>
      	
          <?php if(!is_page()): ?>
            <div class="meta">
              <!-- <div class="publish_date"><?php the_time('d/m/Y') ?></div> -->
              <!-- <div class="terms">Categoria: <?php the_category(', '); ?></div> -->
              <!-- <div class="author">Por: <?php the_author(); ?></div> -->
              <!-- <div class="comments_link"><a href="<?php comments_link(); ?>"><?php comments_number('Seja o primeiro a comentar','Comentários (1)','Comentários (%)') ?></a></div> -->
              <p class="post-info"><!-- Postado por <strong><?php the_author(); ?></strong> em  --><strong><?php echo get_the_date('d \d\e F \d\e Y'); ?></strong></p>
            </div>
          <?php endif; ?>
          
          <div class="entry">
          
              <?php if(is_single() || is_page()): ?>
                  <h2 class="single_title"><?php the_title(); ?></h2>	
              <?php else: ?>
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <?php endif ?>
              
              <?php if(is_single() || is_page()): ?>
                  <?php the_content(); ?>	
              <?php else: ?>
                  <?php the_excerpt(); ?>
                  <a class="btn btn-xs btn-danger" href="<?php the_permalink(); ?>">Ver mais...</a>
              <?php endif ?>
              
              <?php if(is_single() || is_page()) wp_link_pages( array( 'before' => '<div class="page-link">', 'after' => '</div>' ) ); ?>
          
          </div><!-- end .entry -->
          
          <!-- <div class="tags"><?php the_tags(); ?></div> -->
          <!-- <div class="clear">&nbsp;</div>  -->
            
      </div><!-- end .post --> 
      <?php endwhile; ?>

	    <?php 
    		if(function_exists('cp_paginate_links')):
    			cp_paginate_links(); 
    		else:
    			posts_nav_link();
    		endif;	
  		?>
	    
    <?php if( is_single() ) comments_template(); ?>
	    
	<?php else: ?>
	    <p class="msg_info">Desculpe, nenhum resultado encontrado!</p>
	<?php endif; ?>
	</div><!-- .container -->
  <!-- end -->

<?php get_footer(); ?>