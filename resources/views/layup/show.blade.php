@extends('layouts.master')


@section('content')


<div class="page-header-bg">
    <div class="container-fluid p-2">
        <div class="row page-title clearfix p-3">

            <h1>
                {{$layup->name}}
            </h1>
            <h6>
                {{$layup->uid}}
            </h6>
            <div class="page-title-right">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item ">Supplier</li>
                    <li class="breadcrumb-item active">Layups</li>

                </ol>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid overlap-cards">
    <div class="" x-data="{
    
        editModal : false,
        editData :{},
}">

        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-3">

                    <div class="card-header">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <h5 class="card-title mb-0">Layup Detail</h5>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-sm float-end"
                                    @click="editModal = true; editData = {{ $layup }};">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> <span>Edit</span>
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">UID</label>

                            <h6>{{$layup->uid}}</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Name</label>

                            <h6>{{$layup->name}}</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Species</label>

                            <h6>{{$layup->species}}</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Grade</label>

                            <h6>{{$layup->grade}}</h6>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Revision
                            </label>

                            <h6>{{$layup->revision}}</h6>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Status
                            </label>

                            <h6>{{$layup->status}}</h6>
                        </div>


                        <hr class="mt-4">


                        <div class="col-12 col-md-6">
                            <h5 class="card-title mb-0">Layers</h5>
                        </div>

                        <div class="col-12 col-md-6">
                            <h5 class="card-title mb-0">Visual</h5>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="table-responsive  rounded">
                                <table class="table  table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order</th>
                                            <th>thinkness</th>
                                            <th>width</th>
                                            <th>angle</th>
                                            <th>grade</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($layup->layers as $layer )
                                        <tr>

                                            <td>
                                                {{$layer->layer_order}}
                                            </td>

                                            <td>
                                                {{$layer->thickness}}
                                            </td>

                                            <td>
                                                {{$layer->width}}
                                            </td>


                                            <td>
                                                {{$layer->angle}}
                                            </td>

                                            <td>
                                                {{$layer->grade}}
                                            </td>


                                        </tr>

                                        @endforeach



                                        </template>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            @foreach ($layup->layers as $layer)
                        
                            <div class="container-fluid mb-1 p-3 rounded shadow-sm"
                                style="background-color: {{ $loop->odd ? '#bf935a' : '#e8c290' }};">

                                <div class="row align-items-center">
                                    <!-- Layer Order Indicator -->
                                    <div class="col-2">
                                        <span class="badge bg-dark opacity-75">#{{ $layer->layer_order }}</span>
                                    </div>

                                    <!-- Properties -->
                                    <div class="col-10">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <small class="d-block text-uppercase fw-bold text-white"
                                                    style="font-size: 0.65rem;">Thickness</small>
                                                <span class="fw-bold text-white">{{ $layer->thickness }}mm</span>
                                            </div>
                                            <div class="col-4 border-start border-end border-dark border-opacity-10">
                                                <small class="d-block text-uppercase fw-bold text-white"
                                                    style="font-size: 0.65rem;">Width</small>
                                                <span class="fw-bold text-white">{{ $layer->width }}mm</span>
                                            </div>
                                            <div class="col-4">
                                                <small class="d-block text-uppercase fw-bold text-white"
                                                    style="font-size: 0.65rem;">Angle</small>
                                                <span class="fw-bold text-white">{{ $layer->angle }}°</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach
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


                    <div class="modal-dialog modal-lg modal-dialog-centered" style="min-width: 80vw;">

                        <div class="modal-content">

                            {{-- Header --}}
                            <div class="modal-header bg-primary text-white">

                                <h5 class="modal-title">
                                    Edit layups
                                </h5>

                                <button type="button" class="btn-close btn-close-white"
                                    @click="editModal = false"></button>

                            </div>

                            <div x-data="{
                    loading :false,
                    check : false,

                    check(){
                        console.log(this.form);
                    },

                      form: $form('post', `/layup/update/${editData.id}`,{
                            supplier_id: editData.supplier_id,
                             name: editData.name,
                             species: editData.species,
                             grade: editData.grade,
                             status: editData.status,
                             revision: editData.revision,
                             layers: {{ $layup->layers }}
                           
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

                                                <input type="text" name="uid" class="form-control"
                                                    placeholder="SUP-001">
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

                                                <input x-model="form.species" type="text" name="contact"
                                                    class="form-control" placeholder="Pine">
                                                <template x-if="form.invalid('species')">
                                                    <div class="error-text" x-text="form.errors.species"></div>
                                                </template>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Grade</label>

                                                <input x-model="form.grade" type="text" name="location"
                                                    class="form-control" placeholder="A">
                                                <template x-if="form.invalid('grade')">
                                                    <div class="error-text" x-text="form.errors.grade"></div>
                                                </template>

                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">
                                                    Revision
                                                </label>

                                                <input placeholder="v1" x-model="form.revision" type="text"
                                                    name="revision" class="form-control">
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
                                                <!-- Header Section -->
                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0">Layers</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" @click="form.layers.push({
                                                    layer_order: form.layers.length + 1,
                                                    thickness: 0.0,
                                                    width: 0.0,
                                                    angle: 0,
                                                    grade :'',
                                                })">
                                                        <i class="fa-solid fa-plus me-1"></i> Add Layer
                                                    </button>
                                                </div>

                                                <!-- Table Section -->
                                                <div class="col-12">
                                                    <div class="table-responsive border rounded">
                                                        <table class="table table-bordered align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="min-width: 80px;">Order</th>
                                                                    <th style="min-width: 120px;">Thickness (mm)</th>
                                                                    <th style="min-width: 120px;">Width (mm)</th>
                                                                    <th style="min-width: 100px;">Angle </th>
                                                                    <th style="min-width: 150px;">Grade</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <template x-for="(layer, index) in form.layers"
                                                                    :key="index">
                                                                    <tr>
                                                                        <td>
                                                                            <input x-model="layer.layer_order"
                                                                                type="number"
                                                                                class="form-control form-control-sm"
                                                                                :name="`layer[${index}][order]`">

                                                                            <template
                                                                                x-if="form.invalid(`layers.${index}.layer_order`)">
                                                                                <div class="text-danger small mt-1"
                                                                                    x-text="form.errors[`layers.${index}.layer_order`]">
                                                                                </div>
                                                                            </template>
                                                                        </td>

                                                                        <td>
                                                                            <input x-model="layer.thickness"
                                                                                type="number" step="0.01"
                                                                                class="form-control form-control-sm"
                                                                                :name="`layer[${index}][thickness]`">

                                                                            <template
                                                                                x-if="form.invalid(`layers.${index}.thickness`)">
                                                                                <div class="text-danger small mt-1"
                                                                                    x-text="form.errors[`layers.${index}.thickness`]">
                                                                                </div>
                                                                            </template>
                                                                        </td>

                                                                        <td>
                                                                            <input x-model="layer.width" type="number"
                                                                                step="0.01"
                                                                                class="form-control form-control-sm"
                                                                                :name="`layer[${index}][width]`">

                                                                            <template
                                                                                x-if="form.invalid(`layers.${index}.width`)">
                                                                                <div class="text-danger small mt-1"
                                                                                    x-text="form.errors[`layers.${index}.width`]">
                                                                                </div>
                                                                            </template>
                                                                        </td>

                                                                        <td>
                                                                            <input x-model="layer.angle" type="number"
                                                                                class="form-control form-control-sm"
                                                                                :name="`layer[${index}][angle]`">

                                                                            <template
                                                                                x-if="form.invalid(`layers.${index}.angle`)">
                                                                                <div class="text-danger small mt-1"
                                                                                    x-text="form.errors[`layers.${index}.angle`]">
                                                                                </div>
                                                                            </template>
                                                                        </td>

                                                                        <td>
                                                                            <input x-model="layer.grade" type="text"
                                                                                class="form-control form-control-sm"
                                                                                :name="`layer[${index}][grade]`">

                                                                            <template
                                                                                x-if="form.invalid(`layers.${index}.grade`)">
                                                                                <div class="text-danger small mt-1"
                                                                                    x-text="form.errors[`layers.${index}.grade`]">
                                                                                </div>
                                                                            </template>
                                                                        </td>

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

                                                    <!-- Empty State (Optional) -->
                                                    <template x-if="form.layers.length === 0">
                                                        <div
                                                            class="text-center py-4 bg-light border border-top-0 rounded-bottom">
                                                            <span class="text-muted">No layers added yet.</span>
                                                        </div>
                                                    </template>
                                                </div>
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


    </div>

</div>




@endsection