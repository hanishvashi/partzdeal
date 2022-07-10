<section id="home_newsLetter" class="">
            <ul class="step_list">
              <li>
                <span>Subscribe for Our Newsletter:</span>
              </li>
            </ul>
            <form action="{{route('front.subscribe.submit')}}" method="POST" class="newsLetter_form mt-4">
{{csrf_field()}}
              <div class="input-group">
                <input required type="email" name="email" id="subscribe_email" class="form-control" placeholder="Your email address">
                <div class="input-group-append">
 <button type="submit" class="input-group-text form-control-feedback"><span class="fa fa-paper-plane-o"></span></button>
                </div>
              </div>
            </form>
    </section>
