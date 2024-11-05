<?php
namespace App\Http\Livewire;
use App\Domains\Notification\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationTable extends Component
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
        $notifications = Notification::query()
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.notifications-table', compact('notifications'));
    }
}
