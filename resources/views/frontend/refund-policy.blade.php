@extends('frontend.layout.app')

@section('title', 'Refund Policy')
@section('content')
<!-- page title area start  -->
<section class="page-title-area" data-background="assets/img/bg/page-title-bg.html">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="page-title-wrapper text-center">
               <h1 class="page-title mb-10">Refund Policy</h1>
               <div class="breadcrumb-menu">
                  <nav aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs">
                     <ul class="trail-items">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end"><span>Refund Policy</span></li>
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- page title area end  -->

<!-- refund policy content -->
<section class="refund-policy-area pt-120 pb-120">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 mx-auto">
            <div class="refund-policy-content">
               
               <!-- Policy Overview -->
               <div class="policy-section mb-50">
                  <h2 class="section-title mb-30">Our Commitment to You</h2>
                  <div class="policy-highlight p-30 mb-30">
                     <i class="fas fa-shield-check text-success mr-3"></i>
                     <div>
                        <h4 class="mb-10">30-Day Money-Back Guarantee</h4>
                        <p class="mb-0">We stand behind the quality of our products. If you're not completely satisfied with your purchase, we offer a full refund within 30 days of delivery.</p>
                     </div>
                  </div>
                  <p>At Tinnity Ecom, customer satisfaction is our top priority. We understand that sometimes a product may not meet your expectations, and we want to make the return process as simple and hassle-free as possible.</p>
               </div>

               <!-- Refund Eligibility -->
               <div class="policy-section mb-50">
                  <h3 class="section-subtitle mb-25">Refund Eligibility</h3>
                  <div class="eligibility-grid">
                     <div class="eligibility-item eligible mb-20">
                        <i class="fas fa-check-circle text-success"></i>
                        <div>
                           <h5>Items in Original Condition</h5>
                           <p>Products must be unworn, unwashed, and with all original tags attached</p>
                        </div>
                     </div>
                     <div class="eligibility-item eligible mb-20">
                        <i class="fas fa-check-circle text-success"></i>
                        <div>
                           <h5>Within 30 Days</h5>
                           <p>Refund requests must be initiated within 30 days of delivery</p>
                        </div>
                     </div>
                     <div class="eligibility-item eligible mb-20">
                        <i class="fas fa-check-circle text-success"></i>
                        <div>
                           <h5>Original Packaging</h5>
                           <p>Items should be returned in their original packaging when possible</p>
                        </div>
                     </div>
                     <div class="eligibility-item not-eligible mb-20">
                        <i class="fas fa-times-circle text-danger"></i>
                        <div>
                           <h5>Custom/Personalized Items</h5>
                           <p>Custom designed or personalized products cannot be returned unless defective</p>
                        </div>
                     </div>
                     <div class="eligibility-item not-eligible mb-20">
                        <i class="fas fa-times-circle text-danger"></i>
                        <div>
                           <h5>Final Sale Items</h5>
                           <p>Items marked as "Final Sale" or purchased with special discounts are non-refundable</p>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Refund Process -->
               <div class="policy-section mb-50">
                  <h3 class="section-subtitle mb-25">How to Request a Refund</h3>
                  <div class="process-steps">
                     <div class="step-item mb-30">
                        <div class="step-number">1</div>
                        <div class="step-content">
                           <h5>Contact Us</h5>
                           <p>Email us at <a href="mailto:refunds@tinnityecom.com">refunds@tinnityecom.com</a> or call our customer service at <a href="tel:+1234567890">+1 (234) 567-890</a> with your order number and reason for return.</p>
                        </div>
                     </div>
                     <div class="step-item mb-30">
                        <div class="step-number">2</div>
                        <div class="step-content">
                           <h5>Get Return Authorization</h5>
                           <p>Our team will provide you with a Return Authorization (RA) number and detailed return instructions within 24 hours.</p>
                        </div>
                     </div>
                     <div class="step-item mb-30">
                        <div class="step-number">3</div>
                        <div class="step-content">
                           <h5>Ship the Item</h5>
                           <p>Package the item securely with the RA number clearly marked and ship it to our return center using the provided shipping label.</p>
                        </div>
                     </div>
                     <div class="step-item mb-30">
                        <div class="step-number">4</div>
                        <div class="step-content">
                           <h5>Processing & Refund</h5>
                           <p>Once we receive and inspect your return, we'll process your refund within 5-7 business days to your original payment method.</p>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Refund Timeframes -->
               <div class="policy-section mb-50">
                  <h3 class="section-subtitle mb-25">Refund Timeframes</h3>
                  <div class="timeframe-table">
                     <table class="table table-bordered">
                        <thead class="bg-light">
                           <tr>
                              <th>Payment Method</th>
                              <th>Processing Time</th>
                              <th>Total Time to Account</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>Credit/Debit Card</td>
                              <td>5-7 business days</td>
                              <td>7-10 business days</td>
                           </tr>
                           <tr>
                              <td>PayPal</td>
                              <td>3-5 business days</td>
                              <td>3-7 business days</td>
                           </tr>
                           <tr>
                              <td>Bank Transfer</td>
                              <td>5-7 business days</td>
                              <td>7-14 business days</td>
                           </tr>
                           <tr>
                              <td>Store Credit</td>
                              <td>1-2 business days</td>
                              <td>Immediate upon processing</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>

               <!-- Shipping Costs -->
               <div class="policy-section mb-50">
                  <h3 class="section-subtitle mb-25">Shipping Costs</h3>
                  <div class="shipping-info">
                     <div class="info-card mb-20">
                        <i class="fas fa-truck text-primary mr-3"></i>
                        <div>
                           <h5>Free Return Shipping</h5>
                           <p>We provide prepaid return shipping labels for all eligible returns within the United States.</p>
                        </div>
                     </div>
                     <div class="info-card mb-20">
                        <i class="fas fa-globe text-primary mr-3"></i>
                        <div>
                           <h5>International Returns</h5>
                           <p>International customers are responsible for return shipping costs. We recommend using a trackable shipping method.</p>
                        </div>
                     </div>
                     <div class="info-card mb-20">
                        <i class="fas fa-exclamation-triangle text-warning mr-3"></i>
                        <div>
                           <h5>Lost or Damaged Returns</h5>
                           <p>We're not responsible for items lost or damaged during return shipping. Please use appropriate packaging and insurance.</p>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Exchanges -->
               <div class="policy-section mb-50">
                  <h3 class="section-subtitle mb-25">Exchanges</h3>
                  <p class="mb-20">While we don't offer direct exchanges, you can return your item for a full refund and place a new order for the desired size, color, or style. This ensures you get exactly what you want and helps us process your request faster.</p>
                  <div class="exchange-tip p-20 bg-light rounded">
                     <i class="fas fa-lightbulb text-warning mr-2"></i>
                     <strong>Pro Tip:</strong> To ensure availability of your desired item, we recommend placing your new order first, then returning the unwanted item.
                  </div>
               </div>

               <!-- Contact Information -->
               <div class="policy-section">
                  <h3 class="section-subtitle mb-25">Questions About Returns?</h3>
                  <div class="contact-cards">
                     <div class="contact-card">
                        <i class="fas fa-envelope"></i>
                        <h5>Email Support</h5>
                        <p><a href="mailto:refunds@tinnityecom.com">refunds@tinnityecom.com</a></p>
                        <small>Response within 24 hours</small>
                     </div>
                     <div class="contact-card">
                        <i class="fas fa-phone"></i>
                        <h5>Phone Support</h5>
                        <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
                        <small>Mon-Fri 9AM-6PM EST</small>
                     </div>
                     <div class="contact-card">
                        <i class="fas fa-comments"></i>
                        <h5>Live Chat</h5>
                        <p>Available on website</p>
                        <small>Mon-Fri 9AM-8PM EST</small>
                     </div>
                  </div>
               </div>

               <!-- Last Updated -->
               <div class="policy-footer mt-60 pt-30 border-top">
                  <p class="text-muted small">
                     <strong>Last Updated:</strong> February 10, 2026<br>
                     This refund policy is subject to change without notice. Please check this page periodically for updates.
                  </p>
               </div>

            </div>
         </div>
      </div>
   </div>
</section>

<style>
.policy-highlight {
   background: #f8f9fa;
   border: 1px solid #e9ecef;
   border-radius: 10px;
   display: flex;
   align-items: flex-start;
}

.policy-highlight i {
   font-size: 1.5rem;
   margin-top: 5px;
}

.section-subtitle {
   color: #222;
   font-size: 1.5rem;
   font-weight: 600;
   border-bottom: 2px solid #007bff;
   padding-bottom: 10px;
}

.eligibility-item {
   display: flex;
   align-items: flex-start;
   padding: 15px;
   border-radius: 8px;
   transition: background-color 0.2s;
}

.eligibility-item.eligible {
   background: #f8fffe;
   border-left: 4px solid #28a745;
}

.eligibility-item.not-eligible {
   background: #fff5f5;
   border-left: 4px solid #dc3545;
}

.eligibility-item i {
   font-size: 1.2rem;
   margin-right: 15px;
   margin-top: 2px;
}

.step-item {
   display: flex;
   align-items: flex-start;
}

.step-number {
   background: #007bff;
   color: white;
   width: 40px;
   height: 40px;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   font-weight: bold;
   margin-right: 20px;
   flex-shrink: 0;
}

.step-content h5 {
   margin-bottom: 8px;
   color: #222;
}

.table {
   border-radius: 8px;
   overflow: hidden;
   box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th {
   background: #f8f9fa;
   font-weight: 600;
   border: none;
   padding: 15px;
}

.table td {
   padding: 15px;
   border-color: #e9ecef;
}

.info-card, .contact-card {
   display: flex;
   align-items: flex-start;
   padding: 20px;
   background: white;
   border-radius: 10px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.05);
   transition: transform 0.2s, box-shadow 0.2s;
}

.contact-card {
   text-align: center;
   flex-direction: column;
   align-items: center;
   margin-bottom: 20px;
}

.contact-card:hover {
   transform: translateY(-2px);
   box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.info-card i, .contact-card i {
   font-size: 1.5rem;
   margin-right: 15px;
   margin-top: 2px;
}

.contact-card i {
   margin-right: 0;
   margin-bottom: 15px;
   color: #007bff;
}

.contact-cards {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
   gap: 20px;
}

.exchange-tip {
   border-left: 4px solid #ffc107;
}

.policy-footer {
   text-align: center;
}

.text-success { color: #28a745 !important; }
.text-danger { color: #dc3545 !important; }
.text-primary { color: #007bff !important; }
.text-warning { color: #ffc107 !important; }
.text-muted { color: #6c757d !important; }

.mr-2 { margin-right: 0.5rem; }
.mr-3 { margin-right: 1rem; }
.mb-0 { margin-bottom: 0; }
.mb-10 { margin-bottom: 10px; }
.mb-20 { margin-bottom: 20px; }
.mb-25 { margin-bottom: 25px; }
.mb-30 { margin-bottom: 30px; }
.mb-50 { margin-bottom: 50px; }
.mt-60 { margin-top: 60px; }
.p-20 { padding: 20px; }
.p-30 { padding: 30px; }
.pt-30 { padding-top: 30px; }
.bg-light { background-color: #f8f9fa !important; }

@media (max-width: 768px) {
   .eligibility-item, .info-card {
      flex-direction: column;
      text-align: center;
   }
   
   .eligibility-item i, .info-card i {
      margin-right: 0;
      margin-bottom: 10px;
   }
   
   .step-item {
      flex-direction: column;
      text-align: center;
   }
   
   .step-number {
      margin-right: 0;
      margin-bottom: 15px;
   }
   
   .contact-cards {
      grid-template-columns: 1fr;
   }
}
</style>

<script>
// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
   const links = document.querySelectorAll('a[href^="#"]');
   
   links.forEach(link => {
      link.addEventListener('click', function(e) {
         e.preventDefault();
         const target = document.querySelector(this.getAttribute('href'));
         if (target) {
            target.scrollIntoView({
               behavior: 'smooth',
               block: 'start'
            });
         }
      });
   });
});
</script>
@endsection