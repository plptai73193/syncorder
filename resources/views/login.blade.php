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
               {{-- <input type="hidden" name="cafe24_mall_id" value="{{ $mall_id }}"> --}}
               <div class="form-group row">
                  <label for="email_address" class="col-md-4 col-form-label text-md-right">API Username</label>
                  <div class="col-md-6">
                     <input type="text" id="api_username" class="form-control" name="api_username" required>
                  </div>
               </div>

               <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">Secret Key</label>
                  <div class="col-md-6">
                     <input type="password" id="secret_key" class="form-control" name="secret_key" required>
                  </div>
               </div>

               <div class="col-md-6 offset-md-4 text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
         </form>
      </div>
   </div>
@endsection