<?php declare(strict_types = 1);

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Archive extends Component
{
    use Toast;

    public Category $category;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.categories.archive');
    }

    #[On('category::archive')]
    public function confirmAction(int $id): void
    {
        $this->category = Category::findOrFail($id);
        $this->modal    = true;
    }

    public function archive(): void
    {
        $this->category->delete();
        $this->modal = false;
        $this->success(__('Archived successfully.'));
        $this->dispatch('category::reload')->to('categories.index');
    }
}
