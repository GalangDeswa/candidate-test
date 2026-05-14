@extends('layouts.master')

@section('content')



<div class="content">




        <header class="dashboard-header text-center">
           
               <img src={{ asset("assets/images/logoclt_w.png") }}  alt="" height="100">
                <p class="lead">Selamat Datang, {{Auth::user()->name}}</p>
          
        </header>




        <div class="container overlap-container">
            <div class="row">
                <div class="col-md-6 col-xxl-4">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 bg-primary-subtle rounded-2 border-top border-primary shadow-sm">
                                    <iconify-icon icon="solar:users-group-two-rounded-broken"
                                        class="align-middle fs-26 text-primary"></iconify-icon>
                                </div>

                                <div class="d-flex flex-column">
                                    <h5 class="title fs-14 fw-normal text-dark mb-1">Suppliers Total</h5>
                                    <div class="fs-18 fw-medium mb-0 me-2 text-dark mb-1">{{ $allSupliers }}</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-footer bg-muted-color border-top d-flex align-content-center justify-content-between py-2 overflow-hidden">
                            
                           
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xxl-4">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 bg-warning-subtle rounded-2 border-top border-warning shadow-sm">
                                    <iconify-icon icon="solar:phone-rounded-broken"
                                        class="align-middle fs-26 text-warning"></iconify-icon>
                                </div>

                                <div class="d-flex flex-column">
                                    <div class="fs-14 fw-normal text-dark mb-1">Layups Total</div>
                                    <div class="fs-18 fw-medium mb-0 me-2 text-dark mb-1">{{ $AllLayups }}</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-footer bg-muted-color border-top d-flex align-content-center justify-content-between py-2 overflow-hidden">
                          
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xxl-4">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 bg-success-subtle rounded-2 border-top border-success shadow-sm">
                                    <iconify-icon icon="solar:verified-check-broken"
                                        class="align-middle fs-26 text-success"></iconify-icon>
                                </div>

                                <div class="d-flex flex-column">
                                    <div class="fs-14 fw-normal text-dark mb-1">Layers Total</div>
                                    <div class="fs-18 fw-medium mb-0 me-2 text-dark mb-1">{{ $allLayers }}</div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-footer bg-muted-color border-top d-flex align-content-center justify-content-between py-2 overflow-hidden">
                        
                        </div>
                    </div>
                </div>


            </div>


        </div>









   
</div> 


@endsection