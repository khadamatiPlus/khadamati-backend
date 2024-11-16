<?php
namespace App\Http\Livewire;
use App\Domains\Lookups\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // Ensure search query string is synced with URL
    protected $queryString = [
        'search' => ['except' => '']
    ];

    // Reset pagination when search input changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Build query based on search input
        $categories = Category::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                $query->orWhere('summary', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.categories-table', compact('categories'));
    }
}
