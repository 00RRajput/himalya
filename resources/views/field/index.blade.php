@extends('layouts.master')
@section('title')
    @lang('Custom Field')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang("Custom Field's") for {{ $project->fld_name }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-9">
            <div class="card" id="invoiceList">
                @if (session('success'))
                    <div class="m-3  alert bg-success alert-dismissible  show" id="alert-success" role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="sortable">
                                <thead class="text-muted">
                                    <tr class="ui-state-default">

                                        <th class="text-uppercase">#</th>
                                        <th class="text-uppercase">Question</th>
                                        <th class="text-uppercase">Ans /type</th>
                                        <th class="text-uppercase">Required</th>
                                        <th class="text-uppercase">Date</th>
                                        <th class="text-uppercase">Status</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($records as $key => $record)
                                        <tr class="ui-sortable-handle" id="{{ $record->fld_cfid }}">
                                            <td>
                                                {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="td">
                                                {{ $record->fld_question }}
                                                <p class="text-muted mb-0"> {{ $record->fld_placeholder }}</p>
                                            </td>
                                            <td class="td"> {{ $record->fld_ans }}
                                                <p class="text-muted mb-0"> {{ $record->type }}</p>
                                            </td>
                                            <td class="td"> {{ $record->required }}</td>

                                            <td class="td">
                                                {{ date(env('DATE_FORMAT'), strtotime($record->fld_created_at)) }}</td>
                                            <td class="td">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status" data-id={{ $record->fld_cfid }}
                                                        type="checkbox" role="switch" id="flexSwitchCheckChecked"
                                                        @checked($record->status == 'Active') name="status" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a class="btn-sm"
                                                        href="{{ route('custom-fields.edit', [$record->fld_cfid, 'pid' => $record->fld_pid]) }}"><i
                                                            class="ri-edit-line text-link"></i></a>
                                                    @if (in_array(Auth::user()->fld_role, [1, 3]))
                                                        <form onsubmit="return confirm('Do you really want to delete?');"
                                                            action="{{ route('custom-fields.destroy', $record->fld_cfid) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <div class="noresult">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                            style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                {{ $records->appends(request()->except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">
            @if (request()->route()->getName() === 'custom-fields.edit')
                @include('field.edit', ['project' => $project])
            @else
                @include('field.create')
            @endif

        </div>
    </div>

    <!--end row-->
@endsection


@section('script')
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {


            $(".status").change(function(e) {
                let fld_cfid = $(this).attr('data-id');
                let status = ($(this).is(':checked') === false) ? 0 : 1;
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                let additionalParam = {
                    status,
                    fld_cfid
                };
                $.ajax({
                    url: "/master/project/custom-fields/update-status",
                    type: "POST",
                    data: JSON.stringify(additionalParam),
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                    },
                    success: function(response) {
                        showSuccessMessage('Status has been updated');
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        showSuccessMessage(xhr.responseText);
                        // Handle error
                    }
                });

            })


            $("#fld_type").change(function() {
                let fld_type = $('#fld_type option:selected').val();

                if (fld_type == "R" || fld_type == "S") {
                    $("#fld_isnumeric_div").hide();
                    $("#radio_select_div").show();
                } else if (fld_type == "T") {
                    $("#radio_select_div").hide();
                    $("#fld_isnumeric_div").show();
                } else {
                    $("#fld_isnumeric_div").hide();
                    $("#radio_select_div").hide();
                }

            });


            $("#sortable tbody").sortable({
                cursor: "move",
                placeholder: "sortable-placeholder",

                update: function(event, ui) {
                    var order = $(this).sortable('toArray');
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    showSuccessMessage(' Please wait...');
                    $.ajax({
                        url: "{{ route('custom-fields.reorder') }}",
                        method: 'POST',

                        data: JSON.stringify(order),
                        contentType: "application/json",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Include CSRF token in request headers
                        },
                        success: function(response) {
                            showSuccessMessage(' Success! Your changes have been saved.');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

        });
    </script>
@endsection
