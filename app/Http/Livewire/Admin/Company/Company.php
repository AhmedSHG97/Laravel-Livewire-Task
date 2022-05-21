<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Company as CompanyModel;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;

class Company extends Component
{
    use WithPagination, WithFileUploads;

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
    ];

    public $form = [
        "name" => '',
        "email" => '',
        "logo" => '',
        "website" => '',
    ];

    protected $messages = [
        'form.email.email' => "The email is not vaild",
        'form.email.required' => "Email is required",
        'form.email.min' => "Email must be at least 5 chatacters",
        'form.name.required' => "Name is required",
        'form.name.min' => "Name must be at least 2 chatacters",
        'form.website.url' => "Website must be a valid URL",
        'form.website.required' => "Website is required",
        'form.logo.required' => "Logo is required",
        'form.logo.image' => "Logo must be an image.",
    ];
    protected $paginationTheme = 'bootstrap';
    public function updated(){
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.name" => "required|string|min:2",
            "form.website" => "required|url",
        ]);
    }
    public function store()
    {
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.name" => "required|string|min:2",
            "form.website" => "required|url",
        ]);
        $image = $this->storeImage();
        $this->form['logo'] = $image;
        CompanyModel::create($this->form);
        $this->dispatchBrowserEvent('closeModal');
        $this->refreshData();
    }
    public function refreshData()
    {
        $this->form = [
            "name" => '',
            "email" => '',
            "logo" => '',
            "website" => '',
        ];
    }
    private function storeImage()
    {
        $img   = ImageManagerStatic::make($this->form['logo'])->encode('jpg');
        $name  = "company/logo/" . Str::random() . uniqid() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }
    public function handleFileUpload($imageData)
    {
        $this->form["logo"] = $imageData;
    }
    public function delete($company_id)
    {
        CompanyModel::find($company_id)->delete();
        session()->flash('Message', "Company has been deleted successfully");
    }

    public function render()
    {
        $companies = CompanyModel::latest()->paginate(1);
        return view('livewire.admin.company.company', ['companies' => $companies])->layout("layouts.user_type.auth");
    }
}
