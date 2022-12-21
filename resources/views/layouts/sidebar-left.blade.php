        <div id="sidebar-left" class="col">
          <div class="delivery_block">
            <h2 class="pt-0 ps-0">@lang('Deliveries of our local products to the Lorient market') <i class="fa-solid fa-truck"></i></h2>
            <div>
              @if($deliveries->count() > 0)
                @foreach($deliveries as $delivery)
                  @if ($loop->first)
                    <p class="alert alert-success latest mb-2 mt-1">
                      @lang('Next delivery scheduled for') <span class="bold">{!! \Carbon\Carbon::parse($delivery->date)->translatedFormat('l j F Y') !!}</span> <i class="fa-solid fa-calendar-check"></i>
                    </p>  
                  @else
                    <p class="alert alert-success mb-0 pb-0 mt-2">
                      <i class="fa-solid fa-arrow-rotate-left"></i></i> @lang('We were there on') <span class="bold">{!! \Carbon\Carbon::parse($delivery->date)->translatedFormat('l j F Y') !!}</span>
                    </p>
                  @endif
                @endforeach
              @else
                <p class="alert alert-danger"> 
                  @lang('No delivery scheduled at this time.')
                </p>
              @endif
            </div>
          </div>

          <div class="categories mt-2">
            <h2>@lang('The categories')</h2>
            @if($categories->count() > 0)
                <ul>
                  @foreach($categories as $category)
                    <li>
                      <a class="parent" href="{{ route('productCat.index', array($category->id, $category->slug)) }}">{{ $category->name }}</a>
                      @if($childs = $category->descendants()->whereDepth(1)->orderBy('created_at', 'asc')->get())
                        <ul>
                          @foreach($childs as $child)
                            @include('product.productCat.childs', ['child' => $child])
                          @endforeach  
                        </ul>
                      @endif
                    </li>
                  @endforeach
                </ul>
            @else
                <p class="alert alert-danger"> 
                  @lang('No category has been created yet').
                </p>
            @endif
          </div>

          <div class="suppliers mt-2">
              <h2>@lang('Our local producers')</h2>
              @if($suppliers->count() > 0)
                @foreach($suppliers as $supplier)
                  <div>
                    <a title="@lang('More info about') {{$supplier->supplier_name}}" href="{{route('who.getById', $supplier->id)}}">
                      <span>{{ $supplier->supplier_name }}</span>
                      <img src="{{asset('uploads/suppliers/'.$supplier->img)}}"/>
                    </a>
                  </div>
                @endforeach
              @else
                <p class="alert alert-danger"> 
                  @lang('No producer has been created at this time').
                </p>
              @endif
          </div>
        </div> 
        