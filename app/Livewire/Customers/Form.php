<?php declare(strict_types = 1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Customer $customer = null;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public function rules(): array
    {
        return [
            'name'  => ['required', 'min:3', 'max:255'],
            'email' => ['required_without:phone', 'email', 'max:255', Rule::unique('customers')->ignore($this->customer?->id, 'id')],
            'phone' => ['required_without:email', 'max:255', Rule::unique('customers')->ignore($this->customer?->id, 'id')],
        ];
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;

        $this->name  = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
    }

    public function update(): void
    {
        $this->validate();

        $this->customer->name  = $this->name;
        $this->customer->email = $this->email;
        $this->customer->phone = $this->phone;

        $this->customer->save();
    }

    public function create(): void
    {
        $this->validate();

        Customer::create([
            'type'  => 'customer',
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->reset();
    }
}
