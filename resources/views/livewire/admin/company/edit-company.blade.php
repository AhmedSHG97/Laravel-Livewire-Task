<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Company</h6>
                    </div>
                    @if (session()->has('message'))
                        <div class="alert alert-danger" style="color: azure">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card-body px-0 pt-0 pb-2 col-md-10">
                        <form wire:submit.prevent="update({{$company_id}})">
                            <label>Name</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="name"   aria-label="Name"
                                    aria-describedby="name-addon" wire:model="form.name">
                                @error('form.name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Email</label>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email"  placeholder="Email"
                                    aria-label="Email" aria-describedby="email-addon" wire:model="form.email">
                                @error('form.email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>Website</label>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="website"  placeholder="Website"
                                    aria-label="Website" aria-describedby="website-addon" wire:model="form.website">
                                @error('form.website')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <label>logo</label>
                            <div class="mb-3">
                                <img src="{{Storage::url($companyData->logo)}}" style="height:100px; width:100px">
                                <input type="file" class="form-control" id="logo" placeholder="Logo"
                                    aria-label="Logo" aria-describedby="logo-addon" wire:change="$emit('fileChoosen')">
                                @error('form.logo')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <center>
                            <div class="text-center col-md-4">
                                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Submit</button>
                            </div>
                        </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<script>
        window.livewire.on('fileChoosen',()=>{
            let inputField = document.getElementById('logo')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        });
</script>
