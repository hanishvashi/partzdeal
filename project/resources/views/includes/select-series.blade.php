<option value="">Select Series</option>
<?php if(!empty($allseries)){ foreach($allseries as $series){?>
<option value="<?php echo $series->id;?>"><?php echo $series->series_name;?></option>
<?php }}?>
