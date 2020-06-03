</section>
   
<!--Footer-->
<footer class="page-footer text-center font-small mt-4 wow fadeIn">
<?php if ( is_active_sidebar( 'footer' ) ) : ?>
    <?php dynamic_sidebar( 'footer' ); ?>
    <?php endif; ?>
   
    </footer>

<?php wp_footer(); ?>

</body>

</html>
