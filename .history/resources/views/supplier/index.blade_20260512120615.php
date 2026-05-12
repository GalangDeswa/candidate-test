@extends('layouts.master')

@section('content')

<div class="container-fluid p-3" x-data="{
        open : false
     }">

    {{-- Header --}}
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

    {{-- Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier List</h5>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total Layups</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>John Smith</td>
                                <td>12</td>
                                <td>2026-05-12</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    {{-- Modal Include --}}
    @include('supplier.add')

</div>

@endsection