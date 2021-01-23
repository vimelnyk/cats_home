<?php
/**
 * Template part for displaying posts
 * @subpackage hexagon
 * @since 1.0
 * @version 1.4
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="article_content">
    <div class="metabox"> 
      <span class="entry-author"><i class="fas fa-user"></i><?php esc_html(the_author()); ?></span>
      <span class="entry-date"><i class="fas fa-calendar-alt"></i><?php echo esc_html( get_the_date()); ?></span>
      <span class="entry-comments"><i class="fas fa-comments"></i><?php comments_number( __('0 Comments','hexagon'), __('0 Comments','hexagon'), __('% Comments','hexagon') ); ?></span>
    </div>
    <?php if(has_post_thumbnail()) { ?>
      <?php the_post_thumbnail(); ?>  
    <?php }?>
    <h3><?php esc_html(the_title()); ?></h3>
    <p><?php the_excerpt(); ?></p>
    <div class="read-btn">
      <a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr_e( 'READ MORE', 'hexagon' ); ?>"><?php esc_html_e('READ MORE','hexagon'); ?>
      </a>
    </div>
    <div class="clearfix"></div> 
  </div>
</div>