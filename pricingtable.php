<?php
/*---------------------------------------------------------
Plugin Name: Easy Pricing Table

Plugin URI: https://wordpress.org/plugins/easy-pricing-table-manager/

Description: Easy Pricing Table plugin allow you to create Beautiful Pricing table or Comparison Table with smooth hover effects in just a few minutes. You can Embed in any post/page using shortcode <code>[easy-pricing-table table_name="Pricing Table Name"]</code> or you can add through widgets.

Version: 1.2.0

Author: JW Themes

Author URI: http://jwthemes.com

-----------------------------------------------------------*/

//activation hook for creating database
register_activation_hook(__FILE__,'activate_easy_pricing_table');
function activate_easy_pricing_table(){
	update_option( 'unistall_easy_pricing_table', true );
	global $wpdb;
	$table_name=$wpdb->prefix. "pricing_table";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 
		
		$sql="CREATE TABLE $table_name(
		id int NOT NULL AUTO_INCREMENT,
		pricing_table varchar(50),
		back_color varchar(40),
		theme_color varchar(20),
		title_back varchar(20),
		list_no int,
		pricing_table_desc varchar(300),
		primary key id (id)
		);";
		
	}
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 dbDelta( $sql );
	 
	 global $wpdb;
	 $table_name=$wpdb->prefix. "pricing_detail";
	 if($wpdb->get_var("show tables like '$table_name'") != $table_name){ 
	 
	 	$sql1="CREATE TABLE $table_name(
		pid int NOT NULL AUTO_INCREMENT,
		title varchar(50),
		price varchar(80),
		column_color varchar(30),
		time_duration varchar(170),
		buy_txt varchar(170),
		pricing_features varchar(300),
		set_priority int,
		pricing_t_id int,
		primary key pid (pid)
		);";
	 }
	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 dbDelta($sql1);
	
}

register_deactivation_hook(__FILE__, 'easy_pricing_table_deactivation' );

function easy_pricing_table_deactivation(){
	global $wpdb;
	$pricing_table_drop = $wpdb->prefix."pricing_table";
	$pricing_detail_drop = $wpdb->prefix."pricing_detail";
	 $sql= "DROP TABLE IF EXISTS ".$pricing_table_drop ;
	 $sql1= "DROP TABLE IF EXISTS ".$pricing_detail_drop ;
	
	 $wpdb->query($sql);
	 $wpdb->query($sql1);
}


//add menu
add_action('admin_menu','easy_pricing_table_add_menu');

function easy_pricing_table_add_menu(){
	add_menu_page('Pricing Table',
	'Pricing Table',
	'manage_options',
	'easy_pricing_table',
	'easy_pricing_table',
	plugin_dir_url( __FILE__ ) . 'img/easy_pricing_table.png'
	);
	
	add_submenu_page('easy_pricing_table',
	'Add Pricing Table',
	'Add Pricing Table',
	'manage_options',
	'add_pricing_table',
	'add_pricing_table'
	);
	
	add_submenu_page('NULL',
	'Manage Pricing',
	'Manage Pricing',
	'manage_options',
	'manage_pricing',
	'manage_pricing'
	);
	
	add_submenu_page('NULL',
	'View Detail',
	'View Detail',
	'manage_options',
	'view_pricing_detail',
	'view_pricing_detail'
	);
	
	add_submenu_page('NULL',
	'Remove Pricing list',
	'Remove Pricing List',
	'manage_options',
	'request',
	'request'
	);
	add_submenu_page('NULL',
	'edit the detail',
	'edit the detail',
	'manage_options',
	'easy_pricing_edit',
	'easy_pricing_edit'
	
	);
	add_submenu_page('NULL',
	'edit the table detail',
	'edit the table detail',
	'manage_options',
	'edit_easy_pricing_table',
	'edit_easy_pricing_table'
	
	);
}
//shortcode for easy-pricing-table
add_shortcode('easy-pricing-table','pricing_function');

function pricing_function($atts){
	ob_start();?>
        <section class="pricing_table_wrap"	>                
		<?php 
            global $wpdb;
            $rows = $wpdb->get_results($wpdb->prepare("SELECT * from  ".$wpdb->prefix."pricing_table where pricing_table = %s", $atts['table_name']));
            foreach($rows as $row){?>	
            <style>
                .pricing_table_wrap{background:<?php echo $row->back_color;?>!important;}
            </style>  
                    
            <h1><?php echo esc_html(stripcslashes($row->pricing_table));?></h1> 
            <p><?php echo esc_html(stripcslashes($row->pricing_table_desc));?></p>
        <?php }?>
        
        <?php 
            global $wpdb;
            $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."pricing_detail INNER JOIN ".$wpdb->prefix."pricing_table where ".$wpdb->prefix."pricing_detail.pricing_t_id = "."".$wpdb->prefix."pricing_table.id"." AND ".$wpdb->prefix."pricing_table.pricing_table='".$atts['table_name']."' ORDER BY set_priority ASC limit ".$row->list_no);
            foreach($rows as $row){$buy_txt=unserialize($row->buy_txt); $tme_duration = unserialize($row->time_duration);?>
            <style>
            
            .pricing_table_wrap li a:hover{ background:<?php echo $row->theme_color;?> !important; text-decoration:none}
            .jw_easy_pricing_tbl_col2{width:46% !important; }
            .jw_easy_pricing_tbl_col3{width:30% !important; }
            
            
            </style>
            
                <?php if($row->list_no=="2"){            
                	echo "<div class='jw_easy_pricing_tbl_col jw_easy_pricing_tbl_col2'>";}
                	else if($row->list_no=="3"){ echo "<div class='jw_easy_pricing_tbl_col jw_easy_pricing_tbl_col3'>";}
                	else if ($row->list_no=="4"){echo "<div class='jw_easy_pricing_tbl_col'>";}?>
                    <div class="pricing_table">
                        <h3 style="background:<?php echo esc_attr($row->title_back); ?> !important;"><?php echo esc_html(stripcslashes( $row->title));?>
                        </h3>
                        <ul>
                        	<?php if(isset($tme_duration['time_durt']) AND $tme_duration['sh_t']=='s_t'){?>
                            
                            <li style="background:<?php echo esc_attr($row->column_color);?>;"><span class="rounded"><?php echo esc_html($row->price);?>
                            <span><span>/<?php if($tme_duration['time_durt']=='2'){echo "hr";}
                            else if($tme_duration['time_durt']=='3'){ echo "wk";} else if($tme_duration['time_durt']=='4'){ echo "mo";}
                            else if($tme_duration['time_durt']=='5') {echo "yr";}else if($tme_duration['time_durt']=='6') {echo "ot";} else{ echo "pm";}?>
                            </span></span></li>
                            <?php } else {?>
                           <li style="background:<?php echo esc_attr($row->column_color);?>;"><span class="rounded"><?php echo esc_html($row->price);?></span>
                           </li>
                            <?php }?>
                            <?php 
                            $wordChunks = explode(';',$row->pricing_features);//separate  the features 
                            for($i = 0; $i < count($wordChunks); $i++){
                            echo "<li>". stripcslashes($wordChunks[$i])."</li>";
                            }?>
                            <li style="background:<?php echo $row->column_color;?>;"><a href="<?php if(!empty($buy_txt['url'])){ echo esc_url($buy_txt['url']);} else { echo "#";}?>"><?php if(!empty($buy_txt['txt'])){ echo esc_attr($buy_txt['txt']);} else { echo "Buy Now";}?></a></li>
                        </ul>
                    </div>
                    
                </div>            
            
         <?php }?>          
        <div style="clear:both"></div>
    </section>
    
<?php
return ob_get_clean();
}
class easy_pricing_table_widget extends WP_Widget{

	function __construct(){//function will call the description of the widget and it's name

		$params=array(

			'description'=>'Easy Pricing Table Widget Helps to show the pricing detail of anything properly in responsive manner  ',

			'name'=>'Easy Pricing Table'

		);

	parent::__construct('easy_pricing_table_widget','',$params);

	}	

	public function form($instance){//create the title form

		extract($instance);?>
		<p>
        	<label for="<?php echo $this->get_field_id('title');?>">Title</label>

            <input 

            	class="widefat"

                id="<?php echo $this->get_field_id('title');?>"

                name="<?php echo $this->get_field_name('title');?>"

                value="<?php if(isset($title)) echo esc_attr($title); ?>" />
		</p>

        <p>
        	<label for="<?php echo $this->get_field_id('select_no');?>">Select Table to be displayed</label>            
            <select 
            	class="widefat"

                id="<?php echo $this->get_field_id('select_no');?>"

                name="<?php echo $this->get_field_name('select_no');?>"

                value="<?php if(isset($select_no)) echo esc_attr($select_no); ?>">

                <option value="<?php if(isset($select_no)) echo esc_attr($select_no); ?> " ><?php if(isset($select_no)) echo esc_attr($select_no); ?></option>

				<?php global $wpdb; 
				$rows = $wpdb->get_results("SELECT pricing_table from ".$wpdb->prefix."pricing_table");
				foreach ($rows as $row ){?>     

            <option value="<?php echo esc_attr($row->pricing_table);?>"><?php echo esc_attr($row->pricing_table);?></option>

            <?php }?>

        	</select>            

        </p>

	<?php }
	public function widget($args,$instance){

		extract($args);

		extract($instance);

		echo $before_widget;?> 
        <h1><?php echo $before_title.$title.$after_title;?></h1>
                <section class="pricing_table_wrap"	>                
		<?php 
            global $wpdb;
            $rows = $wpdb->get_results($wpdb->prepare("SELECT * from  ".$wpdb->prefix."pricing_table where pricing_table = %s",$select_no));
            foreach($rows as $row){?>	
            <style>
                .pricing_table_wrap{background:<?php echo $row->back_color;?>!important;}
            </style>  
                    
            <h1><?php echo esc_html(stripcslashes( $row->pricing_table));?></h1> 
            <p><?php echo esc_html( stripcslashes($row->pricing_table_desc) );?></p>
        <?php }?>
        
        <?php 
            global $wpdb;
            $rows = $wpdb->get_results("SELECT * from ".$wpdb->prefix."pricing_detail INNER JOIN ".$wpdb->prefix."pricing_table where ".$wpdb->prefix."pricing_detail.pricing_t_id = "."".$wpdb->prefix."pricing_table.id"." AND ".$wpdb->prefix."pricing_table.pricing_table='".$select_no."' ORDER BY set_priority ASC limit ".$row->list_no);
            foreach($rows as $row){$buy_txt=unserialize($row->buy_txt);?>
            <style>
            
            .pricing_table_wrap li a:hover{ background:<?php echo $row->theme_color;?> !important; text-decoration:none}
            .jw_easy_pricing_tbl_col2{width:46% !important; }
            .jw_easy_pricing_tbl_col3{width:30% !important; }
            
            
            </style>
            
                <?php if($row->list_no=="2"){            
                	echo "<div class='jw_easy_pricing_tbl_col jw_easy_pricing_tbl_col2'>";}
                	else if($row->list_no=="3"){ echo "<div class='jw_easy_pricing_tbl_col jw_easy_pricing_tbl_col3'>";}
                	else if ($row->list_no=="4"){echo "<div class='jw_easy_pricing_tbl_col'>";}?>
                    <div class="pricing_table">
                        <h3 style="background:<?php echo esc_attr($row->title_back); ?> !important;"><?php echo esc_html(stripcslashes($row->title));?></h3>
                        <ul>
                            <li style="background:<?php echo $row->column_color;?>;"><span class="rounded"><?php echo esc_html($row->price);?>
                            <span>/<?php if($row->time_duration=='2'){echo "week";}
                            else if($row->time_duration=='3'){ echo "yr";}else if($row->time_duration=='4'){ echo "hr";}
                            else { echo "mo";}?></span></span></li>
                            <?php 
                            $wordChunks = explode(';',$row->pricing_features);//separate  the features 
                            for($i = 0; $i < count($wordChunks); $i++){
                            echo "<li>". stripcslashes($wordChunks[$i])."</li>";
                            }?>
                            <li style="background:<?php echo $row->column_color;?>;"><a href="<?php if(!empty($buy_txt['url'])){ echo esc_url($buy_txt['url']);} else { echo "#";}?>"><?php if(!empty($buy_txt['txt'])){ echo esc_attr($buy_txt['txt']);} else { echo "Buy Now";}?></a></li>
                        </ul>
                    </div>
                </div>            
            
         <?php }?>          
        <div style="clear:both"></div>
    </section>
	<?php echo $after_widget;
	}
}

//widgets function

add_action('widgets_init','register_easy_pricing_table_widget');

function register_easy_pricing_table_widget(){

	register_widget('easy_pricing_table_widget');

}

//widgets

define('PRICING',plugin_dir_path(__FILE__));
require_once(PRICING.'inc/easy_pricing_table.php');
require_once(PRICING. 'inc/add_pricing_table.php');
require_once(PRICING. 'inc/manage_pricing.php');
require_once(PRICING. 'inc/view_pricing_detail.php');
require_once(PRICING. 'inc/request.php');
require_once(PRICING. 'inc/easy_pricing_edit.php');
require_once(PRICING. 'inc/edit_easy_pricing_table.php');

//managing scripts and css
add_action('wp_print_scripts','css_pricing_table');
function css_pricing_table(){
	wp_register_style('jw_easy_pricing_admin',plugins_url( 'css/jw_easy_pricing_admin.css',__FILE__) );
	wp_enqueue_style('jw_easy_pricing_admin');

	wp_register_style('jw_easy_pricing_style',plugins_url( 'css/jw_easy_pricing_style.css',__FILE__) );
	if(!is_admin()):
	wp_enqueue_style('jw_easy_pricing_style');
	endif;
}
add_action('wp_print_scripts','js_pricing_table');
function js_pricing_table(){
wp_register_script('jscolor',plugins_url('js/jscolor.js', __FILE__) );
wp_enqueue_script('jscolor');
}

?>