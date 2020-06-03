<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <title>Yellow</title>
    <meta name="description" content="description">
    <meta name="keywords" content="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="<?php bloginfo("template_directory"); ?>/style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
   
<?php wp_head(); ?>
</head>
<body>



    <header class="container">  
    <nav class="navbar navbar-expand-md navbar-light bg-faded">
   <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
     <span class="navbar-toggler-icon"></span>
   </button>
   <a class="navbar-brand pt-0 waves-effect" href="">
            <img src="<?php echo get_theme_mod( 'sample_default_image' ); ?>" alt="logo">
        </a>
   <?php
   wp_nav_menu(array(
     'menu'            => 'primary',
     'theme_location'  => 'primary',
     'container'       => 'div',
     'container_id'    => 'bs4navbar',
     'container_class' => 'collapse navbar-collapse',
     'menu_id'         => false,
     'menu_class'      => 'navbar-nav mr-auto',
     'depth'           => 2,
     'fallback_cb'     => 'bs4navwalker::fallback',
     'walker'          => new wp_bootstrap_navwalker()
   ));
   ?>
     <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a href="#" class="nav-link waves-effect" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link waves-effect" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li class="nav-item">
                <a href="" class="nav-link waves-effect" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
                <li class="nav-item">
                <a href="" class="nav-link waves-effect" target="_blank">
                        <i class="fab fa-google"></i>
                    </a>
                </li>
            </ul>
</nav>
    </header>