@extends('layouts.master')

@section('content')



 <div class="page-header-bg">
        <div class="container-fluid p-2">
            <div class="row page-title clearfix p-3">

                <h1>
                   {{$supplier->name}}
                </h1>
                 <h6>
                   {{$supplier->uid}}
                </h6>
                <div class="page-title-right">
                    <ol class="breadcrumb custom-breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item ">Supplier</li>
                         <li class="breadcrumb-item active">Details</li>

                    </ol>
                </div>
            </div>
        </div>
    </div>


     <div class="container-fluid overlap-cards">

        <div class="" x-data="{
        addLayupModal: false,
       
        detailData :{},
        importModal: false,
        editModal : false,
        editData :{},
     }">

    <div class="row">
        <div class="col-12">
            <div class="card mt-4">

                <div class="card-header">
                    <div class="row d-flex justify-content-between">
                        <div class="col-6">
                            <h5 class="card-title mb-0">Supplier Detail</h5>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary btn-sm float-end"
                                @click="editModal = true; editData = {{ $supplier }};"> <i
                                    class="fa-solid fa-pen-to-square me-1"></i> <span>Edit</span>
                            </button>
                        </div>
                    </div>


                </div>

                <div class="card-body">

                    <div class="row g-3">



                        <div class="col-md-4">
                            <label class="form-label">Name</label>

                            <h6>{{$supplier->name}}</h6>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contact</label>

                            <h6>{{$supplier->contact}}</h6>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Location</label>

                            <h6>{{$supplier->location}}</h6>


                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Last Audit
                            </label>

                            <h6>{{$supplier->last_audit}}</h6>
                        </div>






                        <div class="col-md-4">
                            <label class="form-label">
                                Material Certificate
                            </label>


                            <h6>{{$supplier->material_certificate ?? '-'}}</h6>

                        </div>



                        <div class="col-md-4">
                            <label class="form-label">
                                Status
                            </label>

                            <h6>{{$supplier->status}}</h6>

                        </div>
                        <hr class="mt-5">

                        <div class="py-3 d-flex align-items-center">



                            <!-- Title Section -->
                            <div class="flex-grow-1">
                               <h5 class="card-title mb-0">Layups</h5>
                            </div>

                            <!-- Buttons Section (Floated Right) -->
                            <div class="d-flex gap-2 ms-auto">


                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center"
                                    @click="addLayupModal = true" title="Add Layup">
                                    <i class="fa-solid fa-plus me-md-1"></i>
                                    <span class="d-none d-md-inline">Add Layup</span>
                                </button>

                                <button type="button" class="btn btn-info btn-sm d-flex align-items-center"
                                    @click="importModal = true" title="Import Layups">
                                    <i class="fa-solid fa-file-import me-md-1"></i>
                                    <span class="d-none d-md-inline">Import</span>
                                </button>


                                <a href="{{ route('layup.export') }}"
                                    class="btn btn-info btn-sm d-flex align-items-center" title="Export Layups">
                                    <i class="fa-solid fa-file-export me-md-1"></i>
                                    <span class="d-none d-md-inline">Export</span>
                                </a>



                            </div>

                        </div>

                        <div class="col-12">
                               <div class="table-responsive  rounded">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Total thinkness (mm)</th>
                                        <th>ply count</th>
                                        <th>species/grade</th>
                                        <th>revision</th>
                                        <th>status</th>
                                        <th>action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($supplier->layups as $layup)
                                    <tr>
                                        <td>{{ $layup->id }}</td>
                                        <td>{{ $layup->name }}</td>
                                        <td>{{ $layup->layers->sum('thickness') }}</td>
                                        <td>{{ $layup->layers->count() }}</td>
                                        <td>{{ $layup->species }}</td>
                                        <td>{{ $layup->revision }}</td>
                                        <td>{{ $layup->status }}</td>
                                        <td>



                                            <a href="{{ route('layup.show', $layup) }}" class="btn btn-info btn-sm">
                                              <i class="fas fa-eye"></i>
                                            </a>

                                            <form action="{{ route('layup.destroy', $layup) }}" method="POST"
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

                                    <tr>
                                        <td colspan="8" class="text-center">No Data</td>
                                    </tr>

                                    @endforelse

                                </tbody>
                            </table>
                            </div>




                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

    <template x-if="editModal">
        <div x-data="editData">
            <div x-transition class="modal fade" :class="editModal ? 'show d-block' : ''" tabindex="-1"
                x-show="editModal"
                style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1040;">


                <div class="modal-dialog modal-lg modal-dialog-centered">

                    <div class="modal-content">

                        {{-- Header --}}
                        <div class="modal-header bg-primary text-white">

                            <h5 class="modal-title">
                                Create Supplier
                            </h5>

                            <button type="button" class="btn-close btn-close-white" @click="editModal = false"></button>

                        </div>

                        <div x-data="{
                    loading :false,
                    check : editData.material_certificate != null? 'true' : 'false',


                    init(){
                       console.log(editData.name);
                    },

                      form: $form('post', `/supplier/update/${editData.id}`, {
                             name: editData.name,
                             contact: editData.contact,
                             location: editData.location,
                             status: editData.status,
                             material_certificate: editData.material_certificate,
                             last_audit: editData.last_audit,
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
                                                class="form-control" placeholder="Medan">
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


                                            <input x-model="form.material_certificate" name="material_certificate"
                                                class="form-control">

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

                                {{-- Footer --}}
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" @click="editModal = false">
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
        </div>

    </template>



    {{-- Modal Backdrop --}}
    <div x-transition class="modal fade" :class="addLayupModal ? 'show d-block' : ''" tabindex="-1"
        x-show="addLayupModal"
        style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1040;">


        <div class="modal-dialog modal-lg modal-dialog-centered" style="min-width: 70vw;">

            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        add layups
                    </h5>

                    <button type="button" class="btn-close btn-close-white" @click="addLayupModal = false"></button>

                </div>

                <div x-data="{
                    loading :false,
                    check : false,

                    check(){
                        console.log(this.form);
                    },

                      form: $form('post', '/layup', {
                            supplier_id: '{{$supplier->id}}',
                             name: '',
                             species: '',
                             grade: '',
                             status: 'active',
                             revision: 'v1',
                             layers: [
                                 {
                                     layer_order: 1,
                                     thickness: 0.0,
                                     width: 0.0,
                                     angle: 0,     
                                     grade :'',
                                 },
                             ],
                           
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
                                        placeholder="Standart 3 ply">
                                    <template x-if="form.invalid('name')">
                                        <div class="error-text" x-text="form.errors.name"></div>
                                    </template>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Species</label>

                                    <input x-model="form.species" type="text" name="contact" class="form-control"
                                        placeholder="Pine">
                                    <template x-if="form.invalid('species')">
                                        <div class="error-text" x-text="form.errors.species"></div>
                                    </template>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Grade</label>

                                    <input x-model="form.grade" type="text" name="location" class="form-control"
                                        placeholder="A">
                                    <template x-if="form.invalid('grade')">
                                        <div class="error-text" x-text="form.errors.grade"></div>
                                    </template>

                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        Revision
                                    </label>

                                    <input placeholder="v1" x-model="form.revision" type="text" name="revision"
                                        class="form-control">
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


                                <div class="row g-3">
                                    <!-- Header and Action Button -->
                                    <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Layers</h5>
                                        <button type="button" class="btn btn-primary btn-sm" @click="form.layers.push({
                                        layer_order: form.layers.length + 1,
                                        thickness: 0.0,
                                        width: 0.0,
                                        angle: 0,
                                        grade: '',
                                    })">
                                            <i class="fa-solid fa-plus me-1"></i>
                                            <span>Add Layer</span>
                                        </button>
                                    </div>

                                    <!-- Table Container -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 100px;">Order</th>
                                                        <th>Thickness (mm)</th>
                                                        <th>Width (mm)</th>
                                                        <th>Angle</th>
                                                        <th>Grade</th>
                                                        <th class="text-center" style="width: 50px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(layer, index) in form.layers" :key="index">
                                                        <tr>
                                                            <!-- Order -->
                                                            <td>
                                                                <input x-model="layer.layer_order" type="number"
                                                                    class="form-control form-control-sm"
                                                                    :class="form.invalid(`layers.${index}.layer_order`) ? 'is-invalid' : ''"
                                                                    :name="`layer[${index}][order]`">
                                                                <template
                                                                    x-if="form.invalid(`layers.${index}.layer_order`)">
                                                                    <div class="invalid-feedback"
                                                                        x-text="form.errors[`layers.${index}.layer_order`]">
                                                                    </div>
                                                                </template>
                                                            </td>

                                                            <!-- Thickness -->
                                                            <td>
                                                                <input x-model="layer.thickness" type="number"
                                                                    step="0.01" class="form-control form-control-sm"
                                                                    :class="form.invalid(`layers.${index}.thickness`) ? 'is-invalid' : ''"
                                                                    :name="`layer[${index}][thickness]`">
                                                                <template
                                                                    x-if="form.invalid(`layers.${index}.thickness`)">
                                                                    <div class="invalid-feedback"
                                                                        x-text="form.errors[`layers.${index}.thickness`]">
                                                                    </div>
                                                                </template>
                                                            </td>

                                                            <!-- Width -->
                                                            <td>
                                                                <input x-model="layer.width" type="number" step="0.01"
                                                                    class="form-control form-control-sm"
                                                                    :class="form.invalid(`layers.${index}.width`) ? 'is-invalid' : ''"
                                                                    :name="`layer[${index}][width]`">
                                                                <template x-if="form.invalid(`layers.${index}.width`)">
                                                                    <div class="invalid-feedback"
                                                                        x-text="form.errors[`layers.${index}.width`]">
                                                                    </div>
                                                                </template>
                                                            </td>

                                                            <!-- Angle -->
                                                            <td>
                                                                <input x-model="layer.angle" type="number"
                                                                    class="form-control form-control-sm"
                                                                    :class="form.invalid(`layers.${index}.angle`) ? 'is-invalid' : ''"
                                                                    :name="`layer[${index}][angle]`">
                                                                <template x-if="form.invalid(`layers.${index}.angle`)">
                                                                    <div class="invalid-feedback"
                                                                        x-text="form.errors[`layers.${index}.angle`]">
                                                                    </div>
                                                                </template>
                                                            </td>

                                                            <!-- Grade -->
                                                            <td>
                                                                <input x-model="layer.grade" type="text"
                                                                    class="form-control form-control-sm"
                                                                    :class="form.invalid(`layers.${index}.grade`) ? 'is-invalid' : ''"
                                                                    :name="`layer[${index}][grade]`">
                                                                <template x-if="form.invalid(`layers.${index}.grade`)">
                                                                    <div class="invalid-feedback"
                                                                        x-text="form.errors[`layers.${index}.grade`]">
                                                                    </div>
                                                                </template>
                                                            </td>

                                                            <!-- Action -->
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    @click="form.layers.splice(index, 1)">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Empty State -->
                                        <template x-if="form.layers.length === 0">
                                            <div class="text-center p-4 border rounded bg-light">
                                                <p class="text-muted mb-0">No layers added yet. Click "Add Layer" to
                                                    begin.</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" @click="addLayupModal = false">
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










@endsection