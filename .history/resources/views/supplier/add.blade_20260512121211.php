<div
    x-show="add"
    x-transition
    x-cloak
    class="modal fade"
    :class="add ? 'show d-block' : ''"
    tabindex="-1"
    style="background: rgba(0,0,0,0.5);"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    Create Supplier
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    @click="addSupplierModal = false"
                ></button>

            </div>

            {{-- Form --}}
            <form action="{{ route('supplier.store') }}"
                  method="POST">

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">
                                UID
                            </label>

                            <input
                                type="text"
                                name="uid"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Contact
                            </label>

                            <input
                                type="text"
                                name="contact"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                            >
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
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="add = false"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Supplier
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>