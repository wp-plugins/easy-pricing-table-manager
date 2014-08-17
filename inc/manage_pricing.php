<?php
	function manage_pricing(){
		if(isset($_POST['insert'])){
		$title = sanitize_text_field($_POST['title']);
		$price = sanitize_text_field($_POST['price']);
		$theme_color = sanitize_text_field($_POST['theme_color']);
		$pricing_id = sanitize_text_field($_POST['pricing_t_id']);
		$time_duration = sanitize_text_field($_POST['time_duration']);
		$buy_txt = array('url'=>mysql_real_escape_string($_POST['buy_url']),'txt'=>mysql_real_escape_string($_POST['buy_txt']), array('%s','%s'));
		global $wpdb;
		$select_priority=$wpdb->get_var($wpdb->prepare("SELECT set_priority FROM ".$wpdb->prefix."pricing_detail where set_priority = %d", $_POST['set_priority']));
		if($select_priority){
			$message_error="Please Enter Different Priority Number. It is already in use";
		}
		else{
		$set_priority = sanitize_text_field($_POST['set_priority']);
		$features = sanitize_text_field(implode(";", $_POST['features']));
		$sql = $wpdb->query( $wpdb->prepare("
			INSERT INTO ".$wpdb->prefix."pricing_detail
			( title, price, column_color, time_duration, buy_txt, pricing_features, set_priority, pricing_t_id)
			VALUES ( %s, %s, %s, %d, %s, %s, %d, %d )", 
			array(
			$title, 
			$price, 
			$theme_color,
			$time_duration,
			serialize($buy_txt),
			$features,
			$set_priority,
			$pricing_id ) 
			) );
		}}

        if($sql){
			$message.="Detail Has Been Inserted";
		}?>        
    <script>

	jQuery(document).ready(function($){
	
		jQuery('#add').click(function(){
		
		var inp = $('#box');
		
		var i = $('input').size() + 1;
		
		$('<div id="box' + i +'"><tr><td><input type="text" name="features[]" placeholder="Add Another Features" /><img src="<?php echo plugins_url('easy-pricing-table-manager/img/remove.png');?>" width="24" height="24" border="0" align="top" class="add" id="remove" style="cursor:pointer; margin-left:10px; margin-top:8px;"/></td></tr></div>').appendTo(inp);
		
		i++;
		
	});
	
		$('body').on('click','#remove',function(){
		
		$(this).parent('div').remove();
				
		});
	});

</script>
		<div class="wrap jw_admin_wrap">
        <h2 style="border:0">Add The Pricing Detail <a href="<?php echo admin_url('admin.php?page=view_pricing_detail&id='.$_GET['id'])?>"> <button class="green_btn green_solid">Go Back</button></a></h2>
        
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message;?><br/><a href="<?php echo admin_url('admin.php?page=view_pricing_detail&id='.$_GET['id'])?>">&laquo; Back to  list</a>
        </p></div><?php endif;?>
       <?php if (isset($message_error)): ?><div class="updated" style="background:#F96; width:350px;"><p><?php echo $message_error;?><br/><a href="<?php echo admin_url('admin.php?page=view_pricing_detail&id='.$_GET['id'])?>">&laquo; Back to  list</a>
        </p></div><?php endif;?>
        
		<form method="post" action="#" class="easy_pricing_table"><br />
        	<table class="wp-list-table widefat fixed add_new_pricing_col">
        	
            	<tr><th><label>Title</label></th><td><input type="text" name="title"  placeholder="Add Title"/></td></tr>
                
                <tr><th><label>Price</label></th><td><input type="text" placeholder="Add Price Rate" name="price" /></td></tr>
                
                <tr><th><label>Pricing Feature</label></th><td><input type="text"   placeholder="Add Pricing Features" name="features[]" /><img src="<?php echo plugins_url('easy-pricing-table-manager/img/add.png');?>" width="24" height="24" border="0" align="top" class="add" id="add" style="cursor:pointer; margin-left:10px; margin-top:8px;"/></td></tr>
                <tr><td></td><td><div id="box"></div></td></tr> 
                
                 <tr><th><label>Time Duration</label></th><td>
                 <select name="time_duration">
                 <option value="1">Per Month</option>
                 <option value="2">Per Week</option>
                 <option value="3">Per Year</option>
                 <option value="4">Per Hour</option>
                 </select>                 
                 </td></tr>
                 
                  <tr><th><label>Buy Now Text</label></th><td><input type="text" name="buy_txt" id="buy_txt" value="Buy Now" /></td></tr>
                  
                  <tr><th><label>Buy Now URL</label></th><td><input type="text" name="buy_url" id="buy_url"  placeholder="Add Buy Now Link" /></td></tr>
                 
                                             
                <tr><th><label>Table Column Color</label></th><td><input type="text" name="theme_color" id="mycolor2" value="#f39c12" class="color {hash:true}" /></td></tr>
                
                <tr><th><label>Set Priority</label></th><td><input type="text" name="set_priority"   placeholder="Add Table Column Priority Order" required /></td></tr>
                
                
                <input type="hidden" value="<?php echo $_GET['id'];?>" name="pricing_t_id"/>
                <tr><th></th><td><input type="submit" value="Save Detials" name="insert" class="green_btn green_solid"/></td></tr>
                   
            </table>
        </form>
		</div>
<?php }?>