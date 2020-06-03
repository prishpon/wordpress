<?php/*
Template Name: Page
Template Post Type:page*/
?>
<?php
get_header();
?>
<div class="container">
<div class ="row justify-content-center">
	 <div class="col-md-10">


<?php the_post(); ?>

<h1><?php the_title() ?></h1>
<?php if ( has_post_thumbnail()) { ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
        <?php the_post_thumbnail(); ?>
        </a>
      <?php } ?>

<p><?php the_content(); 

?></p>

	</div>

	 
		 </div>
		 </div>
		 </div>
	<?php get_footer(); ?>