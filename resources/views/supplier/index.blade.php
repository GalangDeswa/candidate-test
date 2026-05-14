@extends('layouts.master')

@section('content')

<div class="header-wrapper">
    <div class="page-header-bg">
        <div class="container-fluid p-2">
            <div class="row page-title clearfix p-3">

                <h1>
                    Supplier
                </h1>
                <div class="page-title-right">
                    <ol class="breadcrumb custom-breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Supplier</li>

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid overlap-cards">

        <div x-data="{
                addSupplierModal: false,
                detailSupplierModal: false,

                detailData :{},
                importModal :false,
            }">

            {{-- Header --}}
            <div class="py-3 d-flex align-items-center">




                <div class="d-flex gap-2 ms-auto">

                    <!-- Add Supplier -->
                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center"
                        @click="addSupplierModal = true" title="Add Supplier">
                        <i class="fa-solid fa-plus me-1"></i>
                        <span>Add Supplier</span>
                    </button>

                    <!-- Import Supplier -->
                    <button type="button" class="btn btn-info btn-sm d-flex align-items-center"
                        @click="importModal = true" title="Import Supplier">
                        <i class="fa-solid fa-file-import me-1"></i>
                        <span>Import</span>
                    </button>

                    <!-- Export Supplier -->
                    <a href="{{ route('supplier.export') }}" class="btn btn-info btn-sm d-flex align-items-center"
                        title="Export Supplier">
                        <i class="fa-solid fa-file-export me-1"></i>
                        <span>Export</span>
                    </a>

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
                            <div class="table-responsive border rounded">

                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Total Layups</th>
                                            <th>Created At</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $supplier->uid }}</td>
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->layups->count() }}</td>
                                            <td>{{ $supplier->created_at }}</td>
                                            <td>{{ $supplier->status }}</td>
                                            <td>
                                                {{-- <button class="btn btn-info btn-sm"
                                                    @click="detailSupplierModal = true; detailData = {{ $supplier }};">
                                                    show
                                                </button> --}}


                                                <a href="{{ route('supplier.show', $supplier) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <form action="{{ route('supplier.destroy', $supplier) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this supplier?')"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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
            </div>

            {{-- Modal Backdrop --}}
            <div x-transition class="modal fade" :class="addSupplierModal ? 'show d-block' : ''" tabindex="-1"
                x-show="addSupplierModal"
                style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1040;">


                <div class="modal-dialog modal-lg modal-dialog-centered">

                    <div class="modal-content">

                        {{-- Header --}}
                        <div class="modal-header bg-primary text-white">

                            <h5 class="modal-title">
                                Create Supplier
                            </h5>

                            <button type="button" class="btn-close btn-close-white"
                                @click="addSupplierModal = false"></button>

                        </div>

                        <div x-data="{
                    loading :false,
                    check : false,

                      form: $form('post', '/supplier', {
                             name: '',
                             contact: '',
                             location: '',
                             status: 'active',
                             material_certificate: '',
                             last_audit: '',
                        }),

                        submitForm() {
                            this.loading = true;
                            this.form.submit().then(response => {
                                this.handleSuccess(response);
                                })
                                .catch(error => {
                                  this.loading = false;
                                         console.log(error);
                                                            if (error.response?.data?.errors) {
                                                                 console.log('Server validation errors:', error.response.data.errors);
                                                                 console.log('Precognition form.errors:', this.form.errors);
                                                                                    
                                                             }
                                    });
                        },

                        handleSuccess(response) {
                                                  
                            window.location.reload();
                            this.loading = false;
                                                },



                }">


                            <form @submit.prevent="submitForm()">
                                @csrf

                                <div class="modal-body">

                                    <div class="row g-3">

                                        {{-- <div class="col-md-6">
                                            <label class="form-label">UID</label>

                                            <input type="text" name="uid" class="form-control" placeholder="SUP-001">
                                        </div> --}}

                                        <div class="col-md-4">
                                            <label class="form-label">Name</label>

                                            <input x-model="form.name" type="text" name="name" class="form-control"
                                                placeholder="Supplier Name">
                                            <template x-if="form.invalid('name')">
                                                <div class="error-text" x-text="form.errors.name"></div>
                                            </template>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Contact</label>

                                            <input x-model="form.contact" type="text" name="contact"
                                                class="form-control" placeholder="+62...">
                                            <template x-if="form.invalid('contact')">
                                                <div class="error-text" x-text="form.errors.contact"></div>
                                            </template>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Location</label>

                                            <input x-model="form.location" type="text" name="location"
                                                class="form-control" placeholder="Jakarta">
                                            <template x-if="form.invalid('location')">
                                                <div class="error-text" x-text="form.errors.location"></div>
                                            </template>

                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">
                                                Last Audit
                                            </label>

                                            <input x-model="form.last_audit" type="date" name="last_audit"
                                                class="form-control">
                                        </div>



                                        <div class="col-md-4">
                                            <label class="form-label">
                                                Material Certificate
                                            </label>



                                            <select x-model="check" name="material_certificate" class="form-select">
                                                <option value="true">
                                                    Available
                                                </option>

                                                <option value="false">
                                                    Not Available
                                                </option>
                                            </select>
                                        </div>




                                        <div class="col-md-4" x-show="check == 'true'" x-cloak>
                                            <label class="form-label">
                                                Material Certificate
                                            </label>


                                            <input placeholder="IS0-1234" x-model="form.material_certificate"
                                                name="material_certificate" class="form-control">

                                        </div>



                                        <div class="col-md-4">
                                            <label class="form-label">
                                                Status
                                            </label>

                                            <select x-model="form.status" name="status" class="form-select">
                                                <option value="active">
                                                    Active
                                                </option>

                                                <option value="inactive">
                                                    Inactive
                                                </option>
                                            </select>
                                            <template x-if="form.invalid('status')">
                                                <div class="error-text" x-text="form.errors.status"></div>
                                            </template>
                                        </div>


                                    </div>

                                </div>


                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" @click="addSupplierModal = false">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        <template x-if="loading">
                                            <span class="btn-spinner mr-2" role="status" aria-hidden="true"></span>
                                        </template>
                                        <span x-text="loading ? 'Saving...' : 'Save'"></span>
                                    </button>

                                </div>

                            </form>


                        </div>

                    </div>

                </div>

            </div>


            {{-- Modal Backdrop --}}


            <template x-if="detailSupplierModal">
                <div x-data="{detailData}">
                    <div x-transition class="modal fade" :class="detailSupplierModal ? 'show d-block' : ''"
                        tabindex="-1" x-show="detailSupplierModal"
                        style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1040;">


                        <div class="modal-dialog modal-lg">

                            <div class="modal-content">

                                {{-- Header --}}
                                <div class="modal-header bg-primary text-white">

                                    <h5 class="modal-title" x-text="detailData.name">

                                    </h5>
                                    <h6 x-text="detailData.status">

                                    </h6>

                                    <button type="button" class="btn-close btn-close-white"
                                        @click="detailSupplierModal = false"></button>

                                </div>

                                <div x-data="{
                                    loading :false,
                                    check : detailData.material_certificate != null? 'true' : 'false',


                                }">




                                    <div class="modal-body">

                                        <div class="row g-3">



                                            <div class="col-md-4">
                                                <label class="form-label">Name</label>

                                                <input x-model="detailData.name" type="text" name="name"
                                                    class="form-control" placeholder="Supplier Name">

                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Contact</label>

                                                <input x-model="detailData.contact" type="text" name="contact"
                                                    class="form-control" placeholder="+62...">

                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Location</label>

                                                <input x-model="detailData.location" type="text" name="location"
                                                    class="form-control" placeholder="Medan">


                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    Last Audit
                                                </label>

                                                <input x-model="detailData.last_audit" type="date" name="last_audit"
                                                    class="form-control">
                                            </div>



                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    Material Certificate
                                                </label>



                                                <select x-model="check" name="material_certificate" class="form-select">
                                                    <option value="true">
                                                        Available
                                                    </option>

                                                    <option value="false">
                                                        Not Available
                                                    </option>
                                                </select>
                                            </div>




                                            <div class="col-md-4" x-show="check == 'true'" x-cloak>
                                                <label class="form-label">
                                                    Material Certificate
                                                </label>


                                                <input x-model="detailData.material_certificate"
                                                    name="material_certificate" class="form-control">

                                            </div>



                                            <div class="col-md-12">
                                                <label class="form-label">
                                                    Status
                                                </label>

                                                <select x-model="detailData.status" name="status" class="form-select">
                                                    <option value="active">
                                                        Active
                                                    </option>

                                                    <option value="inactive">
                                                        Inactive
                                                    </option>
                                                </select>

                                            </div>


                                        </div>

                                    </div>

                                    {{-- Footer --}}
                                    {{-- <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary"
                                            @click="addSupplierModal = false">
                                            Cancel
                                        </button>

                                        <button type="submit" class="btn btn-primary">
                                            Save Supplier
                                        </button>

                                    </div> --}}




                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </template>


            <div x-transition class="modal fade" :class="importModal ? 'show d-block' : ''" tabindex="-1"
                x-show="importModal"
                style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1040;">

                <div class="modal-dialog modal-lg  modal-dialog-centered" style="min-width: 70vw;">

                    <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">


                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                Import Supplier
                            </h5>

                            <button type="button" class="btn-close btn-close-white" @click="importModal = false">
                            </button>
                        </div>



                        <div class="modal-body">

                            <form x-data="importChecker({
                        checkUrl: '{{ route('supplier.import.check') }}',
                        commitUrl: '{{ route('supplier.import.commit') }}',
                        csrfToken: '{{ csrf_token() }}'
                    })" enctype="multipart/form-data" @submit.prevent="commitImport">

                                @csrf


                                <label for="fileInput"
                                    class="w-100 border border-2 border-dashed rounded-2 p-2 text-center transition-all"
                                    :class="dragging
                            ? 'border-primary bg-primary bg-opacity-10 shadow-sm'
                            : 'border-secondary-subtle bg-light'" @dragover.prevent="dragging = true"
                                    @dragleave.prevent="dragging = false" @drop.prevent="
                            dragging = false;

                            const file = $event.dataTransfer.files[0];

                            $refs.file.files = $event.dataTransfer.files;

                            processFile(file);
                            " style="cursor: pointer; min-height: 100px; display:flex; align-items:center; justify-content:center;">

                                    <div>

                                        <div class="mb-3" style="font-size: 60px;">
                                            <i class="fa-solid fa-file"></i>
                                        </div>

                                        <h4 class="fw-bold mb-2 text-dark">
                                            Drag & Drop Excel File
                                        </h4>

                                        <p class="text-muted mb-3">

                                            <span> Drop your .xlsx or .xls file here</span>
                                        </p>

                                        <div class="row">

                                            <div class="col-12 mb-4">
                                                <a href="/assets/format.xlsx" class="fw-bold" download>
                                                    <i class="fa-solid fa-download"></i>
                                                    Download Excel template here
                                                </a>
                                            </div>

                                            <div class="col-12">
                                                <button @click="$refs.file.click()" type="button"
                                                    class="btn btn-outline-primary rounded-pill px-4">
                                                    Browse File
                                                </button>
                                            </div>

                                        </div>





                                        <template x-if="fileName">
                                            <div class="mt-4">
                                                <span class="badge bg-success px-3 py-2 fs-6">
                                                    <span x-text="fileName"></span>
                                                </span>
                                            </div>
                                        </template>

                                    </div>
                                </label>


                                <input type="file" name="file" id="fileInput" class="d-none" accept=".xlsx,.xls,.csv"
                                    x-ref="file" @change="
                                    processFile($event.target.files[0])
                                ">

                                <template x-if="loading">

                                    <div class="alert alert-info mt-4">

                                        Checking import file...

                                    </div>

                                </template>

                                <template x-if="analysis">

                                    <div class="mt-5">

                                        <div class="d-flex align-items-center justify-content-between mb-4">

                                            <div>
                                                <h4 class="fw-bold mb-1">
                                                    Import Analysis
                                                </h4>
                                                <span x-text="fileName"></span>


                                            </div>

                                            <div class="d-flex gap-2">



                                                <template x-if="analysis.conflicts.length <=0 ">
                                                    <div class="badge bg-primary-subtle text-black  border">
                                                        <span></span>
                                                        Import successfull
                                                    </div>

                                                </template>


                                                <template x-if="analysis.conflicts.length > 0 ">

                                                    <div class="badge bg-danger-subtle text-danger border">
                                                        <span x-text="analysis.conflicts.length"></span>
                                                        Conflicts
                                                    </div>

                                                </template>



                                            </div>

                                        </div>

                                        <template x-if="analysis.conflicts.length">

                                            <div class="col-12 mb-3">

                                                <label class="form-label fw-semibold">
                                                    Resolve All Conflicts
                                                </label>

                                                <select class="form-select" x-model="globalConflictResolution">
                                                    <option value="skip">
                                                        Skip All Conflicts
                                                    </option>

                                                    <option value="overwrite">
                                                        Overwrite All Data
                                                    </option>

                                                    <option value="duplicate">
                                                        Duplicate All Data
                                                    </option>

                                                    <option value="manual">
                                                        Manual Resolve
                                                    </option>
                                                </select>

                                                <div class="form-text">

                                                    Applies the selected action to every detected conflict.

                                                </div>

                                            </div>

                                        </template>

                                        <template
                                            x-if="analysis.conflicts.length && globalConflictResolution === 'manual'">

                                            <div class="mt-4">

                                                <template x-for="conflict in analysis.conflicts" :key="
                                        conflict.uid
                                        ?? (
                                            conflict.layup_uid + '-' + conflict.layer_order
                                        )
                                    ">

                                                    <div class="card mb-3">

                                                        <div class="card-body">

                                                            <div class="border rounded p-3 bg-white">

                                                                <div
                                                                    class="d-flex align-items-center justify-content-between mb-2">

                                                                    <div class="fw-semibold">

                                                                        <span x-text="conflict.type"></span>

                                                                        <template x-if="conflict.incoming?.layup_uid">
                                                                            <span class="text-muted">
                                                                                ·
                                                                                <span
                                                                                    x-text="conflict.incoming.layup_uid"></span>
                                                                            </span>
                                                                        </template>

                                                                    </div>

                                                                    <span class="badge"
                                                                        :class="badgeClass(conflict.type)"
                                                                        x-text="conflict.type"></span>

                                                                </div>

                                                                <div class="small text-muted mb-2"
                                                                    x-text="conflict.message || 'Data conflict detected'">
                                                                </div>

                                                                <template x-if="conflict.differences">

                                                                    <div class="table-responsive">

                                                                        <table class="table table-sm align-middle mb-0">

                                                                            <thead class="table-light">

                                                                                <tr>
                                                                                    <th>Field</th>
                                                                                    <th>Database</th>
                                                                                    <th>Incoming</th>
                                                                                </tr>

                                                                            </thead>

                                                                            <tbody>

                                                                                <template
                                                                                    x-for="(diff, field) in conflict.differences">

                                                                                    <tr>

                                                                                        <td class="fw-semibold"
                                                                                            x-text="field">
                                                                                        </td>

                                                                                        <td class="text-danger"
                                                                                            x-text="diff.database">
                                                                                        </td>

                                                                                        <td class="text-success"
                                                                                            x-text="diff.incoming">
                                                                                        </td>

                                                                                    </tr>

                                                                                </template>

                                                                            </tbody>

                                                                        </table>

                                                                    </div>

                                                                </template>

                                                            </div>

                                                            <select class="form-select" x-model="
                                                                resolutions[
                                                                    conflict.uid
                                                                    ?? (
                                                                         conflict.incoming.layup_uid
                                                                        + '-'
                                                                        + conflict.layer_order
                                                                    )
                                                                ]
                                                            ">
                                                                <option value="skip">
                                                                    Skip Conflict
                                                                </option>

                                                                <option value="overwrite">
                                                                    Overwrite Data
                                                                </option>

                                                                <option value="duplicate">
                                                                    Duplicate Data
                                                                </option>


                                                            </select>

                                                        </div>

                                                    </div>

                                                </template>

                                            </div>

                                        </template>




                                        <template x-if="analysis.conflicts.length">



                                            <div class="accordion bg-warning-subtle">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#conflict"
                                                            aria-expanded="false" aria-controls="conflict">
                                                            <div class="fw-bold mb-3">
                                                                Detected Conflicts
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="conflict" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="d-flex flex-column gap-3">

                                                                <template x-for="(item, index) in analysis.conflicts "
                                                                    :key="index">

                                                                    <div class="border rounded p-3 bg-white">

                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between mb-2">

                                                                            <div class="fw-semibold">

                                                                                <span x-text="item.type"></span>

                                                                                <template
                                                                                    x-if="item.incoming?.layup_uid">
                                                                                    <span class="text-muted">
                                                                                        ·
                                                                                        <span
                                                                                            x-text="item.incoming.layup_uid"></span>
                                                                                    </span>
                                                                                </template>

                                                                            </div>

                                                                            <span class="badge"
                                                                                :class="badgeClass(item.type)"
                                                                                x-text="item.type"></span>

                                                                        </div>

                                                                        <div class="small text-muted mb-2"
                                                                            x-text="item.message || 'Data conflict detected'">
                                                                        </div>

                                                                        <template x-if="item.differences">

                                                                            <div class="table-responsive">

                                                                                <table
                                                                                    class="table table-sm align-middle mb-0">

                                                                                    <thead class="table-light">

                                                                                        <tr>
                                                                                            <th>Field</th>
                                                                                            <th>Database</th>
                                                                                            <th>Incoming</th>
                                                                                        </tr>

                                                                                    </thead>

                                                                                    <tbody>

                                                                                        <template
                                                                                            x-for="(diff, field) in item.differences">

                                                                                            <tr>

                                                                                                <td class="fw-semibold"
                                                                                                    x-text="field">
                                                                                                </td>

                                                                                                <td class="text-danger"
                                                                                                    x-text="diff.database">
                                                                                                </td>

                                                                                                <td class="text-success"
                                                                                                    x-text="diff.incoming">
                                                                                                </td>

                                                                                            </tr>

                                                                                        </template>

                                                                                    </tbody>

                                                                                </table>

                                                                            </div>

                                                                        </template>

                                                                    </div>

                                                                </template>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>





                                        </template>


                                        <div class="accordion accordion-flush">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#details"
                                                        aria-expanded="false" aria-controls="details">
                                                        Details
                                                    </button>
                                                </h2>
                                                <div id="details" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">


                                                        <div class="card border-0 shadow-sm mb-4">

                                                            <div class="card-header bg-white fw-bold py-3">
                                                                Suppliers
                                                            </div>

                                                            <div class="table-responsive">

                                                                <table class="table align-middle mb-0">

                                                                    <thead class="table-light">

                                                                        <tr>
                                                                            <th>UID</th>
                                                                            <th>Name</th>
                                                                            <th>Location</th>
                                                                            <th>Status</th>
                                                                        </tr>

                                                                    </thead>

                                                                    <tbody>

                                                                        <template x-for="item in analysis.suppliers"
                                                                            :key="item.uid">

                                                                            <tr>

                                                                                <td class="fw-semibold font-monospace"
                                                                                    x-text="item.uid"></td>

                                                                                <td>

                                                                                    <div class="fw-semibold"
                                                                                        x-text="item.name">
                                                                                    </div>

                                                                                    <div class="small text-muted"
                                                                                        x-text="item.contact"></div>

                                                                                </td>

                                                                                <td x-text="item.location || '-'"></td>

                                                                                <td>

                                                                                    <span class="badge"
                                                                                        :class="badgeClass(item.type)"
                                                                                        x-text="item.type"></span>

                                                                                </td>

                                                                            </tr>

                                                                        </template>

                                                                    </tbody>

                                                                </table>

                                                            </div>

                                                        </div>




                                                        <div class="card border-0 shadow-sm mb-4">

                                                            <div class="card-header bg-white fw-bold py-3">
                                                                Layups
                                                            </div>

                                                            <div class="table-responsive">

                                                                <table class="table align-middle mb-0">

                                                                    <thead class="table-light">

                                                                        <tr>
                                                                            <th>UID</th>
                                                                            <th>Name</th>
                                                                            <th>Supplier</th>
                                                                            <th>Revision</th>
                                                                            <th>Status</th>
                                                                        </tr>

                                                                    </thead>

                                                                    <tbody>

                                                                        <template x-for="item in analysis.layups"
                                                                            :key="item.uid">

                                                                            <tr>

                                                                                <td class="font-monospace small"
                                                                                    x-text="item.uid"></td>

                                                                                <td>

                                                                                    <div class="fw-semibold"
                                                                                        x-text="item.name">
                                                                                    </div>

                                                                                    <div class="small text-muted">

                                                                                        <span
                                                                                            x-text="item.species"></span>

                                                                                        ·

                                                                                        Grade
                                                                                        <span
                                                                                            x-text="item.grade"></span>

                                                                                    </div>

                                                                                    <template x-if="item.message">

                                                                                        <div class="small text-warning mt-1"
                                                                                            x-text="item.message"></div>

                                                                                    </template>

                                                                                </td>

                                                                                <td>

                                                                                    <div class="fw-semibold"
                                                                                        x-text="item.supplier_name">
                                                                                    </div>

                                                                                    <div class="small text-muted"
                                                                                        x-text="item.supplier_uid">
                                                                                    </div>
                                                                                </td>

                                                                                <td x-text="item.revision"></td>

                                                                                <td>

                                                                                    <span class="badge"
                                                                                        :class="badgeClass(item.type)"
                                                                                        x-text="item.type"></span>

                                                                                </td>

                                                                            </tr>

                                                                        </template>

                                                                    </tbody>

                                                                </table>

                                                            </div>

                                                        </div>




                                                        <div class="card border-0 shadow-sm">

                                                            <div class="card-header bg-white fw-bold py-3">
                                                                Layers
                                                            </div>

                                                            <div class="table-responsive">

                                                                <table class="table align-middle mb-0">

                                                                    <thead class="table-light">

                                                                        <tr>
                                                                            <th>Layup UID</th>

                                                                            <th>Layup</th>
                                                                            <th>Layer</th>
                                                                            <th>Thickness</th>
                                                                            <th>Width</th>
                                                                            <th>Angle</th>
                                                                            <th>Grade</th>
                                                                            <th>Status</th>
                                                                        </tr>

                                                                    </thead>

                                                                    <tbody>

                                                                        <template
                                                                            x-for="(item, index) in analysis.layers"
                                                                            :key="index">

                                                                            <tr :class="{
                                                        'table-warning':
                                                            ['CONFLICT', 'DUPLICATE_LAYER']
                                                            .includes(item.type)
                                                    }">

                                                                                <td class="font-monospace small"
                                                                                    x-text="item.incoming?.layup_uid || item.layup_uid">
                                                                                </td>



                                                                                <td>

                                                                                    <div class="fw-semibold"
                                                                                        x-text="item.layup_name"></div>


                                                                                </td>

                                                                                <td>

                                                                                    <span class="badge bg-dark"
                                                                                        x-text="'#' + item.layer_order"></span>

                                                                                </td>

                                                                                <td>

                                                                                    <div
                                                                                        x-text="item.incoming?.thickness ?? '-'">
                                                                                    </div>

                                                                                    <template
                                                                                        x-if="item.differences?.thickness">

                                                                                        <div class="small text-danger">

                                                                                            DB:
                                                                                            <span
                                                                                                x-text="item.differences.thickness.database"></span>

                                                                                        </div>

                                                                                    </template>

                                                                                </td>

                                                                                <td
                                                                                    x-text="item.incoming?.width ?? '-'">
                                                                                </td>

                                                                                <td
                                                                                    x-text="item.incoming?.angle ?? '-'">
                                                                                </td>

                                                                                <td
                                                                                    x-text="item.incoming?.grade ?? '-'">
                                                                                </td>

                                                                                <td>

                                                                                    <div
                                                                                        class="d-flex flex-column gap-1">

                                                                                        <span
                                                                                            class="badge align-self-start"
                                                                                            :class="badgeClass(item.type)"
                                                                                            x-text="item.type"></span>

                                                                                        <template x-if="item.message">

                                                                                            <div class="small text-muted"
                                                                                                x-text="item.message">
                                                                                            </div>

                                                                                        </template>

                                                                                    </div>

                                                                                </td>

                                                                            </tr>

                                                                        </template>

                                                                    </tbody>

                                                                </table>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>



                                    </div>

                                </template>



                                <div class="d-flex justify-content-end mt-4 gap-2">

                                    <button type="button" class="btn btn-light" @click="importModal = false">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-primary px-4">
                                        <template x-if="loading">
                                            <span class="btn-spinner mr-2" role="status" aria-hidden="true"></span>
                                        </template>
                                        <span x-text="loading ? 'Importing...' : 'Import'"></span>
                                    </button>

                                </div>

                            </form>

                        </div>

                    

                    </div>

                </div>

            </div>


        </div>


    </div>
</div>


    {{-- <div class="modal-body">
                            <form action="{{ route('supplier.import.check') }}" method="POST"
                                enctype="multipart/form-data" x-data="{ dragging: false, fileName: '', }"> @csrf <label
                                    for="fileInput"
                                    class="w-100 border border-2 border-dashed rounded-2 p-2 text-center transition-all"
                                    :class="dragging ? 'border-primary bg-primary bg-opacity-10 shadow-sm' : 'border-secondary-subtle bg-light'"
                                    @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false"
                                    @drop.prevent=" dragging = false; $refs.file.files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0]?.name || ''; "
                                    style="cursor: pointer; min-height: 100px; display:flex; align-items:center; justify-content:center;">
                                    <div>
                                        <div class="mb-3" style="font-size: 60px;"> 📦 </div>
                                        <h4 class="fw-bold mb-2 text-dark"> Drag & Drop Excel File </h4>
                                        <p class="text-muted mb-3"> Drop your .xlsx or .xls file here </p> <button
                                            @click="$refs.file.click()" type="button"
                                            class="btn btn-outline-primary rounded-pill px-4"> Browse File </button>
                                        <template x-if="fileName">
                                            <div class="mt-4"> <span class="badge bg-success px-3 py-2 fs-6"> 📄 <span
                                                        x-text="fileName"></span> </span> </div>
                                        </template>
                                    </div>
                                </label> <input type="file" name="file" id="fileInput" class="d-none"
                                    accept=".xlsx,.xls,.csv" x-ref="file"
                                    @change="fileName = $event.target.files[0]?.name || ''">
                                <div class="d-flex justify-content-end mt-4 gap-2"> <button type="button"
                                        class="btn btn-light" @click="importModal = false"> Cancel </button> <button
                                        type="submit" class="btn btn-primary px-4"> Check import </button> </div>
                            </form>
                        </div> --}}

{{-- <script>
    function importChecker() {
        return {

            dragging: false,
            fileName: '',

            loading: false,

            analysis: null,
            sessionId: null,

            globalConflictResolution: 'skip',
            resolutions: {},

            async processFile(file) {

                if (!file) return;

                this.fileName = file.name;

                this.loading = true;

                this.analysis = null;

                let formData = new FormData();

                formData.append('file', file);

                formData.append(
                    '_token',
                    '{{ csrf_token() }}'
                );

                try {

                    const response = await fetch(
                        '{{ route('supplier.import.check') }}',
                        {
                            method: 'POST',
                            body: formData
                        }
                    );

                    const result = await response.json();

                    this.analysis = result.analysis;

                    this.resolutions = {};

                    if (this.analysis?.conflicts?.length) {

                        this.analysis.conflicts.forEach(conflict => {

                            const key =
                                conflict.uid
                                ?? (
                                   conflict.incoming.layup_uid
                                    + '-'
                                    + conflict.layer_order
                                );

                            this.resolutions[key] = 'skip';
                        });
                    }


                    this.sessionId = result.session_id;

                    console.log(result);

                } catch (e) {

                    console.error(e);

                    alert('Import check failed');

                } finally {

                    this.loading = false;
                }
            },

            async commitImport() {

                const resolutions = {
                    suppliers: {},
                    layups: {},
                    layers: {},
                };

            

                if (this.analysis?.suppliers?.length) {

                    this.analysis.suppliers.forEach(item => {

                        if (item.type !== 'CONFLICT') {
                            return;
                        }

                        resolutions.suppliers[item.uid] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[item.uid]
                            : this.globalConflictResolution;
                    });
                }

              

                if (this.analysis?.layups?.length) {

                    this.analysis.layups.forEach(item => {

                        if (item.type !== 'NAME_DUPLICATE') {
                            return;
                        }

                        resolutions.layups[item.uid] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[item.uid]
                            : this.globalConflictResolution;
                    });
                }

               

                if (this.analysis?.layers?.length) {

                    this.analysis.layers.forEach(item => {

                        if (item.type !== 'CONFLICT') {
                            return;
                        }

                        const key =
                            item.incoming.layup_uid
                            + '-'
                            + item.layer_order;

                        resolutions.layers[key] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[key]
                            : this.globalConflictResolution;
                    });
                }

                console.log(resolutions);

                try {

                    const response = await fetch(
                        '{{ route('supplier.import.commit') }}',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },

                            body: JSON.stringify({

                                session_id: this.sessionId,

                                resolutions,
                            }),
                        }
                    );

                    const result = await response.json();

                    console.log(result);

                    alert(result.message);

                    importModal = false;

                } catch (e) {

                    console.error(e);

                    alert('Commit failed');
                }
            },

            badgeClass(type) {

                return {
                    'IDENTICAL': 'bg-success',
                    'UPDATE': 'bg-warning text-dark',
                    'INVALID': 'bg-danger',
                    'NEW': 'bg-primary',
                    'DUPLICATE_IN_IMPORT': 'bg-secondary',
                    'CONFLICT': 'bg-danger',
                    'NAME_DUPLICATE': 'bg-danger',
                    'DUPLICATE_LAYER': 'bg-danger',
                }[type] || 'bg-dark';
            },
        }
    }
</script> --}}

@endsection