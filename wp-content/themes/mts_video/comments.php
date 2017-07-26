<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','video'); ?></p>
<?php
return;
}
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<!-- You can start editing here. -->

<?php if ('open' == $post->comment_status) : ?>
<div id="comments" class="clearfix">
	<div class="cd-tabs">
		<nav>
			<?php if (!empty($mts_options['mts_comments']['enabled'])) { ?>
			<ul class="cd-tabs-navigation">
				<?php $i = 0; foreach ($mts_options['mts_comments']['enabled'] as $key => $value) { $i++;
					$class = '';
					if ($i == 1) {
						$class = ' class="selected"';
						$selected = $key;
					}
					switch ($key) {
						case 'comments': ?>
							<li><a data-content="comments"<?php echo $class; ?> href="#0"><?php comments_number(__('No comments yet','video'), __('One Response','video'),  __('% Comments','video') );?></a></li>
						<?php 
						break;

						case 'fb_comments': ?>
							<li><a data-content="fbcomments"<?php echo $class; ?> href="#0"><?php _e( 'Facebook Comments','video'); ?></a></li>
						<?php 
						break;
					}
				} ?>				
			</ul> <!-- cd-tabs-navigation -->
			<?php } ?>
		</nav>

		<ul class="cd-tabs-content">
			<?php if (!empty($mts_options['mts_comments']['enabled']['comments'])) { ?>
			<li data-content="comments" <?php echo $selected == 'comments' ? 'class="selected"' : ''; ?>>
				<?php if ( have_comments() ) : ?>
					<ol class="commentlist clearfix">
						<div class="navigation">
							<div class="alignleft"><?php previous_comments_link() ?></div>
							<div class="alignright"><?php next_comments_link() ?></div>
						</div>
						<?php wp_list_comments('type=comment&callback=mts_comments'); ?>
						<div class="navigation">
							<div class="alignleft"><?php previous_comments_link() ?></div>
							<div class="alignright"><?php next_comments_link() ?></div>
						</div>
					</ol>
				<?php else : // this is displayed if there are no comments so far ?>
					<?php if ('open' == $post->comment_status) : ?>
					<?php else : // comments are closed ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ('open' == $post->comment_status) : ?>
					<div id="commentsAdd" class="clearfix">
						<div id="respond" class="box m-t-6">
							<?php global $aria_req; $comments_args = array(
								'title_reply'=>'',
								'comment_notes_before' => '',
								'comment_notes_after' => '',
								'label_submit' => __('Post Comment','video'),
								'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.__('Comment Text*','video').'"></textarea></p>',
								'fields' => apply_filters( 'comment_form_default_fields',
									array(
										'author' => '<p class="comment-form-author">'
										.( $req ? '' : '' ).'<input id="author" name="author" type="text" placeholder="'.__('Name*','video').'" value="'.esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
										'email' => '<p class="comment-form-email">'
										.($req ? '' : '' ) . '<input id="email" name="email" type="text" placeholder="'.__('Email*','video').'" value="' . esc_attr(  $commenter['comment_author_email'] ).'" size="30"'.$aria_req.' /></p>',
										'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" placeholder="'.__('Website','video').'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
									) 
								)
							); 
							comment_form($comments_args); ?>
						</div>
					</div><!--.commentsAdd-->
				<?php endif; // if you delete this the sky will fall on your head ?>
			</li>
			<?php } ?>

			<?php if (!empty($mts_options['mts_comments']['enabled']['fb_comments'])) { ?>
			<li data-content="fbcomments" <?php echo $selected == 'fb_comments' ? 'class="selected"' : ''; ?>>
				<?php if ( post_password_required() ) : ?>
			    	    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
			        </div>
			        <?php return; ?>
			    <?php endif; ?>
			 
			    <?php if ( comments_open() ) : ?>
			        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
			    <?php endif; ?>

			    <?php if ( ! comments_open() ) : ?>
					<p class="nocomments"></p>
			    <?php endif; ?>
			</li>
			<?php } ?>
		</ul> <!-- cd-tabs-content -->
	</div> <!-- cd-tabs -->
</div> <!-- cd-tabs -->
<?php endif; ?>