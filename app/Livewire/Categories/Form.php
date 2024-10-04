<?php declare(strict_types = 1);

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Category $category = null;

    public string $title = '';

    public function rules(): array
    {
        return [
            'title' => ['required', 'min:3', 'max:255', Rule::unique('categories', 'title')->ignore($this->category)],
        ];
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->title    = $category->title;
    }

    public function update(): void
    {
        $this->validate();

        $this->category->title = $this->title;

        $this->category->update();
    }

    public function create(): void
    {
        $this->validate();

        Category::create([
            'title' => $this->title,
        ]);

        $this->reset();
    }
}
