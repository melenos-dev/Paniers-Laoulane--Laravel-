@extends('layouts.app')
    @section('title')
        @lang('Add a product') | Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row px-0">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('Add a product')</span>
            </div>

            @if(session()->has('ok'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>
                <div class="alert alert-success alert-dismissible collapse mb-0">
                    {!! session('ok') !!}
                </div>
            @endif

            <div id="sidebar-left" class="col">
                <h2 class="mb-2">@lang('My account') <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                </div>

                @if ($errors->any())
                    <script type="text/javascript">
                        $(function() {
                            $('.alert.collapse').collapse();
                        });
                    </script>

                    <div class="alert alert-danger collapse mt-1 mb-0">
                        {!! implode('', $errors->all('<span class="error">- :message</span>')) !!}
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
            </div>  

            <div class="col pb-0">
                <div class="card">
                    <h2 class="card-title">@lang('Add a product')</h2>
                    <div class="card-body">
                        {!! Form::open(['method'=>'POST', 'files' => true, 'route'=>['product.store']]) !!}
                            {{ csrf_field() }}
                            {!! Form::text('product_name', null, ['class'=>'form-control mt-2 mb-2', 'id'=>'addProduct', 'placeholder'=>__('Name')]) !!}
                            {!! Form::label('img', __('Product picture ->')); !!}
                            {!! Form::file('img', ['class'=>'form-control mt-2 mb-2', 'autocomplete' => 'img']) !!}<br/>
                        
                            <select name="category_id" class="form-control mt-2 mb-2">
                                @if($catParents)
                                    @foreach($catParents as $row)
                                        @if($loop->first)
                                            <option value="">>  @lang('Select the category')</option>
                                        @endif
                                        
                                        <option value="{{ $row->id }}" {{($row->id == old('category_id')) || request()->route('id') == $row->id ? 'selected' : ''}} style="font-weight: bold;">{{ $row->name }}</option>
                                        @if($childs = $row->descendants()->whereDepth(1)->orderBy('created_at', 'asc')->get())
                                            @foreach($childs as $child)
                                                @include('product.productCat.childs_optionList', ['child' => $child, 'i' => '--', 'parent_id' => 0])
                                            @endforeach  
                                        @endif
                                    @endforeach
                                @else
                                    <option value="">@lang('No category. You must create one before you can add a product.')</option>
                                @endif
                            </select>
                            <div id="product_total_price" style="{!! (session()->getOldInput('product_total_price') == '' && session()->getOldInput('product_price') != '') ? "display:none"  : '' !!}">
                                {!! Form::label('product_total_price', __('Total price')) !!}
                                {!! Form::text('product_total_price', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Price')]) !!}
                            </div>

                            <div id="product_price" style="{!! (session()->getOldInput('product_price') == '') ? "display:none"  : '' !!}">
                                {!! Form::label('product_price', __('Price per kg')) !!}
                                {!! Form::text('product_price', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Price per kg')]) !!}
                            </div>

                            {!! Form::label('switch_price', __('I prefer to set a price per kg')) !!}
                            <input name="switch_price" type="checkbox" value="{{ (session()->getOldInput('product_price') != '') ? 'product_price' : 'product_total_price' }}" id="switch_price" {{ (session()->getOldInput('product_price') != '') ? 'checked' : '' }} />
                            {!! Form::text('product_weight', null, ['class'=>'form-control mt-2 mb-2', 'placeholder'=>__('Weight')]) !!}
                            {!! Form::label('product_quantity', __('Quantity')) !!}<br/>
					        {!! Form::number('product_quantity', 1, ['class'=>'form-control quantity mb-2', 'min'=>'1', 'max'=>'500', 'id'=>'product_quantity']) !!}<br/>
                            {!! Form::textarea('description', null, ['class'=>'form-control rounded px-md-3 py-md-3 me-5', 'placeholder'=>'Description']) !!}

                            {!! Form::submit(__('Create'), ['class'=>'btn mt-2 btn__large']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('js/form.js') }}"></script>
    @endsection