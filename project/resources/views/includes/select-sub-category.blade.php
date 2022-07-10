<option value="">Select Sub Category</option>
<?php if(!empty($subcategories)){ foreach($subcategories as $category){?>
<option value="<?php echo $category->id;?>"><?php echo $category->cat_name;?></option>
<?php }}?>
