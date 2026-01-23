<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CandidateStatus;

class CandidateRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Candidate();
    }

    public function summary(): array
    {
        $newCandidates = $this->countAllNewCandidates();
        $appliedCandidates = $this->countAllAppliedCandidates();

        return [
            'new_candidates' => $newCandidates,
            'applied_candidates' => $appliedCandidates,
        ];
    }

    /**
     * Get count all new candidates with status applied, interviewed
     */
    public function countAllNewCandidates(): int
    {
        return $this->newQuery()
            ->whereIn('status', [CandidateStatus::APPLIED, CandidateStatus::INTERVIEWED])
            ->count();
    }

    /**
     * Get count all candidates with status applied
     */
    public function countAllAppliedCandidates(): int
    {
        return $this->newQuery()
            ->where('status', CandidateStatus::APPLIED)
            ->count();
    }
}
