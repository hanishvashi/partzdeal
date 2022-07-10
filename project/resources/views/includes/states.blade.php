@foreach($allstates as $staterow)
<option value="{{ $staterow['name'] }}">{{ $staterow['name'] }}</option>
@endforeach
