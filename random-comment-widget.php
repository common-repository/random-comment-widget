<?php
/*
Plugin Name: Random Comment Widget
Plugin URI: h404.pl
Description: Random Comment Widget displays random comment from selected page or post on your website. Great solution for testimonial.
Author: H404
Version: 1
Author URI: h404.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



class random_comment_widget extends WP_Widget {
	function random_comment_widget() {
		$widget_ops = array( 'classname' => 'rcw', 'description' => __('Display random comment or testimonial on your website.', 'rcw') );		
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'rcw-widget' );		
		$this->WP_Widget( 'rcw-widget', __('Random Comment Widget', 'rcw'), $widget_ops, $control_ops );
	}
	
function widget( $args, $instance ) {
	extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$pid    = $instance['pid'];
		
	echo $before_widget;		
		if ( $title )
			echo $before_title . $title . $after_title;
			
$comments = get_comments("post_id=$pid&status=approve");
	if ($comments) {
     $rc = mt_rand(1,sizeof($comments)) - 1;
     $comment = $comments[$rc];
   }	 
echo '<p>' .$comment->comment_content. '</p>'; 
echo '<div class="rcwauthor" style="display:block; font-weight:bold; text-align:right; font-style:italic; ">' .$comment->comment_author. '</div>'; 
echo $after_widget;		
	}
	 
function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['pid'] = strip_tags($new_instance['pid']);		
		return $instance;
	}	
	
function form( $instance ) {
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'rcw-widget'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'pid' ); ?>"><?php _e('Page / Post ID:', 'rcw-widget'); ?></label>
		<input id="<?php echo $this->get_field_id( 'pid' ); ?>" name="<?php echo $this->get_field_name( 'pid' ); ?>" value="<?php echo $instance['pid']; ?>" style="width:100%;" />
	</p>
	
	<p style="text-align:center;">
<a href="http://h404.pl/donate.html" target="_blank"><img src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" border="0" /></a>
	</p>
	
	<?php
	}
}

add_action('widgets_init', 'register_random_comment_widget');
function register_random_comment_widget() {
    register_widget('random_comment_widget');
}