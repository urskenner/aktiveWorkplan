<div class="modal-body">
    <form class="form-horizontal" method="POST" action="{{ url('/admin/login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

            <div class="col-xs-12">
                <input  type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

            <div class="col-xs-12">
                <input type="password" class="form-control" name="password" placeholder="Password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <button type="submit" class="form-control add-button">
                    Login
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 right">
                <a class="btn btn-link" href="{{ url('/admin/password/reset') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </form>
</div>

