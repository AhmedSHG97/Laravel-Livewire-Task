<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;

class EditCompany extends Component
{
    use WithFileUploads;
    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
    ];
    public $form = [
        "name" => '',
        "email" => '',
        "logo" => '',
        "website" => '',
    ];
    public $company_id, $companyData;
    protected $messages = [
        'form.email.email' => "The email is not vaild",
        'form.email.required' => "Email is required",
        'form.email.min' => "Email must be at least 5 chatacters",
        'form.name.required' => "Name is required",
        'form.name.min' => "Name must be at least 2 chatacters",
        'form.website.url' => "Website must be a valid URL",
        'form.website.required' => "Website is required",
        'form.logo.required' => "Logo is required",
        'form.logo.mimes' => "Logo mime type is not supported",
        'form.logo.image' => "Logo must be an image.",
    ];
    public function updated(){
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.name" => "required|string|min:2",
            "form.website" => "required|url",
            "form.logo" => "nullable",
        ]);
    }
    public function mount(){
        $this->company_id = request()->id;
        $this->companyData = Company::find($this->company_id);
        if(!$this->companyData){
            session()->flash('errorMessage', "Company is not found");
            return redirect()->route("company");
        }
        $this->form['name'] = $this->companyData->name;
        $this->form['email'] = $this->companyData->email;
        $this->form['website'] = $this->companyData->website;
        $this->form['logo'] = $this->companyData->logo;
        
    }
    public function handleFileUpload($imageData)
    {
        $this->form["logo"] = $imageData;
    }
    public function update($company_id){
        $companyData = Company::find($company_id);
        $this->validate([
            "form.email" => "required|email|min:5",
            "form.name" => "required|string|min:2",
            "form.website" => "required|url",
            "form.logo" => "nullable",
        ]);
        $this->form['logo']  = $this->storeImage();
        if(!$this->form['logo']){
            $companyData->update([
                "name" => $this->form['name'],
                "email" => $this->form['email'],
                "website" => $this->form['website'],
            ]);
            $companyData->refresh();
        }else{
            $companyData->update($this->form);
            $companyData->refresh();
        }
        session()->flash('Message', "Company is not found");
        return redirect('admin/company/edit/'.$company_id);
    }
    
    private function storeImage()
    {
        if ($this->form['logo'] == $this->companyData->logo) {
            return null;
        }

        $img   = ImageManagerStatic::make($this->form['logo'])->encode('jpg');
        $name  = "company/logo/" . Str::random() . uniqid() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }
    public function render()
    {
        return view('livewire.admin.company.edit-company')->layout("layouts.user_type.auth");
    }
}
