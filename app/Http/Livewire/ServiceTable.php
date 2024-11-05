<?php
namespace App\Http\Livewire;
use App\Domains\Service\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceTable extends Component
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
        $services = Service::query()
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.services-table', compact('services'));
    }
}
