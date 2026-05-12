@extends('layouts.master')

@section('content')

<div class="container-fliud p-3">
     <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-medium m-0">Supplier</h4>
                            </div>
                               <div class="flex-grow-1">
                               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Supplier</button>
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
                                                    
                                            
                                                <tr>
                                                    <td>Emily King</td>
                                                    <td>Data Engineer</td>
                                                    <td>Salt Lake City</td>
                                                    <td>30</td>
                                                    <td>2023-04-10</td>
                                                    <td>$125,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Nicholas Thomas</td>
                                                    <td>Business Development Manager</td>
                                                    <td>Tampa</td>
                                                    <td>27</td>
                                                    <td>2023-11-28</td>
                                                    <td>$95,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Oliver Martinez</td>
                                                    <td>Software Tester</td>
                                                    <td>Austin</td>
                                                    <td>34</td>
                                                    <td>2023-08-15</td>
                                                    <td>$115,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Sophia Brown</td>
                                                    <td>UX/UI Developer</td>
                                                    <td>Washington D.C.</td>
                                                    <td>31</td>
                                                    <td>2022-07-10</td>
                                                    <td>$90,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Liam Wilson</td>
                                                    <td>Content Manager</td>
                                                    <td>San Jose</td>
                                                    <td>28</td>
                                                    <td>2023-12-22</td>
                                                    <td>$75,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Charlotte Garcia</td>
                                                    <td>Project Analyst</td>
                                                    <td>Detroit</td>
                                                    <td>33</td>
                                                    <td>2023-05-05</td>
                                                    <td>$110,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Ethan Wright</td>
                                                    <td>Technical Writer</td>
                                                    <td>Indianapolis</td>
                                                    <td>30</td>
                                                    <td>2023-01-20</td>
                                                    <td>$80,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Isabella Baker</td>
                                                    <td>Systems Administrator</td>
                                                    <td>Charlotte</td>
                                                    <td>27</td>
                                                    <td>2023-09-18</td>
                                                    <td>$105,000</td>
                                                </tr>
                                                <tr>
                                                    <td>James Hall</td>
                                                    <td>Marketing Coordinator</td>
                                                    <td>San Francisco</td>
                                                    <td>34</td>
                                                    <td>2022-06-15</td>
                                                    <td>$95,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Emma Young</td>
                                                    <td>Product Owner</td>
                                                    <td>Denver</td>
                                                    <td>29</td>
                                                    <td>2022-11-30</td>
                                                    <td>$120,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Aiden Evans</td>
                                                    <td>Business Consultant</td>
                                                    <td>Seattle</td>
                                                    <td>32</td>
                                                    <td>2023-04-05</td>
                                                    <td>$100,000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                                    </div>


@endsection