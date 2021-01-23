<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<?php do_action( 'hexagon_above_slider' ); ?>

<?php if( get_theme_mod('hexagon_slider_hide_show') != ''){ ?>
  	<section id="category">
  		<div class="shape"></div>
  		<div class="slider">
			<div class="row owl-carousel m-0">
		        <?php 
		        $hexagon_catData = get_theme_mod('hexagon_slider_cat');
		        if($hexagon_catData){              
			        $page_query = new WP_Query(array( 'category_name' => esc_html( $hexagon_catData ,'hexagon')));?>
			        <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
			        	<div class="container">
				          	<div class="row">
					            <div class="col-lg-7 col-md-7">
					              	<div class="text-content">
										<h1><?php esc_html(the_title()); ?></h1>
										<p><?php the_excerpt(); ?></p>
										<div class="read-btn">
											<a href="<?php esc_url(the_permalink()); ?>"><?php echo esc_html_e('Read More','hexagon'); ?></a>
										</div>
					              	</div>
					            </div>
					            <div class="col-lg-5 col-md-5">
					              	<div class="imagebox">
					                	<a href="<?php esc_url(the_permalink()); ?>"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></a>
					              	</div>
					            </div>
				          	</div>
				        </div>
		          	<?php endwhile; 
		      		wp_reset_postdata();
		        }
		        ?>
	      	</div>
	    </div>
	</section>
<?php }?>

<?php do_action('hexagon_below_slider'); ?>

<?php /*--Services Section --*/?>
<?php if( get_theme_mod('hexagon_arrange_cat') != '' || get_theme_mod('hexagon_section_title') != '' ){ ?>
	<section id="our_service">
		<div class="container">
			<div class="service-box">
				<?php if( get_theme_mod('hexagon_section_title') != ''){ ?>
		    		<h2><?php echo esc_html(get_theme_mod('hexagon_section_title','')); ?></h2>
		    	<?php }?>
	            <div class="row">
		      		<?php $hexagon_catData1=  get_theme_mod('hexagon_services_cat'); 
		      		if($hexagon_catData1){ 
		      			$page_query = new WP_Query(array( 'category_name' => esc_html($hexagon_catData1 ,'hexagon')));?>
		        		<?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>	
		          			<div class="col-lg-3 col-md-4">	
						      	<div class="content-topic">
						      		<?php the_post_thumbnail(); ?>
							      	<h3><?php esc_html(the_title()); ?></h3>
							      	<div class="cat-btn">
							      		<a href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e('Read More','hexagon'); ?></a>
		          					</div>
	          					</div>
							</div>
		          		<?php endwhile; 
		          		wp_reset_postdata();
		          	}?>
	      		</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
<?php }?>

<?php do_action('hexagon_below_services_section'); ?>

<div class="container">
  	<?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>