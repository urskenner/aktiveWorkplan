<form method="POST" action="{{ url('/employee/alldayEventCreate') }}">
{{ csrf_field() }}

<!-- Modal body-->
    <!-- Basic-->
    <div class="modal-body">

        <!-- Zeile 1 -->
        <article class="row">
            <h2 style="display: none">fakeheading</h2>

            <!-- links -->
            <aside class="col-xs-12 col-sm-4 aside-left-add">Category</aside>

            <!-- rechts -->
            <aside class="col-xs-12 col-sm-8 aside-right">
                <p><select class="selectpicker form-control to-right modal-input space-cap" name="category">
                        @foreach($category as $cat)
                            <option>{{ $cat->name }}</option>
                        @endforeach
                    </select></p>
            </aside>

        </article>

        <!-- Zeile 2 -->
        <article class="row">
            <h2 style="display: none">fakeheading</h2>

            <!-- links -->
            <aside class="col-xs-12 col-sm-4 aside-left-add">Time</aside>

            <!-- rechts -->
            <aside class="col-xs-12 col-sm-8 aside-right">
                <p><input class="get-date-from-button-emp datepicker inputmodal form-control space-cap" type="date" name="date"
                          /></p>
            </aside>

        </article>

    </div>
    <!-- Modal footer-->
    <div>
        <button type="submit" class="form-control to-right add-button"
                name="thisDate"
                value="{{ $week[0]->format('d-m-Y') }}">Add
        </button>
    </div>

</form>