<?php
	function add_pricing_table(){?>
        <?php 
			if(isset($_POST['insert'])){
				$name = sanitize_text_field($_POST['name']);
				
				$detail = sanitize_text_field($_POST['detail']);
				$back_color = sanitize_text_field($_POST['back_color']);
				$theme_color = sanitize_text_field($_POST['theme_color']);
				$title_back = sanitize_text_field($_POST['title_back']);
				$list_no = sanitize_text_field($_POST['list_no']);
				global $wpdb;
				$sql = $wpdb->query( $wpdb->prepare("
					INSERT INTO ".$wpdb->prefix."pricing_table
					( pricing_table, back_color, theme_color, title_back, list_no, pricing_table_desc)
					VALUES ( %s, %s, %s, %s, %d, %s )", 
					array(
					$name, 
					$back_color, 
					$theme_color,
					$title_back,
					$list_no,
					$detail ) 
				) );
			}
			if($sql){
				$location=admin_url('admin.php?page=easy_pricing_table');
        		echo'<script> window.location="'.$location.'"; </script> ';
			}
		?>
        <div class="jw_admin_wrap">
            <table class="widefat add_new_pricing_tbl">
    
                <h2 style="border-bottom:0;">Add the Pricing Table &nbsp; <a href="<?php echo admin_url('admin.php?page=easy_pricing_table');?>"><button class="green_btn green_solid">Back</button></a></h2>
    
                <form action="#" method="post">
                <tr><th>Name</th><td><input type="text" name="name" placeholder="Add Name"  required/></td></tr>
                <tr><th>Detail</th><td><textarea id="detail" name="detail" cols="50" rows="4" placeholder="Add Some Description" ></textarea></td></tr>
                <tr><th>Background Color</th><td><input type="text" name="back_color" id="back_color" value="#34495E" class="color { hash:true}"/></td></tr>
                
                <tr><th>Theme Color</th><td><input type="text" name="theme_color" id="theme_color" value="#FF6C60" class="color { hash:true}"/></td></tr>
                <tr><th>Table Title Background</th><td><input type="text" name="title_back" value="#283B4D" id="title_back"  class="color { hash:true}"/></td></tr>
                
                <tr><th>Number of Column</th><td><select name="list_no">
                <option value="2">Two Columns Per Row</option>
                <option value="3">Three Columns Per Row</option>
                <option value="4">Four Columns Per Row</option>
                </select></td></tr>
                
                <tr><th></th>
                <td><input type="submit" value="Save Table" name="insert" class="green_btn green_solid"></td></tr>
                </form>
            </table>
        </div>
		
<?php }?>