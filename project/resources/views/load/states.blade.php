<option value="">Select State</option>
@if(Auth::guard('user')->check())
	@foreach ($allstates as $data)
	<option value="{{ $data->name }}" {{ Auth::guard('user')->user()->state == $data->name ? 'selected' : '' }}>{{ $data->name }}</option>
	@endforeach
@else
	@foreach ($allstates as $data)
	<option value="{{ $data->name }}">{{ $data->name }}</option>
	@endforeach
@endif
