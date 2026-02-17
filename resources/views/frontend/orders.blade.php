@extends('frontend.layout.app')

@section('title', 'My Orders')

@section('content')
<section class="page-title-area" data-background="{{ asset('frontend/assets/img/bg/page-title-bg.html') }}">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">My Orders</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end"><span>My Orders</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="pt-120 pb-120">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-8">
            <div class="text-center">
               <p>Your orders will appear here.</p>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
