<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Companies</h6>
                    </div>
                    <div class="card-body pb-0">
                        {{-- <a href="{{ url('admin/company/create') }}" class="btn btn-primary">Create</a> --}}
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                                class="fa fa-plus"></i> Add Category</button>
                    </div>

                    <div wire:ignore.self class="modal fade" id="addModal" data-bs-backdrop="static"
                        data-bs-keyboard="false" aria-hidden="true" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add a Company</h5>
                                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                                        aria-label="Close"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body px-0 pt-0 pb-2 col-md-10">
                                        <form wire:submit.prevent="store">
                                            <label>Name</label>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" placeholder="Name" id="name" aria-label="Name"
                                                    aria-describedby="name-addon" wire:model="form.name">
                                                @error('form.name')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <label>Email</label>
                                            <div class="mb-3">
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Email" aria-label="Email"
                                                    aria-describedby="email-addon" wire:model="form.email">
                                                @error('form.email')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <label>Website</label>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="website"
                                                    placeholder="Website" aria-label="Website"
                                                    aria-describedby="website-addon" wire:model="form.website">
                                                @error('form.website')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <label>logo</label>
                                            <div class="mb-3">
                                                @if ($form['logo'])
                                                    <img src="{{ $form['logo'] }}" style="height:100px; width:100px">
                                                @endif
                                                <input type="file" class="form-control" id="logo" placeholder="Logo"
                                                    aria-label="Logo" aria-describedby="logo-addon"
                                                    wire:change="$emit('fileChoosen')">
                                                @error('form.logo')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <center>
                                                <div class="text-center col-md-4">
                                                    <button type="submit"
                                                        class="btn bg-gradient-info w-100 mt-4 mb-0">Submit</button>
                                                </div>
                                            </center>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            email</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Website</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-4 py-1">
                                                    <div>
                                                        <img src="{{ Storage::url($company->logo) }}"
                                                            class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $company->email }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $company->name }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ $company->website }}"><span
                                                        class="text-xs font-weight-bold mb-0">{{ $company->website }}</span></a>

                                            </td>

                                            <td class="align-middle text-center">
                                                <a href="{{ url('admin/company/edit/' . $company->id) }}"
                                                    class="text-secondary font-weight-bold text-xs btn btn-info"
                                                    style="margin:2px; color:azure !important" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    Edit
                                                </a>
                                                <a wire:click="delete({{ $company->id }})"
                                                    class="text-secondary font-weight-bold text-xs btn btn-danger"
                                                    style="margin:2px; cursor:pointer; color:azure !important"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    remove
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</main>
<script>
    window.addEventListener('closeModal', event => {
        let button = document.querySelector(".close");
        button.click();
    });
    window.livewire.on('fileChoosen', () => {
        let inputField = document.getElementById('logo')
        let file = inputField.files[0]
        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result)
        }
        reader.readAsDataURL(file);
    });
</script>
