<?php

namespace App\Livewire\Dashboard;

use App\Models\StudentExam;
use Livewire\Component;

class ScoreDistribution extends Component
{
    public array $labels = [];
    public array $scores = [];

    public function mount(): void
    {
        $distribution = StudentExam::selectRaw('
                CAST((score / 10) AS INTEGER) * 10 AS bucket,
                COUNT(*) AS total
            ')
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->pluck('total', 'bucket');

        $this->labels = [];
        $this->scores = [];

        for ($i = 0; $i < 100; $i += 10) {

            $this->labels[] = "{$i}-" . ($i + 9);

            $this->scores[] = $distribution[$i] ?? 0;
        }

        // Handle perfect scores (100)
        $perfect = StudentExam::where('score', 100)->count();

        $this->labels[] = '100';
        $this->scores[] = $perfect;
    }

    public function render()
    {
        return view('livewire.dashboard.score-distribution');
    }
}