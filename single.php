<?php/*
Template Name: Post
Template Post Type:post*/
?>
<?php
get_header();
?>

<?php  

if ( have_posts() ) {
    while ( have_posts() ) {
    the_post();
?>

<main>
<div class="container">
        <div class="card-body white-text text-center yel mb-2 mt-2 px-5 pt-5 pb-4">
            <div class="row wow fadeIn d-flex justify-content-center yel pt-5 pb-4">
                <div class="col-md-6">
                    <h1 class="font-weight-bold mb-4"><?php the_title() ?></h1>
                </div>
            </div>
    </div>
</div>
    <div class="container">
        <section class="mt-3">
            <div class="row wow fadeIn">
                <div class="col-md-8 mb-4">
<!-- Breadcrumbs -->
<?php
$categories = get_the_category();
$first_category_name = $categories[0]->cat_name;
$first_category_id = get_cat_ID( $category[0]->cat_name );
$first_category_link = get_category_link( $category_id );
?>
<ol class="breadcrumb white z-depth-1">
    <li class="breadcrumb-item">
        <a href="<?php echo get_home_url(); ?>">Home Page</a>
    </li>
    <?php
    if (count($categories)){
    ?>
    <li class="breadcrumb-item">
        <a href="<?php echo $first_category_link ?>"><?php echo $first_category_name ?></a>
    </li>
    <?php
    }
    ?>
    <li class="breadcrumb-item active"><?php the_title(); ?></li>
</ol>
                    <?php the_post_thumbnail( 'large', array( 'class'=> 'img-fluid z-depth-1-half mb-4')); ?>

                    <div class="card mb-4">
                        <div class="card-body">                 
        <p>by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ),
         get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a> 
         on <?php echo get_the_date(); ?></p>
                            <hr>
                            <div class="post-content">
                              <?php the_content(); ?>
                          </div>
                       </div>
                    </div>
                </div>
              <?php 
} // end while
} // end if
?>           
                <div class="col-md-4 mb-4">
<div class="sticky">
    <div class="card mb-4">
                     
                           <div class="card-header">Related articles</div>
                            <div class="card-body">
                            <?php
$args = array(
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
    </div>
</main>
<?php get_footer(); ?>














