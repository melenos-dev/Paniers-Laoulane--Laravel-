@extends('layouts.app')
    @section('title')
        @lang('The custom texts') - Les paniers de Laoul'ane
    @endsection
    
    @section('middle')
        <div class="row me-0 ml-0">
            @if(session()->has('ok'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>
                <div class="alert alert-success alert-dismissible collapse" style="margin-bottom:15px">
                    {!! session('ok') !!}
                </div>
            @endif
            <div class="ariane">
                <a href="{{ route('user.index') }}">@lang('My account')</span></a> <i class="fa-solid fa-arrow-right"></i> <a href="{{ route('admin') }}">@lang('Administration')</span></a> <i class="fa-solid fa-arrow-right"></i> <span class="active">@lang('The custom texts')</span>
            </div>
            <div id="sidebar-left" class="col">
                <h2 class="mb-2">Administration <i class="fa-solid fa-hammer"></i></h2>
                <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('admin') }}">@lang('Back to administration')</span></a><br/>
                <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
            </div>  

            <div class="col pe-0">
                <div class="card">
                    <h2 class="card-title">@lang('The custom texts')</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Texte')</th>
                                <th>@lang('Translation')</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customTexts as $customText)
                                <tr>
                                    <td>{{ $customText->id }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($customText->text, 70, '...') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($customText->translation, 70, '...') }}</td>
                                    <td>{!! link_to_route('admin.customText.edit', __('Edit'), [$customText->id], ['class'=>'btn btn-warning btn-block']) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection