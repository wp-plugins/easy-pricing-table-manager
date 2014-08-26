<?php
	function easy_pricing_edit(){
		if(isset($_POST['update'])){
		$id = sanitize_text_field($_POST['id']);
		$title = sanitize_text_field($_POST['title']);
		$price = sanitize_text_field($_POST['price']);
		$theme_color = sanitize_text_field($_POST['theme_color']);
		$pricing_id = sanitize_text_field($_POST['pricing_t_id']);
		$time_duration = array('time_durt'=>mysql_real_escape_string($_POST['time_duration']),'sh_t'=>mysql_real_escape_string($_POST['sh_time_durt']), 
		array('%s','%s'));
		$buy_txt = array('url'=>mysql_real_escape_string($_POST['buy_url']),'txt'=>mysql_real_escape_string($_POST['buy_txt']), array('%s','%s'));
		$pricing_id = sanitize_text_field($_POST['pricing_t_id']);
		
		$ft = sanitize_text_field(implode(";", $_POST['features']));
		$features = sanitize_text_field(ltrim($ft,";"));
		$set_priority = sanitize_text_field($_POST['set_priority']);

		global $wpdb;
		$sql=$wpdb->update( 
			''.$wpdb->prefix.'pricing_detail', 
			array('title'=>$title,
			'price'=>$price,
			'column_color'=>$theme_color,
			'time_duration'=>serialize($time_duration),
			'buy_txt'=> serialize($buy_txt),
			'pricing_features'=>$features,
			'set_priority'=>$set_priority
			),
			array( 'pid' => $id ), 
			array( 
				' %s',
				' %s ',
				' %s ',
				' %s ',
				' %s ',
				' %s ',
				' %d ',
				' %d '
			), 
			array( '%d' ) 
		);
		}
        if($sql){
			$message.="Detail Has Been Updated";
		} else {
        global $wpdb;
		
		$rows=$wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."pricing_detail where pid = %d", $_GET['id']));
		foreach($rows as $row){
			$title=$row->title;
			$theme_color=$row->column_color;
			$tme_duration = unserialize($row->time_duration);
			$buy_txt=unserialize($row->buy_txt);
			$price=$row->price;
			$set_priority=$row->set_priority;
			$pricing_features=$row->pricing_features;
		}
        
        }?>
      <script>
	jQuery(document).ready(function($){
	
		jQuery('#add').click(function(){
		
		var inp = $('#box');
		
		var i = $('input').size() + 1;
		
		$('<div id="box' + i +'"><tr><td><input type="text" name="features[]" placeholder="Add Another Features" /><img src="<?php echo plugins_url('easy-pricing-table-manager/img/remove.png');?>" width="24" height="24" border="0" align="top" class="add" id="remove"  style="cursor:pointer; margin-left:10px; margin-top:10px;" /></td></tr></div>').appendTo(inp);
		
		i++;		
		});
	
		jQuery('body').on('click','#remove',function(){
		
		jQuery(this).parent('div').remove();
				
		});
		jQuery(".remove_edit").live('click', function(event) {
		jQuery(this).css("background-color","#FF3700");
		jQuery(this).fadeOut(400, function(){
		jQuery(this).parent().parent().remove();
		});
		});
	});
	

</script>
		<div class="wrap jw_admin_wrap">
        <?php if (isset($message)): $location=admin_url('admin.php?page=view_pricing_detail&id='.$_GET['table_id']);
        echo'<script> window.location="'.$location.'"; </script> ';endif;?>
        
        <h2 style="border:0;">Edit The Pricing Detail <a href="<?php echo admin_url('admin.php?page=view_pricing_detail&id='.$_GET['table_id']);?>">
        <button class="green_btn green_solid">Go Back</button></a></h2>
        
		<form method="post" action="#" class="easy_pricing_table"><br />
        
        	<table class="wp-list-table widefat fixed add_new_pricing_col">
        	
            	<tr><th><label>Title</label></th><td><input type="text" name="title" value="<?php if(isset($title)) echo esc_attr($title);?>"/></td></tr>
                
                <tr><th><label>Price</label></th><td><input type="text" name="price" value="<?php if($price!='')echo esc_attr($price);?>" /></td></tr>
                
                <tr><th><label>Pricing Feature</label></th><td style="font-size:16px; padding-top:15px;">Add New Feature Input box<img src="<?php echo plugins_url('easy-pricing-table-manager/img/add.png');?>" width="24" height="24" border="0" align="top" class="add" id="add" style="cursor:pointer; margin-left:10px; margin-top:2px;"/></td></tr>

				<?php  
                $ft = explode(';',$pricing_features);//separate  the features 
                for($i = 0; $i < count($ft); $i++){?>
                <tr class="remove_tr"><th>Pricing Feature <?php echo $i;?></th><td><input type="text" value="<?php echo stripcslashes($ft[$i]);?>" name="features[]" required/><img src="<?php echo plugins_url('easy-pricing-table-manager/img/remove.png');?>" width="24" height="24" border="0" align="top"class="remove_edit" id="<?php echo $i;?>" style="cursor:pointer; margin-left:10px; margin-top:10px;"/></td></tr>
                <?php }?>
                
                 <tr><td></td><td><div id="box"></div></td></tr>                        
                 
                 <tr><th><label>Time Duration</label></th><td>
                 <select name="time_duration">
                 <option value="1" <?php if($tme_duration['time_durt']=='1'){?> selected<?php }?> >Per Minute</option>
                 <option value="2" <?php if($tme_duration['time_durt']=='2'){?> selected<?php }?> >Per Hour</option>
                 <option value="3" <?php if($tme_duration['time_durt']=='3'){?> selected<?php }?> >Per Week</option>
                 <option value="4" <?php if($tme_duration['time_durt']=='4'){?> selected<?php }?> >Per Month</option>
                 <option value="5" <?php if($tme_duration['time_durt']=='5'){?> selected<?php }?> >Per Year</option>
                 <option value="6" <?php if($tme_duration['time_durt']=='6'){?> selected<?php }?> >One Time</option>
                 
                 </select>                 
                 </td></tr>
                              <!--Show hide time duration new features 1.2.1!-->
                 <tr><th></th><td><input type="radio" name="sh_time_durt" value="s_t" <?php if(isset($tme_duration['sh_t']) AND $tme_duration['sh_t']=='s_t'){?> checked <?php }?> >Show &nbsp;<input type="radio" value="h_t" name="sh_time_durt" <?php if(isset($tme_duration['sh_t']) AND $tme_duration['sh_t']=='h_t'){?> checked <?php }?> >Hide</td></tr>
                 
                  <tr><th><label>Buy Now Text</label></th><td><input type="text" name="buy_txt" id="buy_txt" value="<?php echo esc_attr($buy_txt['txt']); ?>" /></td></tr>
                  
                  <tr><th><label>Buy Now URL</label></th><td><input type="text" name="buy_url" id="buy_url" value="<?php echo esc_url($buy_txt['url']);?>" /></td></tr>               
                <tr><th><label>Table Column Color</label></th><td><input type="text" name="theme_color"  value="<?php if($theme_color!='')echo esc_attr($theme_color);?>" id="mycolor2" class="color {hash:true}" /></td></tr>
                
                <tr><th><label>Set Priority</label></th><td><input type="text" name="set_priority" value="<?php echo esc_attr($set_priority);?>" required /></td></tr>

                
                <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>" />
                
                <tr><th></th><td><input type="submit" value="Save Details" name="update" class="green_btn green_solid"/></td></tr>
                   
            </table>
        </form>
		</div>
<?php }?>