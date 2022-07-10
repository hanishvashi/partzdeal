<option value="">Select Category</option>
<?php if(!empty($allcategories)){ foreach($allcategories as $category){?>
<option value="<?php echo $category->id;?>"><?php echo $category->cat_name;?></option>
<?php }}?>
