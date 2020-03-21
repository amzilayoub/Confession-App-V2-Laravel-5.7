@extends('extends.indexParent')

@section('content')

<section class="fullPost" style="display: block;">

	<input type="hidden" name="token" id="_token" value="{{ csrf_token() }}">

    <a href="/works/confV2/public/"><i class="la la-home"></i></a>

@include('miniViews.showFullPost')

</section>



@endsection