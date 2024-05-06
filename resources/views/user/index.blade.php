@extends('layouts.master')
@section('title')
    @lang('Users')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="/dashboard"> @lang('Dashboards')</a>
        @endslot
        @slot('title')
            @lang('Users')
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
                <div class="card-header border-0">
                    <div class="d-flex flex-end">
                        <div class="flex-end">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                    <form action="{{ url('master/users') }}" method="GET">
                        <div class="row g-3">
                            <!--end col-->
                            <div class="col">
                                <select id="project_id" name="project_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">All Projects </option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->fld_pid }}" @selected(session('project_id') == $project->fld_pid || request('project_id') == $project->fld_pid)>
                                            {{ $project->fld_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="state_id" id="state_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('All States') </option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="fld_role" id="fld_role"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->fld_role }}" @selected(request('fld_role') == $role->fld_role)>
                                            {{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col">
                                <select name="user_id" id="user_id"
                                    class="form-control bg-light border-light flatpickr-input">
                                    <option value="">@lang('Users') </option>
                                </select>
                            </div> --}}
                            <!--end col-->
                            <div class="col">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="col  mr-1 btn btn-primary">Search</button>
                                    <a href="{{ route('users.index') }}" class="col  mr-1 btn btn-secondary ">Reset</a>

                                </div>
                            </div>

                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap" id="">
                                <thead class="text-muted">
                                    <tr>

                                        <th class="text-uppercase">ID</th>
                                        <th class="text-uppercase">Username</th>
                                        <th class="text-uppercase">State</th>
                                        <th class="text-uppercase">Project</th>
                                        <th class="text-uppercase">Status</th>
                                        <th class="text-uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="">
                                    @forelse ($records as $key => $record)
                                        <tr>
                                            <td>
                                                {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="td">{{ $record->fld_username }}
                                                <p class="text-muted mb-0">{{ $record->role_name }}</p>
                                            </td>
                                            <td class="td">{{ $record->state_name }}</td>
                                            <td class="td">{{ $record->project_name }}</td>
                                            <td class="td {{ $record->fld_status ? 'text-green' : 'bg-red' }}">
                                                {{ $record->fld_status ? 'Active' : 'Deactive' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('users.edit', $record->fld_uid) }}"><i
                                                            class="ri-edit-line"></i></a>
                                                    <form onsubmit="return confirm('Do you really want to delete?');"
                                                        action="{{ route('users.destroy', $record->fld_uid) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-submit  ri-delete-bin-line">
                                                        </button>
                                                    </form>

                                                </div>

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
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

                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-labelledby="deleteOrderLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                                    </lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a user ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your user will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close</button>
                                            <a href="" class="btn btn-danger" id="delete-record">Yes, Delete
                                                It</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>

        <div class="col-lg-3">

            @if (request()->route()->getName() === 'users.edit')
                @include('user.edit')
            @else
                @include('user.create')
            @endif

        </div>

    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/build/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var request_state_id = "{{ request('state_id') }}"
            var request_user_id = "{{ request('user_id') }}"
            getLoads();
            async function getLoads() {
                await getState();

            }

            $("#project_id").change(function() {
                getState();
            });


            async function getState() {
                let id = $('#project_id option:selected').val();
                if (id) {
                    (request_state_id) ?
                    $("#state_id").html('<option>loading....</option>'): '';
                    $.ajax({
                        url: `/get-project-wise-states/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All States </option>";
                            $.each(result, function(key, state) {
                                let selected = (state.fld_sid == request_state_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${state.fld_sid}' ${selected}> ${state.fld_state}</option>`
                            });

                            $("#state_id").html(html);

                        }
                    });
                }
            }

            function getUsers() {
                let id = $('#project_id option:selected').val();
                if (id) {
                    (request_user_id) ? $("#user_id").html('<option>loading....</option>'): '';

                    $.ajax({
                        url: `/getUsers/${id}`,
                        success: function(result) {
                            let html = "<option value='0'>All Field Users </option>";
                            $.each(result, function(key, user) {
                                let selected = (user.fld_uid == request_user_id) ?
                                    'selected' : '';
                                html +=
                                    `<option value='${user.fld_uid}' ${selected}> ${user.fld_usernme}</option>`
                            });

                            $("#user_id").html(html);

                        }
                    });


                }
            }


        });

        $(function() {
            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form[name='add_newuser']").validate({
                // Specify validation rules
                rules: {
                    fld_name: "required",
                    fld_username: "required",
                    fld_state_id: "required",
                    fld_district_id: "required",
                    fld_project_id: "required",
                    fld_role: "required",
                },
                // Specify validation error messages

                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
