@extends('layouts.app')
    @section('title')
        Administration - Les paniers de Laoul'ane
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

            @elseif (session('error'))
                <script type="text/javascript">
                    $(function() {
                        $('.alert.collapse').collapse();
                    });
                </script>

                <div class="alert alert-danger collapse mt-1 mb-3">
                    <span>{!! session('error') !!}</span>
                </div>
            @endif
            <div id="sidebar-left" class="col">
                <h2 class="mb-2">Administration <i class="fa-solid fa-hammer"></i></h2>
                <i class="fa-solid fa-arrow-right"></i> <a class="ms-0" href="{{ route('admin.customText.index') }}">@lang('The custom texts')</span></a><br/>
                <i class="fa-solid fa-arrow-right"></i> <a class="delete ms-0" href="{{ route('user.index') }}">@lang('Back to my account')</span></a>
                <h3 class="mt-1">@lang('Deliveries') <i class="fa-solid fa-truck"></i></h3>
                @if($deliveriesA)
                    @foreach($deliveriesA as $delivery)
                    @if ($loop->first)
                        <p class="alert alert-success latest">
                            @lang('Next delivery scheduled for') <span class="bold">{!! \Carbon\Carbon::parse($delivery->date)->translatedFormat('d M Y') !!}</span>
                            <i class="fa-solid fa-calendar-check"></i><a href="{{ route('admin.deleteDelivery', ['number' => $delivery->id]) }}" onclick="return confirm('Supprimer cette livraison ?')" class="delete" title="Supprimer"><i class="fa-solid fa-xmark"></i></a>
                        </p>  
                    @else   
                        <p class="alert alert-success mb-0">
                            <i class="fa-solid fa-arrow-rotate-left"></i> @lang('We were there on') <span class="bold">{!! \Carbon\Carbon::parse($delivery->date)->translatedFormat('d M Y') !!}</span>
                            <a href="{{ route('admin.deleteDelivery', ['number' => $delivery->id]) }}" onclick="return confirm('Supprimer cette livraison ?')" class="delete" title="Supprimer"><i class="fa-solid fa-xmark"></i></a>
                        </p>
                    @endif
                @endforeach
                
                @else
                <p class="alert alert-danger"> 
                    @lang('No delivery scheduled at this time.')
                </p>
                @endif
                @if ($errors->any())
                    <script type="text/javascript">
                        $(function() {
                            $('.alert.collapse').collapse();
                        });
                    </script>

                    <div class="alert alert-danger collapse">
                        {!! implode('', $errors->all('<span>:message</span><br/>')) !!}
                    </div>
                @endif
                {!! Form::open(['method'=>'POST', 'route'=>['admin.addDelivery']]) !!}
                    {{ csrf_field() }}
                    {!! Form::date('date', null, ['class'=>$errors->first('date', 'error ') .'form-control py-1 mb-3', 'placeholder'=>Date ('jj/mm/aaaa')]) !!}
                    {!! Form::submit('New date ! Ouiiii', ['class'=>'btn']) !!}
                {!! Form::close() !!}
            </div>  

            <div class="col pe-0">
                <div class="card">
                    <h2 class="card-title">@lang("Users list")</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{!! $user->id !!}</td>
                                    <td style="width:80%"><strong>{!! $user->firstname.' '.$user->lastname!!}</strong></td>
                                    <td>{!! link_to_route('admin.user.edit', __('Edit'), [$user->id], ['class'=>'btn btn-warning btn-block']) !!}</td>
                                    <td>
                                        {!! Form::open(['method'=>'DELETE', 'route'=>['admin.user.destroy', $user->id]]) !!}
                                            {{ csrf_field() }}
                                            {!! Form::submit(__('Delete'), ['class'=>'btn btn-danger btn-block', 'onclick'=>'return confirm(\''.__('Are you sure you want to delete this user ?').'\')']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!!$links!!}

                    {!! link_to_route('admin.user.create', __('Create a user'), [], ['class'=>'btn btn-info pull-right']) !!}
                </div>
            </div>
        </div>
    @endsection