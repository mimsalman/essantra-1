<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Perfume;

class PerfumeSearch extends Component
{
    use WithPagination;

    public string $q = '';
    public int $minPrice = 0;
    public int $maxPrice = 20000;
    public string $inStock = 'all'; // all | yes | no

    // reset pagination when filters change
    public function updatingQ() { $this->resetPage(); }
    public function updatingMinPrice() { $this->resetPage(); }
    public function updatingMaxPrice() { $this->resetPage(); }
    public function updatingInStock() { $this->resetPage(); }

    public function render()
    {
        $query = Perfume::query()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if (trim($this->q) !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->q . '%')
                  ->orWhere('brand', 'like', '%' . $this->q . '%')
                  ->orWhere('category', 'like', '%' . $this->q . '%');
            });
        }

        $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        if ($this->inStock === 'yes') {
            $query->where('stock', '>', 0);
        } elseif ($this->inStock === 'no') {
            $query->where('stock', '<=', 0);
        }

        $perfumes = $query->latest()->paginate(9);

        return view('livewire.perfume-search', compact('perfumes'));
    }
}