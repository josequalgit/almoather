@extends('frontEnd.layouts.index')

@section('content')
<section  class="section-contract" style="background-image: url('{{ asset('frontEnd/img/Rectangle%2016355.png') }}')">
    <div class="min-height-100">
        <div class="container">

        </div>
    </div>
        </section>
@endsection



@section('scripts')
<script>
    let token = '{{\Cookie::get("jwt_token")}}';
    console.log('token:',token);
</script>
@endsection