 <!-- modal -->

 <div class="modal fade contact-us-modal" id="contact_us" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <div class="contact-card">
                     <div class="contact-head">
                         <h6>{{ translate('Contact Us') }}</h6>
                         <p>
                             {{ translate('If you need to enter the world of commerce and become one of the top merchants, get an online store and achieve the highest sales and profits, subscribe with us') }}
                         </p>
                     </div>
                     <div class="contact-us-form">
                         <form class="w-100" action="{{ route('landing.submit') }}" method="POST" id="demo-form-2">
                             @csrf
                             <div class="from-group">
                                 <div class="from-box">
                                     <label>
                                         {{ translate('name') }}
                                     </label>
                                     <input type="text" class="form-control" name="name" required>
                                     @error('name')
                                         <span class="text-danger">{{ $message }}</span>
                                     @enderror
                                 </div>
                             </div>

                             <div class="from-group">
                                 <div class="from-box">
                                     <label>
                                         {{ translate('E-mail') }}
                                     </label>
                                     <input type="email" class="form-control" name="email" required>
                                     @error('email')
                                         <span class="text-danger">{{ $message }}</span>
                                     @enderror
                                 </div>
                             </div>

                             <div class="from-group">
                                 <div class="from-box">
                                     <label>
                                         {{ translate('Phone') }}
                                     </label>
                                     <div class="phone-box">
                                         <input type="text" class="form-control phone-input phone-input-modal"
                                             name="contact_number" required>
                                         @error('contact_number')
                                             <span class="text-danger">{{ $message }}</span>
                                         @enderror
                                     </div>
                                 </div>
                             </div>

                             <div class="from-group">
                                 <div class="from-box">
                                     <label>
                                         {{ translate('Store Type') }}
                                     </label>
                                     <select class="form-control" title="تصنيف المتجر" required name="shop_type">
                                         <option selected></option>
                                         <option value="Vendor">{{ translate('Single Vendor') }}</option>
                                         <option value="Mulit Vendor">{{ translate('Mutlipe Vendors') }}</option>
                                         {{-- <option value="">تصنيف 4</option> --}}
                                     </select>

                                     @error('shop_type')
                                         <span class="text-danger">{{ $message }}</span>
                                     @enderror
                                 </div>
                             </div>


                             <div class="contact-btn">
                                 <button class="btn main-btn" type="submit" class="btn btn-primary">
                                     <span>{{ translate('submit') }}</span>
                                 </button>
                             </div>


                         </form>
                     </div>
                 </div>
             </div>

             <div class="contact-us-pattern">
                 <img src="{{ asset('assets/landing-assets/img/successfully-pattern.png') }}" alt=""
                     class="img-fluid">
             </div>

         </div>
     </div>
 </div>
