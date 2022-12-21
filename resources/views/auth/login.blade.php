@if(Request::routeIs('login'))
  <script>window.location = "{{ route('user.index', app()->getLocale()) }}";</script>
@endif
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="form-title text-center">
          <span class="title">@lang('Sign in')</span>
        </div>
        <div class="d-flex flex-column text-center">
          <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <input id="email" type="email" placeholder="E-mail" class="form-control @error('auth.email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div class="form-group">
              <input id="password" type="password" placeholder="@lang('Password')" class="form-control @error('auth.email') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('auth.email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
            <div class="form-group">
               <input class="form-check-input" style="margin-top:0.20em" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label ps-2" for="remember">
                    @lang('Stay logged in')
                </label>
            </div>
            <button type="submit" class="btn btn-info btn-block btn-round btn__large mb-2">@lang('Login')</button>
            <a href="{{ route('password.request') }}">@lang('Forgot your password ?')</a>
          </form>
        </div>
      </div>
      
      <div class="modal-footer d-flex justify-content-center">
        <div class="signup-section">@lang('Not registered yet ?') <a href="{{ route('auth.register') }}" class="text-info">@lang('Subscribe')</a>.</div>
      </div>
    </div>
  </div>
</div>