@extends('frontend.layout.app')

@section('title', 'FAQ')

@section('content')

<style>

/* FAQ Section */

.faq-area{
background:#ffffff;
}


/* Section Heading */

.section-main-title{
font-size:32px;
font-weight:700;
color:#222;
}


/* FAQ Card */

.faq-box{
background:#fff;
padding:35px;
border-radius:10px;
border:1px solid #eee;
box-shadow:0 10px 25px rgba(0,0,0,0.05);
height:100%;
}


/* FAQ Category Title */

.faq-box h4{
font-size:22px;
font-weight:600;
margin-bottom:20px;
border-bottom:1px solid #eee;
padding-bottom:10px;
}


/* FAQ Item */

.single-faq{
padding-bottom:18px;
border-bottom:1px solid #f2f2f2;
}


.single-faq:last-child{
border-bottom:none;
}


/* Question */

.single-faq h5{
font-size:17px;
font-weight:600;
color:#111;
margin-bottom:8px;
}


/* Answer */

.single-faq p{
font-size:15px;
color:#666;
line-height:1.6;
margin-bottom:0;
}


/* Contact CTA */

.faq-contact{
background:#f9f9f9;
padding:40px;
border-radius:10px;
margin-top:60px;
}


.faq-contact h4{
font-weight:600;
margin-bottom:10px;
}


.faq-contact p{
color:#666;
}


.faq-contact a{
padding:10px 28px;
background:#000;
color:#fff;
border-radius:5px;
text-decoration:none;
display:inline-block;
margin-top:10px;
}


.faq-contact a:hover{
background:#333;
color:#fff;
}

</style>



<!-- page title area start -->

<section class="page-title-area" data-background="{{ asset('frontend/assets/img/banner/banner-1-1.jpeg') }}">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Frequently Asked Questions</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin">
                           <a href="{{ route('home') }}"><span>Home</span></a>
                        </li>
                        <li class="trail-item trail-end">
                           <span>FAQ</span>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>


<!-- FAQ area start -->

<section class="faq-area pt-120 pb-120">

<div class="container container-small">

  <div class="text-center mb-60">
     <h2 class="section-main-title mb-20">Got Questions?</h2>
     <p>Find answers to the most common questions about shopping with Tinnity.</p>
  </div>


  <div class="row">

     <div class="col-lg-6 mb-40">
        <div class="faq-box">
           <h4>Orders</h4>

           <div class="single-faq">
              <h5>How do I place an order?</h5>
              <p>Browse our collection, select your preferred product, size, and color, then click "Add to Cart". Once ready, proceed to checkout and complete your payment.</p>
           </div>

           <div class="single-faq">
              <h5>Can I cancel my order?</h5>
              <p>Yes, orders can be cancelled before they are shipped. Please contact our support team as soon as possible.</p>
           </div>

           <div class="single-faq">
              <h5>How can I track my order?</h5>
              <p>After your order is shipped, you will receive a tracking number via email which you can use to track your package.</p>
           </div>

        </div>
     </div>


     <div class="col-lg-6 mb-40">
        <div class="faq-box">
           <h4>Shipping</h4>

           <div class="single-faq">
              <h5>How long does shipping take?</h5>
              <p>Standard shipping usually takes 3-7 business days depending on your location.</p>
           </div>

           <div class="single-faq">
              <h5>Do you offer international shipping?</h5>
              <p>Yes, we ship internationally. Shipping time may vary depending on the destination country.</p>
           </div>

           <div class="single-faq">
              <h5>Is shipping free?</h5>
              <p>We offer free shipping on orders above a certain amount during promotional periods.</p>
           </div>

        </div>
     </div>


     <div class="col-lg-6 mb-40">
        <div class="faq-box">
           <h4>Returns & Refunds</h4>

           <div class="single-faq">
              <h5>What is your return policy?</h5>
              <p>We accept returns within 30 days of delivery for items that are unused and in original condition.</p>
           </div>

           <div class="single-faq">
              <h5>How do I request a refund?</h5>
              <p>You can request a refund by contacting our support team with your order number and reason for return.</p>
           </div>

           <div class="single-faq">
              <h5>How long does a refund take?</h5>
              <p>Refunds are processed within 5–7 business days after we receive the returned item.</p>
           </div>

        </div>
     </div>


     <div class="col-lg-6 mb-40">
        <div class="faq-box">
           <h4>Products</h4>

           <div class="single-faq">
              <h5>Are Tinnity T-shirts good quality?</h5>
              <p>Yes, our T-shirts are made from premium quality fabric designed for comfort, durability, and style.</p>
           </div>

           <div class="single-faq">
              <h5>How do I choose the right size?</h5>
              <p>You can refer to our size guide available on each product page to find the best fit.</p>
           </div>

           <div class="single-faq">
              <h5>Do you restock sold out products?</h5>
              <p>Some popular items are restocked. You can subscribe to our newsletter to receive restock notifications.</p>
           </div>

        </div>
     </div>

  </div>


  <div class="faq-contact text-center">

     <h4>Still have questions?</h4>

     <p>Contact our support team and we’ll be happy to help you.</p>

     <a href="{{ route('contact') }}">Contact Us</a>

  </div>

</div>

</section>

@endsection