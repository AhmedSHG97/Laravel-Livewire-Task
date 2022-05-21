<?php

namespace App\Http\Livewire\Admin\Company;
use App\Models\Company as CompanyModel;
use Livewire\WithPagination;
use Livewire\Component;

class Company extends Component
{
    use WithPagination;

    public $form = [
        "name" => '',
        "email" => '',
        "logo" => '',
        "website" => '',
    ];
   
    protected $paginationTheme = 'bootstrap';

    public function store(){
        $this->dispatchBrowserEvent('closeModal');
    }
    public function delete($company_id){
        CompanyModel::find($company_id)->delete();
        session()->flash('Message', "Company has been deleted successfully");

    }

    public function render()
    {
        $companies = CompanyModel::latest()->paginate(1);
        return view('livewire.admin.company.company',['companies' => $companies])->layout("layouts.user_type.auth");
    }
}
