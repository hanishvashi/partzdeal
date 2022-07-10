<option value="">Select Country</option>
@if(Auth::guard('user')->check())
	@foreach (DB::table('countries')->get() as $data)
	<option value="{{ $data->name }}" {{ Auth::guard('user')->user()->country == $data->name ? 'selected' : '' }}>{{ $data->name }}</option>
	@endforeach
@else
	@foreach (DB::table('countries')->get() as $data)
	<option value="{{ $data->name }}">{{ $data->name }}</option>
	@endforeach
@endif
