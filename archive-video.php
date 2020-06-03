<?php/*
Template Name: Video
Template Post Type:video
*/
?>
<?php
get_header();
?>
<main>

	 <?php  if( is_single( $post ) ){ ?>

		<div class="container">
        <div class="card-body white-text text-center yel mb-2 mt-2 px-5 pt-5 pb-4">
            <div class="row wow fadeIn d-flex justify-content-center yel pt-5 pb-4">
                <div class="col-md-6">
					<h1 class="font-weight-bold mb-4"><?php the_title(); ?></h1>
					<h3><?php echo get_post_meta(get_the_ID(), 'ganre', true); ?> </h3>
	                <h3><?php echo get_post_meta(get_the_ID(), 'order', true); ?> </h3>
                </div>
            </div>
    </div>
</div>
	

 <div class="container">
        <section class="mt-3">
            <div class="row wow fadeIn">
                <div class="col-md-8 mb-4">
                    <?php the_post_thumbnail( 'large', array( 'class'=> 'img-fluid z-depth-1-half mb-4')); ?>

                    <div class="card mb-4">
                        <div class="card-body">                 
        <p>ganre: </p>
         <?php echo get_post_meta(get_the_ID(), 'ganre', true); ?></p>
                            <hr>
                            <div class="post-content">
                              <?php the_content(); ?>
                          </div>
                       </div>
                    </div>
                </div>
          
                <div class="col-md-4 mb-4">
<div class="sticky">
    <div class="card mb-4">
                     
                           <div class="card-header">Related articles</div>
                            <div class="card-body">
                            <?php
$args = array(
	'post_type' => 'video',
	'posts_per_page' => 5,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post(); ?>
                                <ul class="list-unstyled">
                                <li class="media my-4">
                                    <?php the_post_thumbnail( 'small_thumb', array( 'class'=> 'd-flex mr-3')); ?>
                        
                                        <div class="media-body">
                                            <a href="<?php echo  get_permalink();?>">
                                                <h5 class="mt-0 mb-1 font-weight-bold"><?php the_title(); ?></h5>
                                            </a>
                                        </div>
                                     </li>
                                </ul>
                                <?php
	}
} else {

}

wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</section>
		<?php
}
?>
	</div>
</div>

	   <section class="container text-center">
            <h1 class="h2 font-weight-bold my-4">Recent videos</h1>
            <div class="row wow fadeIn">
            <?php 
$show_video = new Cpt_sort();

?>
         </div>   
		 </section>
		 </div>
		 </div>
	<?php get_footer(); ?>