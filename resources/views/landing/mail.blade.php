<h1>{{ translate('Demo Request') }}</h1>
<p><b>Name: </b>{{ $client['name'] }}</p>
<p><b>E-mail: </b>{{ $client['email'] }}</p>
<p><b>Phone: </b>{{ $client['contact_number'] }}</p>
<p><b>Store Type: </b>{{ $client['shop_type'] }}</p>
{{-- <p>
	<b>Details</b>
	<br>
	@php echo $details; @endphp
</p> --}}
{{-- <a class="btn btn-primary btn-md" href="{{ $link }}">{{ translate('See ticket') }}</a> --}}
