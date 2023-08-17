<option value="">Select Category</option>
<?php if(!empty($allcategories)){ foreach($allcategories as $category){?>
<option <?php if($current_category_id==$category->id){ echo 'selected'; } ?> value="<?php echo $category->id;?>"><?php echo $category->cat_name;?></option>
<?php }}?>
