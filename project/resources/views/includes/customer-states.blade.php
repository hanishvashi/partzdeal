@foreach($allstates as $staterow)
<option <?php if($user->state==$staterow['name']){ echo 'selected'; }?> value="{{ $staterow['name'] }}">{{ $staterow['name'] }}</option> 
@endforeach