<?php
namespace App\Http\Livewire;
use App\Domains\Lookups\Models\Label;
use Livewire\Component;
use Livewire\WithPagination;

class LabelTable extends Component
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
        $labels = Label::query()
            ->where(function ($query) {
                $query->where('key', 'like', '%' . $this->search . '%')
                    ->orWhere('value', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.labels-table', compact('labels'));
    }
}
