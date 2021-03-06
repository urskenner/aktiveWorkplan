@if (count($errors) > 0)

    <div class="alert alert-danger">

        <ul>
            @foreach($errors -> all() as $error)
                <li style="margin-left: 10px">{{$error}}</li>
            @endforeach

        </ul>
    </div>
@endif


{{-- Meldung für den Fall das Erfolgreich geändert wurde --}}
@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {!! session('flash_notification.message') !!}
    </div>
@endif

<div id="signupbutton" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <!-- Modal header-->
            <div class="modal-header">

                <!-- Close Button oben rechts im Header -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <!-- Überschrift -->
                <h1 class="modal-ueberschrift">Sign up</h1>
                <br>

                <!-- Übersicht der Navigation die bei Vorschritt markiert weden -->
                <div class="modal-sub-sign-up">

                    <p class="col-xs-3 signin-head1" onclick="nextStep(1)">Basic</p>
                    <p class="col-xs-3 signin-head2" onclick="nextStep(2)">User</p>
                    <p class="col-xs-3 signin-head2" onclick="nextStep(3)">Company</p>
                    <p class="col-xs-3 signin-head2" onclick="nextStep(4)">Store</p>

                </div>


            </div>

            <!-- Modal body-->

            <form class="form-horizontal" method="POST" action="{{ url('/admin/register') }}"> {{ csrf_field() }}

                <div class="modal-body">

                    <!-- Basic-->
                    <div id="basic">
                        <!-- email-->
                        <br>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input id="overwrite-email" type="email" class="form-control" name="email" placeholder="E-Mail" value="{{ old('email') }}" >
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- email-ende -->

                        <!-- password1-->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input id="overwrite-pw1" type="password" class="form-control" name="password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- password1 ende-->

                        <!-- password2-->
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                            <div class="col-xs-12">
                                <input id="overwrite-pw2" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- password1 ende-->

                    </div>

                    <!-- User-->
                    <div id="user">
                        <br>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Surname">
                                @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('forename') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input type="text" class="form-control" name="forename"
                                       placeholder="Forename" value="{{ old('forename') }}">
                                @if ($errors->has('forename'))
                                    <span class="help-block"><strong>{{ $errors->first('forename') }}</strong></span>
                                @endif
                            </div>
                        </div>


                    </div>

                    <!-- Company-->
                    <div id="company">
                        <h3>Company Details</h3>

                        <div class="form-group{{ $errors->has('company-name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="company-name" placeholder="Company name"
                                       value="{{ old('company-name') }}">
                                @if ($errors->has('company-name'))
                                    <span class="help-block"><strong>{{ $errors->first('company-name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <h3>Company Headquarter Adress</h3>
                        <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="street" placeholder="Street"
                                       value="{{ old('street') }}">
                                @if ($errors->has('street'))
                                    <span class="help-block"><strong>{{ $errors->first('street') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('street_nr') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="street_nr" placeholder="Street Nr."
                                       value="{{ old('street_nr') }}">
                                @if ($errors->has('street_nr'))
                                    <span class="help-block"><strong>{{ $errors->first('street_nr') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="postcode" placeholder="Postcode"
                                       value="{{ old('postcode') }}">
                                @if ($errors->has('postcode'))
                                    <span class="help-block"><strong>{{ $errors->first('postcode') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        {{----}}

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="city" placeholder="City"
                                       value="{{ old('city') }}">
                                @if ($errors->has('city'))
                                    <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="country" placeholder="Country"
                                       value="{{ old('country') }}">
                                @if ($errors->has('country'))
                                    <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                @endif
                            </div>
                        </div>


                    </div>

                    <!-- Retail Store-->
                    <div id="store">
                        <h3>Store Details</h3>
                        <div class="form-group{{ $errors->has('store-name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" name="store-name" placeholder="Store name"
                                       value="{{ old('store-name') }}">
                                @if ($errors->has('store-name'))
                                    <span class="help-block"><strong>{{ $errors->first('store-name') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <h3>Store Adress</h3>


                        <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="street2" placeholder="Street"
                                       value="{{ old('street') }}">
                                @if ($errors->has('street'))
                                    <span class="help-block"><strong>{{ $errors->first('street') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('street_nr2') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="street_nr2" placeholder="Street Nr."
                                       value="{{ old('street_nr2') }}">
                                @if ($errors->has('street_nr2'))
                                    <span class="help-block"><strong>{{ $errors->first('street_nr2') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postcode2') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="postcode2" placeholder="Postcode"
                                       value="{{ old('postcode2') }}">
                                @if ($errors->has('postcode2'))
                                    <span class="help-block"><strong>{{ $errors->first('postcode2') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city2') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="city2" placeholder="City"
                                       value="{{ old('city2') }}">
                                @if ($errors->has('city2'))
                                    <span class="help-block"><strong>{{ $errors->first('city2') }}</strong></span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('country2') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="country2" placeholder="Country"
                                       value="{{ old('country2') }}">
                                @if ($errors->has('country2'))
                                    <span class="help-block"><strong>{{ $errors->first('country2') }}</strong></span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer footer4">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button id="back-button" class="form-control green-button" type="submit">Sign Up</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal footer-->

    </div>
</div>
<!--End Sign up-->

