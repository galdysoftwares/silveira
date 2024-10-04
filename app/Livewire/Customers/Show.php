<?php declare(strict_types = 1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Customer $customer;

    public function render(): View
    {
        return view('livewire.customers.show');
    }
}
