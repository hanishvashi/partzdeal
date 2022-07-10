<div class="signup_form d-none mb-2">
<div class="row set-account-pass d-none mb-2">
  <div class="col-lg-12 mb-2">
  <h5 class="title">Create Account</h5>
  </div>
  <div class="col-lg-6">
    <input type="text" id="personal-name" class="form-control" name="personal_name" placeholder="Enter Your Name" value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->name : '' }}" {!! Auth::check() ? 'readonly' : '' !!}>
  </div>
  <div class="col-lg-6">
    <input type="email" id="personal-email" class="form-control" name="personal_email" placeholder="Enter Your Email" value="{{ Auth::guard('user')->check() ? Auth::guard('user')->user()->email : '' }}"  {!! Auth::check() ? 'readonly' : '' !!}>
  </div>
</div>
<div class="row set-account-pass d-none mb-2">
  <div class="col-lg-6">
    <input type="password" name="personal_pass" id="personal-pass" class="form-control" placeholder="Password">
  </div>
  <div class="col-lg-6">
    <input type="password" name="personal_confirm" id="personal-pass-confirm" class="form-control" placeholder="Confirm Password">
  </div>
</div>
<div class="col-lg-12  mt-3">
  <div class="bottom-area paystack-area-btn">
    <button type="button" id="customer_Signup" class="button">Signup</button>
  </div>
</div>
</div>
