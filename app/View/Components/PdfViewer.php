<?php

namespace App\View\Components;

use App\Models\Materi;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PdfViewer extends Component
{
    public Materi $materi;
    public ?int $currentPage;
    public ?int $totalPages;
    public ?float $progressPercentage;
    public bool $isCompleted;

    /**
     * Create a new component instance.
     */
    public function __construct(Materi $materi, ?int $currentPage = null, ?int $totalPages = null, ?float $progressPercentage = null, bool $isCompleted = false)
    {
        $this->materi = $materi;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->progressPercentage = $progressPercentage;
        $this->isCompleted = $isCompleted;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pdf-viewer');
    }
}
