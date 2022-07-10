<!-- Classic tabs -->
<div class="classic-tabs border rounded mt-5 pt-1">

  <ul class="nav tabs-primary nav-justified" id="advancedTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active show" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Disclaimer</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{count($product->reviews)}})</a>
    </li>
  </ul>
  <div class="tab-content" id="advancedTabContent">
    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
      <h5>Product Description</h5>
      <p class="pt-1">{!! $product->description !!}</p>
    </div>
    <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
      <h5>Disclaimer</h5>
      <p class="pt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, sapiente illo. Sit
        error voluptas repellat rerum quidem, soluta enim perferendis voluptates laboriosam. Distinctio,
        officia quis dolore quos sapiente tempore alias.</p>
    </div>
    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
      <h5>Product Reviews</h5>

      @if(Auth::guard('user')->check())

          @if(Auth::guard('user')->user()->orders()->count() > 0)
          <h1 class="heading_three mb-4">{{$lang->fpr}}</h1>
          <hr>
          @include('includes.form-success')
          <div class="product-reviews">
              <div class="review-star">
                <div class='starrr' id='star1'></div>
                  <div>
                      <span class='your-choice-was' style='display: none;'>
                        {{$lang->dofpl}}: <span class='choice'></span>.
                      </span>
                  </div>
              </div>
          </div>
          <form class="product-review-form" action="{{route('front.review.submit')}}" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{Auth::guard('user')->user()->id}}">
              <input type="hidden" name="rating" id="rate" value="5">
              <input type="hidden" name="product_id" value="{{$product->id}}">
              <div class="form-group">
                  <textarea name="review" id="" rows="5" placeholder="{{$lang->suf}}" class="form-control" style="resize: vertical;" required></textarea>
              </div>
              <div class="form-group text-center">
                  <input name="btn" type="submit" class="btn-review" value="Submit Review">
              </div>
          </form>
          @else

          @endif
          <hr>
          @forelse($product->reviews as $review)
              <div class="review-rating-description">
                  <div class="row">
                    <div class="col-md-3 col-sm-3">
                      <p>{{$review->user->name}}</p>
                      <p class="product-reviews">
                        <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                        </div>
                      </p>
                      <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                    </div>
                    <div class="col-md-9 col-sm-9">
                      <p>{{$review->review}}</p>
                    </div>
                  </div>
              </div>
              @empty
              <div class="row">
                  <div class="col-md-12">
                      <h4>{{$lang->md}}</h4>
                  </div>
              </div>
              @endforelse

          @else

              @forelse($product->reviews as $review)
              <div class="review-rating-description">
                  <div class="row">
                    <div class="col-12 col-md-3">
                      <p>{{$review->user->name}}</p>
                      <p class="product-reviews">
                        <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                        </div>
                    </p>
                      <p>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans()}}</p>
                    </div>
                    <div class="col-12 col-md-9">
                      <p>{{$review->review}}</p>
                    </div>
                  </div>
              </div>
              @empty
              <div class="row">
                  <div class="col-md-12">
                      <h4>{{$lang->md}}</h4>
                  </div>
              </div>
          @endforelse
      @endif


    </div>
  </div>

</div>
<!-- Classic tabs -->
