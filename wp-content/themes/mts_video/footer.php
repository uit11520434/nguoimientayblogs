<?php
/**
 * The template for displaying the footer.
 */
$mts_options = get_option(MTS_THEME_NAME); ?>
	</div><!--#page-->
	<footer id="site-footer" class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
        <?php if ($mts_options['mts_bottom_footer']) : ?>
            <div class="footer-widgets bottom-footer-widgets widgets-num-3">
                <div class="container">
                    <div class="f-widget f-widget-1">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-bottom') ) : ?><?php endif; ?>
                    </div>
                    <div class="f-widget f-widget-2">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-bottom-2') ) : ?><?php endif; ?>
                    </div>
                    <div class="f-widget f-widget-3 last">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-bottom-3') ) : ?><?php endif; ?>
                    </div>
                </div>
            </div><!--.bottom-footer-widgets-->
        <?php endif; ?>
        <div class="container">
            <div class="copyrights">
                <?php mts_copyrights_credit(); ?>
            </div>
        </div><!--.container-->
	</footer><!--#site-footer-->
</div><!--.main-container-->
<?php mts_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>