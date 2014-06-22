<?php
	function edit_easy_pricing_table(){
			if(isset($_POST['update'])){
				$id = sanitize_text_field($_GET['id']);
				$name = sanitize_text_field($_POST['name']);
				
				$detail = sanitize_text_field($_POST['detail']);
				$back_color = sanitize_text_field($_POST['back_color']);
				$theme_color = sanitize_text_field($_POST['theme_color']);
				$title_back = sanitize_text_field($_POST['title_back']);
				$list_no = sanitize_text_field($_POST['list_no']);
				global $wpdb;
				$sql=$wpdb->update( 
					''.$wpdb->prefix.'pricing_table', 
					array('pricing_table'=>$name,
					'back_color'=>$back_color,
					'theme_color'=>$theme_color,
					'title_back'=>$title_back,
					'list_no'=>$list_no,
					'pricing_table_desc'=>$detail),
					array( 'id' => $id ), 
					array( 
						 ' %s ',
						 ' %s ',
						 ' %s ',
						 ' %s ',
						 ' %d ',
						 ' %s '
					), 
					array( '%d' ) 
				);
				
				if($sql){
					$location=admin_url('admin.php?page=easy_pricing_table');
					echo'<script> window.location="'.$location.'"; </script> ';
			}} else {
				global $wpdb;
				$rows = $wpdb->get_results($wpdb->prepare("SELECT * from  ".$wpdb->prefix."pricing_table where id = %d",$_GET['id']));
				foreach($rows as $row){
					$title=$row->pricing_table;
					$detail=stripcslashes($row->pricing_table_desc);
					$back_color=$row->back_color;
					$theme_color=$row->theme_color;
					$title_back= $row->title_back;
					$list_no = $row->list_no;
            }}?>
			<div class="jw_admin_wrap">
                <table class="widefat add_new_pricing_tbl">
                <h2 style="border-bottom:0;">Edit the Pricing Table &nbsp; <a href="<?php echo admin_url('admin.php?page=easy_pricing_table');?>"><button class="green_btn green_solid">Back</button></a></h2>
    
                <form action="#" method="post">
                <tr><th>Name</th><td><input type="text" name="name"  value="<?php echo esc_attr($title);?>"/></td></tr>
                <tr><th>Detail</th><td><textarea id="detail" name="detail" cols="50" rows="4" ><?php echo esc_textarea($detail);?></textarea></td></tr>
                <tr><th>Background Color</th><td><input type="text" name="back_color" id="mycolor2" class="color { hash:true}"  value="<?php echo esc_attr($back_color);?>"/>
                </td></tr>
               
                <tr><th>Theme Color</th><td><input type="text" name="theme_color" id="theme_color" value="<?php if(isset($theme_color)) echo esc_attr($theme_color);?>" class="color { hash:true}"/></td></tr>
                
                <tr><th>Table Title Background</th><td><input type="text" name="title_back" id="title_back" value="<?php if(isset($title_back)) echo esc_attr($title_back);?>"  class="color { hash:true}"/></td></tr>
                
                <tr><th>Number of Column</th><td><select name="list_no">
                <?php if($list_no=="2"){
                echo '<option value="2">2 Columns Per Row</option>'; echo '<option value="3">3 Columns Per Row</option>';echo '<option value="4">4 Columns Per Row</option>';}
                else if($list_no=="3"){ echo '<option value="3">3 Columns Per Row</option>'; echo '<option value="2">2 Columns Per Row</option>';echo '<option value="4">Four Columns Per Row</option>';}
               else if($list_no=="4"){ echo '<option value="4">4 Columns Per Row</option>';echo '<option value="3">3 Columns Per Row</option>'; echo '<option value="2">2 Columns Per Row</option>';}?>
                </select></td></tr>
                
                <tr><th></th>
                <td><input type="submit" value="Update" name="update" class="green_btn green_solid"></td></tr>
                </form>
            </table>
        </div>
<?php }?>