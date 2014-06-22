<?php
	function view_pricing_detail(){?>
	<div class="wrap jw_admin_wrap">
        
        <aside>

        <h2 style="border:0">Manage And Add Pricing Detail <a href="<?php echo admin_url('admin.php?page=easy_pricing_table');?>">
        <button class="green_btn green_solid">Back</button></a></h2><br/>
        
        <a href="<?php echo admin_url('admin.php?page=manage_pricing&id='.$_GET['id']);?>" class="green_btn green_solid" style="text-decoration:none"> Add New Pricing Column</a>
        <br/><br/>
        
        <?php
        global $wpdb;
        $rows = $wpdb->get_results("SELECT *from ".$wpdb->prefix."pricing_detail ORDER BY pid ASC");
		$pid = $wpdb->get_var($wpdb->prepare( "SELECT pricing_t_id FROM ".$wpdb->prefix."pricing_detail  where pricing_t_id = %d", $_GET['id']));	
		if($pid!=$_GET['id']){ echo "Enter the new team detail by clicking above button"; echo $pid;}else{
        echo "<table class='list-table widefat fixed jw_easy_pricint_col_list'>";
        echo "<tr><th style='width:6%;'>Priority</th><th style='width:10%;'>Title</th><th style='width:6%;'>Price</th><th style='width:42%;'>Features</th><th style='width:10%;'>Column Color</th><th style='width:10%;'>Time Duration</th><th style='width:16%;'>Action</th></tr>";
        foreach ($rows as $row ){if($row->pricing_t_id==$_GET['id']){?>
            <tr class="easy_pricing_list">
            <td class="easy_pricing_list_title"><?php echo esc_attr($row->set_priority);?></td>
            <td class="easy_pricing_list_title"><?php echo stripcslashes($row->title);?></td>
            <td class="easy_pricing_list_title"><?php echo esc_attr($row->price);?></td>
            <td class="easy_pricing_list_title">
            <?php  
             $ft = explode(';',stripcslashes($row->pricing_features));//separate  the features 
             for($i = 0; $i < count($ft); $i++){?>
             
              	<li><?php echo stripcslashes($ft[$i]);?></li>
              
             <?php }?>
            </td>
            <td class="easy_pricing_list_title"><input type="text" style="width:45px;background:<?php echo $row->column_color;?>"/></td>
            <td class="easy_pricing_list_title"><?php if($row->time_duration=="1"){ echo "Per Month";} else if($row->time_duration=="2"){ echo "Per Week";} else {echo "Per Year";}?></td>
            <td class="easy_pricing_list_action"><a href='<?php echo admin_url('admin.php?page=easy_pricing_edit&table_id='.$_GET['id'].'&id='.$row->pid );?>' 
   			class="green_btn">Edit</a> 
     		<a href="#" id="<?php echo $row->pid;?>" class="red_btn easy_pricing_list_details_delete">Remove</a></td>	
            </tr>
            <?php }}?>
            </table>
				<script type="text/javascript">
                jQuery(document).ready(function($) {
                $(".easy_pricing_list_details_delete").click(function(){
                //Save the link in a variable called element
                var element = $(this);
                //Find the id of the link that was clicked
                var del_id = element.attr("id");
                //Built a url to send
                var info = 'id=' + del_id;
                if(confirm("Sure you want to delete this list? There is NO undo!")){
                   $.ajax({
                   type: "GET",
                   url: "<?php echo admin_url('admin.php?page=request');?>",
                   data: info,
                   success: function(){
                }
                });
                     $(this).parents(".easy_pricing_list").animate({ backgroundColor: "#e74c3c" }, "slow")
                    .animate({ opacity: "hide" }, "slow");
                }
                return false;
                });
                });
                </script>
            </aside>
    </div>
<?php }}?>