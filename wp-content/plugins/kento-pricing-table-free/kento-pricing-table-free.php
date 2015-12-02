<?php

/*
Plugin Name: Kento Pricing Tables Free
Plugin URI: http://kentothemes.com
Description: Kento Pricing Table Free uses pure HTML and CSS with easy to easy shortcode method. For more features checkout <a href="http://kentothemes.com/items/plugins/kento-pricing-table-pro/" target="_blank"> Kento Pricing Table Pro</a>.
Version: 2.2
Author: kentothemes
Author URI: http://kentothemes.com
License: copyright@kentothemes.com
License URI: http://kentothemes.com/copyright/
*/




/***************************************************/




require_once( plugin_dir_path( __FILE__ ) . 'themes/themes.php');
require_once( plugin_dir_path( __FILE__ ) . 'themes/body.php');

define('WPT_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function wpt_script_pro()
	{
	wp_enqueue_script('jquery');
	wp_enqueue_style('wpt-css-default', WPT_PLUGIN_PATH.'themes/default/style.css');			
	wp_enqueue_style('wpt-css', WPT_PLUGIN_PATH.'css/style.css');
	wp_enqueue_script('wpt_ajax_js', plugins_url( '/js/wpt-ajax.js' , __FILE__ ) , array( 'jquery' ));
	wp_localize_script( 'wpt_ajax_js', 'wpt_ajax', array( 'wpt_ajaxurl' => admin_url( 'admin-ajax.php')));
	
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wpt-wp-color-picker', plugins_url('/js/wpt-ajax.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	
	}

//////////////////////////////////////////////////////


add_action('init', 'wpt_script_pro');
add_action('init', 'wpt_register');
 
function wpt_register() {
 
        $labels = array(
                'name' => _x('KPT Free', 'post type general name'),
                'singular_name' => _x('KPT', 'post type singular name'),              
                'edit_item' => __('Edit KPT'),
                'view_item' => __('View KPT'),
                'search_items' => __('Search KPT'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => WPT_PLUGIN_PATH.'/css/kpt-menu.jpg',
				

          );
 
        register_post_type( 'wpt' , $args );

}


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_wpt()
	{
		$screens = array( 'wpt' );
		foreach ( $screens as $screen )
			{
				add_meta_box('wpt_sectionid',__( 'Pricing Table Options','wpt_textdomain' ),'meta_boxes_wpt_input', $screen);
			}
	}


add_action( 'add_meta_boxes', 'meta_boxes_wpt' );


function meta_boxes_wpt_input( $post ) {

	wp_nonce_field( 'meta_boxes_wpt_input', 'meta_boxes_wpt_input_nonce' );

	$wpt_column_width = get_post_meta( $post->ID, 'wpt_column_width', true );
	$wpt_corner_radius = get_post_meta( $post->ID, 'wpt_corner_radius', true );
	$wpt_corner_gradient = get_post_meta( $post->ID, 'wpt_corner_gradient', true );	
	$wpt_style = get_post_meta( $post->ID, 'wpt_style', true );
	$wpt_column_margin = get_post_meta( $post->ID, 'wpt_column_margin', true );
	$wpt_total_row = get_post_meta( $post->ID, 'wpt_total_row', true );	
	$wpt_total_column = get_post_meta( $post->ID, 'wpt_total_column', true );
	
	
	if(empty($wpt_total_row)){ $wpt_total_row = 6;}
	if(empty($wpt_total_column)){ $wpt_total_column = 3;}	

	$wpt_table_field = get_post_meta( $post->ID, 'wpt_table_field', true );
	$wpt_table_field_header = get_post_meta( $post->ID, 'wpt_table_field_header', true );

	
	
	$wpt_table_field_price = get_post_meta( $post->ID, 'wpt_table_field_price', true );		

	
	$wpt_table_column_signup_text = get_post_meta( $post->ID, 'wpt_table_column_signup_text', true );	
	$wpt_table_column_signup_url = get_post_meta( $post->ID, 'wpt_table_column_signup_url', true );
	
	$wpt_table_column_color = get_post_meta( $post->ID, 'wpt_table_column_color', true );
	$wpt_bg_img = get_post_meta( $post->ID, 'wpt_bg_img', true );
	$wpt_themes = get_post_meta( $post->ID, 'wpt_themes', true );	
	

   ?>

<div class= "scroll">

<table class="form-table">





	<tr valign="top">
		<th scope="row"><label for="wpt-shortcode"><?php echo __('Shortcode'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='30' onClick="this.select();" name='wpt_shortcode' class='wpt-shortcode' id="wpt-shortcode" type='text' value='<?php echo '[wpt id="'.get_the_ID().'"]'; ?>' /><br /><span class="wpt-shortcode-hint"><?php echo __('(Please use this shortcode to display table on your post or page)');?></span>
		</td>
	</tr> 

	<tr valign="top">
		<th scope="row"><?php echo __('Themes'); ?>:</th>
		<td style="vertical-align:middle;">
     	<select name="wpt_themes">
        	<option value="default" <?php if($wpt_themes=='default') echo "selected"; ?>>Default</option>
            <option value="flat" disabled >Kento Theme Flat (Only for Pro) </option>
            <option value="arc" disabled >Kento Theme Arc (Only For Pro) </option>
            <option value="ultra" disabled> Kento Theme Ultra (Only for Pro )</option>
            <option value="light" disabled> Kento Theme Light (Only for Pro )</option>
            <option value="stroke" disabled> Kento Theme Stroke (Only for Pro )</option>
        </select><br />
	<span class="wpt-shortcode-hint"><?php echo __('(To use more Themes please purchase');?> 
<a href="http://kentothemes.com/items/plugins/kento-pricing-table-pro/" target="_blank"> Kento Pricing Table Pro </a> <?php echo __('version.)');?></span>
		</td>
	</tr>
    
	<tr valign="top">
		<th scope="row"><?php echo __('Display Background Image'); ?>:</th>
		<td style="vertical-align:middle;">

					<br /><br />
                    

					<?php wpt_get_bg_img($post->ID); ?>
                     
		</td>
	</tr> 




	<tr valign="top">
		<th scope="row"><label for="wpt-column-width"><?php echo __('Table Column Width'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input size='10' required="required" placeholder="Number Only" name='wpt_column_width' class='wpt-column-width' id="wpt-column-width" type='text' value='<?php echo sanitize_text_field($wpt_column_width) ?>' />px
		</td>
	</tr> 
        
	<tr valign="top">
		<th scope="row"><label for="wpt-corner-radius"><?php echo __('Corner Radius'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input required="required" placeholder="Number Only" size='10' name='wpt_corner_radius' class='wpt-corner-radius' id='wpt-corner-radius' type='text' value='<?php if ( isset( $wpt_corner_radius ) ) echo $wpt_corner_radius; ?>' />px<br />
                     <span class="wpt-shortcode-hint"><?php echo __('Set zero(0) for no corner radius');?> </span>
		</td>
	</tr>  
           
	<tr valign="top">
		<th scope="row"><label for="wpt-corner-gradient"><?php echo __('Top And Bottom Gradient'); ?>: </label></th>
		<td style="vertical-align:middle;">   

<input size='10' name='wpt_corner_gradient' class='wpt-corner-gradient' id='wpt-corner-gradient' type='range' min= "50" max="50" value="50" step="1.00" value='<?php if ( isset( $wpt_corner_gradient ) ) echo $wpt_corner_gradient; ?>' /><span id="wpt-corner-gradient-value"></span> </br>                
  <span class="wpt-shortcode-hint"><?php echo __('(To enable Gradient feature please upgrade to');?> 
<a href="http://kentothemes.com/items/plugins/kento-pricing-table-pro/" target="_blank" > Kento Pricing Table Pro </a> <?php echo __('version.)');?></span>
		</td>
	</tr>   
                
	<tr valign="top">
		<th scope="row"><label for="wpt-style"><?php echo __('Select Style'); ?>: </label></th>
		<td style="vertical-align:middle;">
                     
		<label for="default">
		<input name="wpt_style"   id="default" type="radio" value="style1" <?php if ( $wpt_style=="style1" ) echo "checked"; ?> /><?php echo __('Display Blank Field'); ?></label> <br />
		<label for="default-top">
		<input name="wpt_style"   id="default-top" type="radio" value="style2" <?php if ( $wpt_style=="style2" ) echo "checked"; ?> /><?php echo __('Hide Blank Field'); ?></label><span style="display:none" id="default-top-image" class="image-data" data='<?php echo plugins_url( '/demo/default-top.png', __FILE__) ?>'>default-style.png </span>  <br />
     
		</td>
	</tr>                

	<tr valign="top">
		<th scope="row"><label for="wpt-column-margin"><?php echo __('Table Column Margin'); ?>: </label></th>
		<td style="vertical-align:middle;">                     
                     <input required="required" placeholder="Number Only" size='10' name='wpt_column_margin' class='wpt-column-margin' id="wpt-column-margin" type='text' value='<?php echo sanitize_text_field($wpt_column_margin) ?>' />px<br />
                     <span class="wpt-shortcode-hint"><?php echo __('Set zero(0) for no column margin');?> </span>
		</td>
	</tr> 
              
	<tr valign="top">
		<th scope="row"><label for="wpt-total-row"><?php echo __('How Many Rows'); ?>: </label></th>
		<td style="vertical-align:middle;">
        <input required="required" size="3" name="wpt_total_row" id="wpt-total-row" class="wpt-total-row" type="text" value="<?php if ( !empty( $wpt_total_row ) ) echo $wpt_total_row; else echo 4; ?>" /> <br />
        <span class="wpt-shortcode-hint"><?php echo __('**Click Outside box to update table below.');?></span>

		</td>
	</tr>
    
	<tr valign="top">
		<th scope="row"><label for="wpt-total-column"><?php echo __('How Many Column'); ?>: </label></th>
		<td style="vertical-align:middle;">
        <input required="required" size="3" name="wpt_total_column" id="wpt-total-column" type="text" value="<?php if ( !empty( $wpt_total_column ) ) echo $wpt_total_column; else echo 4; ?>" />
        <input size="3" type="hidden" name="wpt_postid" id="wpt-postid"  value="<?php echo get_the_ID(); ?>" /><br />
		<span class="wpt-shortcode-hint"><?php echo __('**Click Outside box to update table below.');?></span>
		</td>
	</tr>
    
<script>
	jQuery(document).ready(function(jQuery)
		{	
		jQuery(".wrap").click(function()
			{
			jQuery('.wpt-table-column-color').wpColorPicker();
			});
		});
</script>
    
    <tr valign="top">
		<th scope="row">Table Data:
		</th>
		<td style="vertical-align:middle;">
        <div id="wpt-total-data">
        
<?php


echo "<table class='price-table-admin' id='price-table-admin' >";
for($j=1; $j<=$wpt_total_row; $j++)
  {
	  if(($j==1) )
	  	{
  			echo "<tr class='nodrag nodrop'>";			
		}
	  elseif(($j==2) )
	  	{
  			echo "<tr class='nodrag nodrop'>";			
		}
	  elseif(($j==$wpt_total_row) )
	  	{
  			echo "<tr class='nodrag nodrop'>";			
		}		
	  else
	  	{
			echo "<tr>";
		}

  
		for($i=1; $i<=$wpt_total_column; $i++)
			{	
			if(empty($wpt_table_field[$i.$j]))
				{
					$wpt_table_field[$i.$j] ="";
				}
				if($j==1)
					{
					echo "<td>";
		 
						 
                        if(empty($wpt_table_column_color[$i]))
							{
								$wpt_table_column_color[$i] ="";
							}
							
                        if(empty($wpt_featured_column))
							{
								$wpt_featured_column ="";
							}							
							

						 ?>
                    
                    
                    
                    	 <input size='10' name='wpt_table_column_color[<?php echo $i; ?>]' class='wpt-table-column-color' id="wpt-table-column-color" type='text' value='<?php echo $wpt_table_column_color[$i]; ?>' /><br />
                         
                         
                         <br />
					
                    
                    <?php
			
                                                                       

				if(empty($wpt_table_field_header[$i]))
								{
									$wpt_table_field_header[$i] ="";
								}
					
					
					echo "<br /><br />";
					echo "<input size='10' placeholder='Column Header: Starter, Basic, Premimum, etc...' name='wpt_table_field_header[".$i."]' class='wpt-table-field-header-".$i."'' type='text' value='".$wpt_table_field_header[$i]."' />";
					
					
					echo "</td>";
					}
					
				elseif($j==2)
					{
						
							if(empty($wpt_table_field_price[$i]))
								{
									$wpt_table_field_price[$i] ="";
								}						
						
						
						
					echo "<td>";
					echo "<input size='12' placeholder='Column Price: $20<span>Per Year</span>' name='wpt_table_field_price[".$i."]' class='wpt-table-field-price-".$i."' type='text' value='".$wpt_table_field_price[$i]."'/>";
					echo "</td>";
					
					}
				elseif($j==$wpt_total_row)
					{
					echo "<td>";

					 if(empty($wpt_table_column_signup_text[$i]))
									{
										$wpt_table_column_signup_text[$i] ="";
									}
					
					echo "<input size='12' placeholder='Sign Up Text - Ex: Join Us' name='wpt_table_column_signup_text[".$i."]' class='wpt-table-column-signup-text-".$i."' type='text' value='".$wpt_table_column_signup_text[$i]."'/>";
					
					
					 if(empty($wpt_table_column_signup_url[$i]))
									{
										$wpt_table_column_signup_url[$i] ="";
									}
					
					
					
					echo "<input size='12' placeholder='Sign Up URL - Ex: http://expamle.com/subscriptions-url' name='wpt_table_column_signup_url[".$i."]' class='wpt-table-column-signup-url_".$i."' type='text' value='".$wpt_table_column_signup_url[$i]."'/>";
					
					echo "</td>";
					
					}
				
				else
					{
						
					echo "<td>";
					echo "<input size='12' name='wpt_table_field[".$i.$j."]' class='wpt-table-field-".$i.$j."' type='text' value='".$wpt_table_field[$i.$j]."'/>";
					echo "</td>";
					}
		
		
				
				
				
			}
  echo "</tr>";
  }


	echo "</table>";

?>

		</div>  
		</td>
	</tr>
</table>

</div>



<div class='wpt-preview-button button button-primary' ><?php echo __('Preview WPT');?></div><br />
<span class="wpt-shortcode-hint"><?php echo __('Please Publish Or Update first.');?></span>
<script>
jQuery(document).ready(function(jQuery)
	{
		jQuery(".wpt-preview-button").click(function()
			{	
				jQuery(".wpt-preview").css("display","block");
			
			});
		
	});
</script>



<?php

	echo "<div class='wpt-preview' ><h2>Demo Preview</h2>";

	echo do_shortcode('[wpt id="'.get_the_ID().'"]');
	echo "</div>";
	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_wpt_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_wpt_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_wpt_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_wpt_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.

	$wpt_column_width = sanitize_text_field( $_POST['wpt_column_width'] );	
	$wpt_corner_radius = sanitize_text_field( $_POST['wpt_corner_radius'] );
	$wpt_corner_gradient = sanitize_text_field( $_POST['wpt_corner_gradient'] );
	
	
	if(empty($_POST['wpt_style']))
		{
			$wpt_style ="style1";
		}
	else
		{
	$wpt_style = sanitize_text_field( $_POST['wpt_style'] );
		}
	$wpt_column_margin = sanitize_text_field( $_POST['wpt_column_margin'] );	
	$wpt_total_row = sanitize_text_field( $_POST['wpt_total_row'] );	
	$wpt_total_column = sanitize_text_field( $_POST['wpt_total_column'] );	
	$wpt_table_field = stripslashes_deep( $_POST['wpt_table_field'] );
	$wpt_table_field_header = stripslashes_deep( $_POST['wpt_table_field_header'] );

	
	
	$wpt_table_field_price = stripslashes_deep( $_POST['wpt_table_field_price'] );
	
	$wpt_table_column_color = stripslashes_deep( $_POST['wpt_table_column_color'] );	
	
	
	$wpt_table_column_signup_text = stripslashes_deep( $_POST['wpt_table_column_signup_text'] );	
	$wpt_table_column_signup_url = stripslashes_deep( $_POST['wpt_table_column_signup_url'] );
	$wpt_themes = $_POST['wpt_themes'];	
	
	
	$wpt_featured_column =  $_POST['wpt_featured_column'];
	
	
	if(empty($_POST['wpt_bg_img']))
		{
			$wpt_bg_img ="";
		}
	else
		{
	$wpt_bg_img = sanitize_text_field( $_POST['wpt_bg_img'] );		
		}
  // Update the meta field in the database.

	update_post_meta( $post_id, 'wpt_column_width', $wpt_column_width );
 	update_post_meta( $post_id, 'wpt_corner_radius', $wpt_corner_radius );
 	update_post_meta( $post_id, 'wpt_corner_gradient', $wpt_corner_gradient );	
	update_post_meta( $post_id, 'wpt_style', $wpt_style );
	update_post_meta( $post_id, 'wpt_column_margin', $wpt_column_margin );
 	update_post_meta( $post_id, 'wpt_total_row', $wpt_total_row );
	update_post_meta( $post_id, 'wpt_total_column', $wpt_total_column );	
	update_post_meta( $post_id, 'wpt_table_field', $wpt_table_field );
	update_post_meta( $post_id, 'wpt_table_field_header', $wpt_table_field_header );
	
	
	
	update_post_meta( $post_id, 'wpt_table_field_price', $wpt_table_field_price );
		
 	update_post_meta( $post_id, 'wpt_table_column_color', $wpt_table_column_color );
 	
	update_post_meta( $post_id, 'wpt_table_column_signup_text', $wpt_table_column_signup_text );		
	update_post_meta( $post_id, 'wpt_table_column_signup_url', $wpt_table_column_signup_url );	
	update_post_meta( $post_id, 'wpt_bg_img', $wpt_bg_img );	
 	update_post_meta( $post_id, 'wpt_themes', $wpt_themes );	
 	update_post_meta( $post_id, 'wpt_featured_column', $wpt_featured_column );	
  
}
add_action( 'save_post', 'meta_boxes_wpt_save' );



function wpt_ajax_form()
	{

		$wpt_total_row = $_POST['wpt_total_row'];
		$wpt_total_column = $_POST['wpt_total_column'];
		$wpt_postid = $_POST['wpt_postid'];

		$wpt_table_field = get_post_meta( $wpt_postid, 'wpt_table_field', true );
		$wpt_table_field_header = get_post_meta( $wpt_postid, 'wpt_table_field_header', true );
	
		
		$wpt_table_field_price = get_post_meta( $wpt_postid, 'wpt_table_field_price', true );
		
		
		$wpt_table_column_signup_text = get_post_meta( $wpt_postid, 'wpt_table_column_signup_text', true );		
		$wpt_table_column_signup_url = get_post_meta( $wpt_postid, 'wpt_table_column_signup_url', true );	
		
		$wpt_table_column_color = get_post_meta( $wpt_postid, 'wpt_table_column_color', true );
		$wpt_featured_column = get_post_meta( $wpt_postid, 'wpt_featured_column', true );		
			
echo "<table class='price-table-admin' >";
for($j=1; $j<=$wpt_total_row; $j++)
  {
  echo "<tr>";
  
		for($i=1; $i<=$wpt_total_column; $i++)
			{	
			
			if(empty($wpt_table_field[$i.$j]))
				{
					$wpt_table_field[$i.$j] ="";
				}
		
				if($j==1)
					{
					echo "<td>";
					
					?>
                    	<?php
                        if(empty($wpt_table_column_color[$i]))
							{
								$wpt_table_column_color[$i] ="";
							}

						?>

                    	 <input size='10' name='wpt_table_column_color[<?php echo $i; ?>]' class='wpt-table-column-color' id="wpt-table-column-color" type='text' value='<?php echo $wpt_table_column_color[$i]; ?>' /><br />
                         
                         
                         
                    <?php
                        if(empty($wpt_table_field_header[$i]))
							{
								$wpt_table_field_header[$i] ="";
							}
					
					
					
					echo "<input size='10' placeholder='Column Header: Starter, Basic, Premimum, etc...' name='wpt_table_field_header[".$i."]' class='wpt-table-field-header-".$i."' type='text' value='".$wpt_table_field_header[$i]."' />";
					echo "</td>";
					}
					


				elseif($j==2)
					{
						
                        if(empty($wpt_table_field_price[$i]))
							{
								$wpt_table_field_price[$i] ="";
							}		
						
					echo "<td>";
					echo "<input size='10' placeholder='Column Price: $20<span>Per Year</span>' name='wpt_table_field_price[".$i."]' class='wpt-table-field-price-".$i."' type='text' value='".$wpt_table_field_price[$i]."' />";
					echo "</td>";
					
					}
				elseif($j==$wpt_total_row)
					{
					echo "<td>";
					
					 if(empty($wpt_table_column_signup_text[$i]))
									{
										$wpt_table_column_signup_text[$i] ="";
									}
					
					
					
					 if(empty($wpt_table_column_signup_url[$i]))
									{
										$wpt_table_column_signup_url[$i] ="";
									}
					
					
					
					echo "<input size='12' placeholder='Sign Up URL - Ex: http://expamle.com/subscriptions-url' name='wpt_table_column_signup_url[".$i."]' class='wpt-table-column-signup-url_".$i."' type='text' value='".$wpt_table_column_signup_url[$i]."'/>";
					
					echo "</td>";
					
					}
					
				else
					{
					echo "<td>";
					
                        if(empty($wpt_table_field[$i.$j]))
							{
								$wpt_table_field[$i.$j] ="";
							}
					
					echo "<input size='10' name='wpt_table_field[".$i.$j."]' class='wpt-table-field-".$i.$j."'' type='text' value='".$wpt_table_field[$i.$j]."' />";
					
					echo "</td>";
					}
				
				
				
				
			}
  echo "</tr>";
  }


	echo "</table>";


		die();
	}



add_action('wp_ajax_wpt_ajax_form', 'wpt_ajax_form');
add_action('wp_ajax_nopriv_wpt_ajax_form', 'wpt_ajax_form');






function wpt_display($atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",

				), $atts);


			$postid = $atts['id'];



$cont ="";
$cont.= wpt_price_table_style($postid);
$cont.= wpt_price_table_body($postid);
return $cont;



}

add_shortcode('wpt', 'wpt_display');










function wpt_style_dark_color($wpt_table_column_color)
	{
		$input = $wpt_table_column_color;
	  
		$col = Array(
			hexdec(substr($input,1,2)),
			hexdec(substr($input,3,2)),
			hexdec(substr($input,5,2))
		);
		$darker = Array(
			$col[0]/2,
			$col[1]/2,
			$col[2]/2
		);

		return "#".sprintf("%02X%02X%02X", $darker[0], $darker[1], $darker[2]);
		
		
	}











function wpt_get_bg_img($postid)
	{
	$dir_path = plugin_dir_path( __FILE__ );
	
	$url = plugins_url("kento-pricing-table-free/");
	$filenames=glob($dir_path."css/bg/*.jpg*");
	
	$wpt_bg_img = get_post_meta( $postid, 'wpt_bg_img', true );
	
	if(empty($wpt_bg_img))
		{
		$wpt_bg_img = "";
		}

	$count=count($filenames);
	$i=0;

	echo "<ul class='wpt-bg-ul'>";

	while($i<$count)
		{
		  
			
			$filelink= str_replace($dir_path,$url,$filenames[$i]);
			
			if($wpt_bg_img==$filelink)
				{
					echo "<li class='bg-selected' data-url='".$filelink."'>";
				}
			else
				{
					echo "<li data-url='".$filelink."'>";
				}
			
			
			echo "<img  width='70px' height='50px' src='".$filelink."' />";
			echo "</li>";
			$i++;
		}
		
	echo "</ul>";
echo "<input size='80' value='".$wpt_bg_img."'  onClick='this.select();'  placeholder='Please select image or left blank' id='wpt_bg_img' name='wpt_bg_img'  type='text' />";

	}
	
	


////////////////////////////////////////////////////////////



add_action('admin_menu', 'wpt_menu_init');


	
function wpt_settings(){
	include('kpt-admin.php');	
}

function wpt_menu_init() {

	
	add_submenu_page('edit.php?post_type=wpt', __('Update to Pro','menu-wpt'), __('Update to Pro','menu-wpt'), 'manage_options', 'wpt_settings', 'wpt_settings');
}

?>