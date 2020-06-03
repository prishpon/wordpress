<?php/*
Template Name: Front-page
Template Post Type:front-page*/
?>

<?php get_header();
?>
<main>
<section class="container">
  <?php get_template_part( 'slider' ); ?>
</section>

        <section class="container">
          <div id="dynamic-content">
        <?php
         if ( have_posts() ) {
            while ( have_posts() ) {
            the_post();
        the_content(); ?>
          </div>
          <?php 
} // end while
} // end if
?>
       
        </section>
        <section class="container text-center">

            <h1 class="h2 font-weight-bold my-4">Recent articles</h1>

            <div class="row wow fadeIn">
            <?php
$args = array('post_type' => 'post');
 
  $query = new WP_Query($args);	

  while ( $query->have_posts() ) {
	$query->the_post();  ?>
                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4">
                    <!--Featured image-->
                    <div class="view overlay hm-white-slight rounded z-depth-2 mb-4">
                    <?php the_post_thumbnail( 'medium-large', array( 'class'=> 'img-fluid')); ?>
                        <a href="<?php the_permalink(); ?>">
                            <div class="mask"></div>
                        </a>
                    </div>

                    <!--Excerpt-->
                    <a href="<?php echo  get_permalink();?>" class="pink-text">
                        <h6 class="mb-3 mt-4">
                            <i class="fa fa-bolt"></i>
                            <strong><?php the_category(', '); ?></strong>
                        </h6>
                    </a>
                    <h4 class="mb-3 font-weight-bold dark-grey-text">
                        <strong><?php	echo get_the_title(); ?></strong>
                    </h4>
                    <p>by
                        <a class="font-weight-bold dark-grey-text"><?php echo get_the_author(); ?></a><?php echo get_the_date(); ?></p>
                  
                    <a href="<?php echo get_permalink() ?>"class="btn btn-info btn-rounded btn-md">Read more</a>
                </div>
              
<?php
}
		?>
 
            </div>
        </section>
    </div>
</main>
<?php get_footer(); ?>