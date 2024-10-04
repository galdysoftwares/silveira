<?php declare(strict_types = 1);

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Update extends Component
{
    use Toast;

    public Form $form;

    public bool $updateModal = false;

    public function render(): View
    {
        return view('livewire.categories.update');

    }

    #[On('category::update')]
    public function load(int $categoryId): void
    {
        $category = Category::query()
                        ->findOrFail($categoryId);
        $this->form->setCategory($category);
        $this->form->resetErrorBag();
        $this->updateModal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->updateModal = false;
        $this->success(__('Updated successfully.'));
        $this->dispatch('category::reload')->to('categories.index');
    }
}
