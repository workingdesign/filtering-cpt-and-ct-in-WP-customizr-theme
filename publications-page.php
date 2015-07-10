<?php
/*
Template Name: Publications Page
*/
?>

<!-- /********************************************************/ 
/* 03/2015
    solution from Rocco for customizr 1.0.15
    that does not show posts listed in custom pages
    https://gist.github.com/eri-trabiccolo/14ade3c986e9f3086843#file-custom_post_lists_comp-php
    and on the customizr forum
    http://themesandco.com/support-forums/topic/custom-post-list-templates-not-working-with-recent-update-customizr-v3-3-6/
    
/********************************************************/ -->

<?php
// strangely you have to set this to false, typo in the core code.
// useful just when you display the page which uses this template in home as static page
// consider that the navigation will not work properly (and not because of customizr :P)
add_filter('tc_display_customizr_headings', '__return_false');
add_filter('tc_post_list_controller', '__return_true');
// use this to display the page title
// add_action('__before_loop', 'print_page_title', 0);
function print_page_title(){
        ?>
            <header class="entry-header">
                <h1 class="entry-title "><?php echo get_the_title(); ?></h1>
                <hr class="featurette-divider __before_content">
            </header>
        <?php
    }
?>

<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>

<div id="main-wrapper" class="<?php echo implode(' ', apply_filters( 'tc_main_wrapper_classes' , array('container') ) ) ?>">

    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>

    <div class="container" role="main">

        <div class="<?php echo implode(' ', apply_filters( 'tc_column_content_wrapper_classes' , array('row' ,'column-content-wrapper') ) ) ?> publications-list">

<?php //echo "test-publications-page"; ?>        

            <?php do_action( '__before_article_container'); ##hook of left sidebar?>

                <div id="content" class="<?php echo implode(' ', apply_filters( 'tc_article_container_class' , array( TC_utils::tc_get_layout( TC_utils::tc_id() , 'class' ) , 'article-container' ) ) ) ?>">

                    <?php do_action ('__before_loop'); ##hooks the heading of the list of post : archive, search... ?>

                        <!-- custom loop 1 -->
                        <?php 
                            add_filter('tc_show_post_metas', '__return_true');
                            global $wp_query, $wp_the_query;

                            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                            $wp_query = new WP_Query( array(
                                'paged'             => get_query_var('paged') ? get_query_var('paged') : 1,
                                'post_type'         => 'publication',
                                'publication-types' => $term->taxonomy,
                                'reports'           => $term->slug,
                                'post_status'       => 'publish',
                                'posts_per_page'    => 2,   //show n posts
                                //'cat'               => 77, //include this category from the posts list
                                //'tag_id'            => '77',
                                //'tag'               => 'reports',
                                //'page_name'         => 'publication-s',
                                //'taxonomy'          => 'publication-types',
                                //'category_name'     => 'reports',
                                //'page_name'         => 'publication-types/reports',
                                //others parameters here: http://codex.wordpress.org/Class_Reference/WP_Query#Parameters
                            ) );
                        ?>

                        <?php if ( tc__f('__is_no_results') || is_404() ) : ##no search results or 404 cases ?>

                            <article <?php tc__f('__article_selectors') ?>>
                                <?php do_action( '__loop' ); ?>
                            </article>

                        <?php endif; ?>

                        <?php if ( have_posts() && ! is_404() ) : ?>
                            <?php while ( have_posts() ) : ##all other cases for single and lists: post, custom post type, page, archives, search, 404 ?>
                                <?php the_post(); ?>

                                <?php do_action ('__before_article') ?>
                                    <article <?php tc__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>

                            <?php endwhile; ?>

                        <?php endif; ##end if have posts ?>

                    <?php //do_action ('__after_loop'); ##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                    <!-- reset the main query -->
                    <?php $wp_query = $wp_the_query; ?>


                    <hr>


                    <?php do_action ('__before_loop'); ##hooks the heading of the list of post : archive, search... ?>

                        <!-- custom loop 2 -->
                        <?php 
                            add_filter('tc_show_post_metas', '__return_true');
                            global $wp_query, $wp_the_query;

                            $wp_query = new WP_Query( array(
                                'paged'             => get_query_var('paged') ? get_query_var('paged') : 1,
                                'post_type'         => 'publication',
                                'post_status'       => 'publish',
                                'posts_per_page'    => 2,   //show n posts
                                'cat'               => -77, //include this category from the posts list
                                //'page_name'       => 'publication-s',
                                //'taxonomy'        => 'publication-types/reports',
                                //others parameters here: http://codex.wordpress.org/Class_Reference/WP_Query#Parameters
                            ) );
                        ?>

                        <?php if ( tc__f('__is_no_results') || is_404() ) : ##no search results or 404 cases ?>

                            <article <?php tc__f('__article_selectors') ?>>
                                <?php do_action( '__loop' ); ?>
                            </article>

                        <?php endif; ?>

                        <?php if ( have_posts() && ! is_404() ) : ?>
                            <?php while ( have_posts() ) : ##all other cases for single and lists: post, custom post type, page, archives, search, 404 ?>
                                <?php the_post(); ?>

                                <?php do_action ('__before_article') ?>
                                    <article <?php tc__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>

                            <?php endwhile; ?>

                        <?php endif; ##end if have posts ?>

                    <?php //do_action ('__after_loop'); ##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                    <!-- reset the main query -->
                    <?php $wp_query = $wp_the_query; ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of right sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!--#main-wrapper"-->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>