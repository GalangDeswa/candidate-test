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
                            @forelse ($suppliers as $supplier)
                             <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                                
                            @empty
                                
                            @endforelse
                           
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    {{-- Modal Backdrop --}}
    <div class="modal fade" :class="open ? 'show d-block' : ''" tabindex="-1" x-show="open"
        style="background: rgba(0,0,0,0.5);">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        Create Supplier
                    </h5>

                    <button type="button" class="btn-close btn-close-white" @click="open = false"></button>

                </div>

                {{-- Form --}}
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">UID</label>

                                <input type="text" name="uid" class="form-control" placeholder="SUP-001">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Name</label>

                                <input type="text" name="name" class="form-control" placeholder="Supplier Name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact</label>

                                <input type="text" name="contact" class="form-control" placeholder="+62...">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Location</label>

                                <input type="text" name="location" class="form-control" placeholder="Medan">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Material Certificate
                                </label>

                                <select name="material_certificate" class="form-select">
                                    <option value="available">
                                        Available
                                    </option>

                                    <option value="not_available">
                                        Not Available
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Last Audit
                                </label>

                                <input type="date" name="last_audit" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status" class="form-select">
                                    <option value="active">
                                        Active
                                    </option>

                                    <option value="inactive">
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="col-6">
                                Layups
                            </div>

                            <div class="col-6">
                                  <button type="button" class="btn-close btn-close-white" @click="open = false"></button>
                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" @click="open = false">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Save Supplier
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection