<?php
	function easy_pricing_table(){?>
    	<h1>welcome to Easy Pricing Table</h1>
        
        <div class="wrap jw_admin_wrap">
        <?php 
        global $wpdb;
        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."pricing_table");
		
		foreach($rows as $row);
		
		if($row->id!=''){
		echo "<h2>Available Pricing Table</h2>";echo "<br/>";
		echo "<table class='widefat front_item_list'>";
		echo "<th style='width:20%;'>Table Name</th> <th style='width:15%;'>Add Detail</th style='width:30%;'><th>Shortcode</th><th style='width:20%;'>Description</th><th style='width:15%;'>Action</th>";
		foreach($rows as $row){?>
        	<tr class="list"><td><a style="font-size:16px;" href="<?php echo admin_url('admin.php?page=view_pricing_detail&id='.$row->id);?>">
				<?php echo esc_attr($row->pricing_table);?></a></td>
                   
            <td><a href="<?php echo admin_url('admin.php?page=manage_pricing&id='.$row->id);?>" class="easy_pricing_table_name">
				<button class="green_btn">Add new Column</button></a></td>
                
                <!--shortcode-->
             <td>[easy-pricing-table table_name="<?php echo $row->pricing_table;?>"]</td>
             <td><?php echo substr(stripcslashes($row->pricing_table_desc),0,50)."....";?></td>
              
              <!--edit-->                
            <td width="200px"> <a href="<?php echo admin_url('admin.php?page=edit_easy_pricing_table&id='.$row->id);?>">
              <button class="green_btn easy_pricing_list_details_edit edit_table" id="edit_id">Edit</button></a>
              <!--remove-->
              <button class="red_btn easy_pricing_list_details_delete remove_table_id" table_id="<?php echo $row->id;?>">Remove</button>
             </td></tr>
            <?php }?></table> <h2 style="margin-top:25px;">Add New Table</h2><br/>
            <a href="admin.php?page=add_pricing_table"><button class="green_btn green_solid">Add New Table</button></a> 
			<?php }else {?>
            <strong>Create New Table</strong><br/><br/>
            <a href="admin.php?page=add_pricing_table"><button class="green_btn green_solid">Create New Table</button></a><?php }?>
        </div>
		<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".remove_table_id").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("table_id");
                //Built a url to send
                var info = 'table_id=' + del_id;
                if(confirm("Sure you want to delete this Pricing Table? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=request');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".list").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
         </script>
<?php }?>