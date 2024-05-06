<div class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-modal="true"
    role="dialog">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data" action="{{ route('master.products.uploads') }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel">Upload Product Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customer-name" class="col-form-label">Select Project</label>
                        <select class="form-control" required name="project_id">
                            <option value="">Selec Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->fld_pid }}"> {{ $project->fld_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <div>
                            <label for="formFile" class="form-label">Select Product Excel</label>
                            <input class="form-control" name="excel" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="col mt-7">
                        <div class="">
                            <div>
                                <label for="formFile" class="form-label">Product Append /Replace</label>
                            </div>
                            <div class="form-check form-switch form-check-inline" dir="ltr">

                                <input type="checkbox" name="aorr" value="1" class="form-check-input"
                                    id="inlineswitch5">
                                <label class="form-check-label" for="inlineswitch5"></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a target="_blank" href="/uploads/sample_products.csv" class="btn btn-info">Download Sample CSV</a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
