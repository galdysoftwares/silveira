<?php declare(strict_types = 1);

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Restore extends Component
{
    use Toast;

    public Category $category;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.categories.restore');
    }

    #[On('category::restore')]
    public function confirmAction(int $id): void
    {
        $this->category = Category::query()->onlyTrashed()->findOrFail($id);
        $this->modal    = true;
    }

    public function restore(): void
    {
        $this->category->restore();
        $this->modal = false;
        $this->success(__('Restored successfully.'));
        $this->dispatch('category::reload')->to('categories.index');
    }
}
