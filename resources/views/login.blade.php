@php
   use App\Libs\Cafe24\Cafe24Token;
@endphp

@extends('layout.master')
@section('login_form')
   <div class="card">
      <div class="card-header">Sync order</div>
      <div class="card-body">
         <form action="{{ route('user') }}" method="POST">
               @csrf
               @php
                   $installed_mall_id = Cafe24Token::getInstalledMallId($_SERVER["HTTP_REFERER"]);
               @endphp
               <input type="hidden" id="cafe24_mall_id" class="form-control" name="cafe24_mall_id" value="{{$installed_mall_id}}">
               <div class="form-group row">
                  <label for="email_address" class="col-md-4 col-form-label text-md-right">API Username</label>
                  <div class="col-md-6">
                     <input type="text" id="email_address" class="form-control" name="api_username" required autofocus>
                  </div>
               </div>

               <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">Secret Key</label>
                  <div class="col-md-6">
                     <input type="password" id="password" class="form-control" name="secret_key" required>
                  </div>
               </div>

               <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
         </form>
      </div>
   </div>
@endsection