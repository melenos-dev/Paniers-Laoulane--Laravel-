@extends('layouts.app')
    @section('title')
        @lang('Edit a product') - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Edit a product')</span>
            </div>
            <div id="sidebar-left" class="col">
                <h2 class="mb-2">@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                </div>
            </div>  

            <div class="col pb-0">
                <div class="card px-2 pb-2">
                    @if ($errors->any())
                        <script type="text/javascript">
                            $(function() {
                                $('.alert.collapse').collapse();
                            });
                        </script>

                        <div class="alert alert-danger collapse mt-1 mb-0">
                            {!! implode('', $errors->all('<span>:message</span><br/>')) !!}
                        </div>
                    @elseif (isset($error))
                        <script type="text/javascript">
                            $(function() {
                                $('.alert.collapse').collapse();
                            });
                        </script>

                        <div class="alert alert-danger collapse mt-1 mb-0">
                        <span>{!! $error !!}</span>
                        </div>
                    @endif
                    
                    {!! Form::model($product, ['method'=>'put', 'files' => true, 'route'=>['product.update', $product->id]]) !!}
                        {{ csrf_field() }}
                        {!! Form::text('product_name', null, ['class'=>'form-control mt-2 mb-2']) !!}
                        {!! Form::label('img', __('Change product picture ->')); !!}
                        {!! Form::file('img', ['class'=>'form-control mt-2 mb-2']) !!}<br/>

                        {!! Form::label('category_id', __('Category ').':'); !!}
                        <strong>{!! $product->productCat->name !!}</strong> 

                        <select name="category_id" class="form-control mt-2 mb-2">
                            @forelse($catParents as $row)
                                @if($loop->first)
                                    <option value="{{ $product->category_id }}">>  @lang('Change the category')</option>
                                @endif
                                <option value="{{ $row->id }}" style="font-weight: bold;">{{ $row->name }}</option>
                                @if($childs = $row->descendants()->whereDepth(1)->orderBy('created_at', 'asc')->get())
                                    @foreach($childs as $child)
                                        @include('product.productCat.childs_optionList', ['child' => $child, 'i' => '--', 'parent_id' => 0])
                                    @endforeach  
                                @endif

                                @empty
                                <option value="">@lang('No category. You must create one before you can add a product.')</option>
                            @endforelse
                        </select>
                        <div id="product_total_price" style="{!! ($product->product_total_price == '' && session()->getOldInput('product_total_price') == '') ? "display:none"  : '' !!}">
                        {!! Form::label('product_total_price', __('Total price')) !!}
                            {!! Form::text('product_total_price', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Price')]) !!}
                        </div>

                        <div id="product_price" style="{!! ($product->product_price == '' && session()->getOldInput('product_price') == '') ? "display:none"  : '' !!}">
                        {!! Form::label('product_price', __('Price per kg')) !!}
                            {!! Form::text('product_price', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Price per kg')]) !!}
                        </div>
                        {!! Form::label('switch_price', __('I prefer to set a price per kg')) !!}
                        <input name="switch_price" type="checkbox" value="{{ ($product->product_price != '') ? 'product_price' : 'product_total_price' }}" id="switch_price" {{ ($product->product_price != '') ? 'checked' : '' }}>
                        {!! Form::text('product_weight', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Weight')]) !!}
                        {!! Form::label('product_quantity', __('Quantity')) !!}<br/>
					    {!! Form::number('product_quantity', null, ['class'=>'form-control quantity mb-2', 'min'=>'0', 'max'=>'500', 'id'=>'product_quantity']) !!}<br/>
                        {!! Form::textarea('description', null, ['class'=>'form-control rounded px-md-3 py-md-3 me-5', 'placeholder'=>'Description']) !!}

                        {!! Form::submit(__('Edit'), ['class'=>'btn mt-2 btn__large']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('js/form.js') }}"></script>
    @endsection