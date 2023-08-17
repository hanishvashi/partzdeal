<form id="searchForm" class="search-form" action="{{route('custom-search-form')}}" method="GET">
<div class="input-group has-search">
<input type="text" id="prod_name" value="<?php if(isset($_GET['search'])){ echo $_GET['search']; }?>" name="search" class="form-control" placeholder="Search products by SKU">
<div class="input-group-append">
<a href="#" class="input-group-text form-control-feedback"><span class="fa fa-search"></span></a>
</div>
</div>
<div class="autocomplete" style="display:none;">
<div id="myInputautocomplete-list" class="autocomplete-items">
</div>
</div>
</form>
