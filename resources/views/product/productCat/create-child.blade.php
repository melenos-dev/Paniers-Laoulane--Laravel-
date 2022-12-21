@extends('layouts.app')
    @section('title')
        Créer une sous-catégorie - Les paniers de Laoul'ane
    @endsection

    @section('middle')
        <div class="row">
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('productCat.create') }}">@lang('Categories management')</a>
                @foreach ($ariane as $category)
                    @php
                        echo $category
                    @endphp
                @endforeach
            </div>

            @if(session()->has('ok'))
                <script type="text/javascript">
                    $(function() {
                        $('.collapse').collapse();
                    });
                </script>
                <div class="alert alert-success alert-dismissible collapse mb-0">
                    {!! session('ok') !!}
                </div>
            @endif

            <div id="sidebar-left" class="col my-2">
                <h2>Mon compte <i class="fa-solid fa-person-shelter"></i></h2>

                <span>{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</span><br/>
                @if (Auth::user()->admin == 2)
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Website administration')</a><br/>
                @endif

                <h3>@lang('My shop')</h3>
                <div class="ariane">
                    <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('productCat.create') }}">@lang('Back to categories home')</a><br/>
                    <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('product.createWith', $parent->id) }}">@lang('Add a product in this category')</a>
                </div>
            </div>  

            <div class="col px-2 py-2">
                <div class="card">
                    <h2 class="card-title">@lang('Sub-categories in the category') {{ $parent->name }}</h2>

                    @if ($productCats)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productCats as $productCat)
                                    <tr>
                                        <td>{!! $productCat->id !!}</td>
                                        <td>
                                            <a href="{{ route('productCat.create.child', array($productCat->id, $productCat->name)) }}">{!! $productCat->name !!}</a> 
                                        </td>

                                        <td align="right" width="40px">
                                            @if (Auth::user()->admin == 2)
                                                <a href="{{ route('productCat.create.destroy', $productCat->id) }}" onclick="return confirm({{ '\''.__('Delete this category ? All categories and products located inside will be deleted too.').'\''}})" class="btn btn-danger btn-block">Supprimer</a>
                                            @endif
                                        </td>

                                        <td align="right" width="45px">
                                            <a href="{{ route('productCat.edit', $productCat->id) }}" class="btn btn-warning btn-block">Modifier</a>
                                        </td>   
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!!$links!!}
                    @else
                        <p class="alert alert-danger"> 
                            @lang('No sub-category has been created yet in') {{ $parent->name }}
                        </p>
                    @endif
                </div>
                @if ($errors->any())
                    <script type="text/javascript">
                        $(function() {
                            $('.collapse').collapse();
                        });
                    </script>

                    <div class="alert alert-danger collapse mt-1 mb-0">
                        {!! implode('', $errors->all('<span>:message</span><br/>')) !!}
                    </div>
                @endif

                {!! Form::open(['method'=>'POST', 'route'=>['productCat.store.child', array($parent->id, $parent->name)]]) !!}
                    {{ csrf_field() }}
                    {!! Form::text('name', null, ['class'=>'form-control mt-2 mb-2', 'id'=>'addCat', 'placeholder'=>__('New sub-category')]) !!}
                    {!! Form::submit('Ajouter', ['class'=>'btn']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @endsection