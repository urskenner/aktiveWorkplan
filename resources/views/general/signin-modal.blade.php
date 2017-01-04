<!--Start Sign in-->
<!-- wird über Button click im header (Sign in) aufgerufen -->
<div id="signinbutton" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <!-- Modal header-->
            <div class="modal-header">

                <!-- Close Button oben rechts im Header -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <!-- Überschrift -->
                <h1>Sign in</h1>


                <div class="modal-sub">

                    <p class="col-xs-6 signin-head1" onclick="nextStep(4)">Employee</p>
                    <p class="col-xs-6 signin-head2" onclick="nextStep(5)">Admin</p>

                </div>

                <br>

                <!-- Übersicht der Navigation die bei Fortschritt markiert weden -->
            </div>

            <!-- Modal body-->
            <!-- Basic-->

            <!-- JavaScript Methoden in SignUp.Js-->
            <div class="modal-body">
                <div id="modal-body-admin">
                    @include('admin.auth.login')
                </div>

                <div id="modal-body-emp">
                @include('employee.auth.login')
                </div>
            </div>
        </div>
    </div>
</div>


