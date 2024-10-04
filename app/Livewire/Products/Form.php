<?php declare(strict_types = 1);

namespace App\Livewire\Products;

use App\Models\{Category, Product};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Product $product = null;

    public string $title = '';

    public string $code = '';

    public ?string $amount = null;

    public ?int $category_id = null;

    public ?string $description = null;

    public Collection|array $categories = [];

    public function rules(): array
    {
        return [
            'title'       => 'required|min:3|max:255',
            'code'        => ['required', 'min:3', 'max:255', Rule::unique('products')->ignore($this->product?->id)],
            'amount'      => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ];
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;

        $this->category_id = $product->category_id;
        $this->title       = $product->title;
        $this->code        = $product->code;
        $this->amount      = (string) ($product->amount / 100);
        $this->description = $product->description;

        $this->searchCategory();
    }

    public function update(): void
    {
        $this->validate();

        $this->product->category_id = $this->category_id;
        $this->product->title       = $this->title;
        $this->product->code        = $this->code;
        $this->product->amount      = $this->getAmountAsInt();
        $this->product->description = $this->description;

        $this->product->update();
    }

    public function create(): void
    {
        $this->validate();

        Product::create([
            'category_id' => $this->category_id,
            'title'       => $this->title,
            'code'        => $this->code,
            'amount'      => $this->getAmountAsInt(),
            'description' => $this->description,
        ]);

        $this->reset();
    }

    private function getAmountAsInt(): int
    {
        $amount = $this->amount;

        if ($amount === null) {
            $amount = 0;
        }

        return (int) ($amount * 100);
    }

    public function searchCategory(string $value = ''): void
    {
        $this->categories = Category::query()
                ->select('id', 'title')
                ->where('title', 'like', "%$value%")
                ->take(5)
                ->orderBy('title')
                ->get()
                ->when(
                    filled($this->category_id),
                    fn ($q) => $q->merge(
                        Category::query()->select('id', 'title')->whereId($this->category_id)->get()
                    )
                );
    }
}
