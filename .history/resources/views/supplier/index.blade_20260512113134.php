@extends('layouts.master')

@section('content')

<div class="container-fliud p-3"    x-data="{
        open : false
     }">>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-medium m-0">Supplier</h4>
        </div>
        <div class="flex-grow-1 text-sm-end mt-2 mt-sm-0">
            <button type="button" class="btn btn-primary" @click="open = true">
                Add Supplier
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Datatable</h5>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total Layups</th>
                                <th>Created at</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Smith</td>
                                <td>Project Manager</td>
                                <td>Los Angeles</td>
                                <td>35</td>

                            </tr>



                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>


@endsection