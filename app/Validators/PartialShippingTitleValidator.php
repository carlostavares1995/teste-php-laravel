<?php

namespace App\Validators;

use App\Interfaces\TitleValidator;
use Carbon\Carbon;

class PartialShippingTitleValidator implements TitleValidator
{
    public function validate(string $title): bool
    {
        $normalizedTitle = strtolower($title);
        $months = $this->getMonthsInPortuguese();

        foreach ($months as $month) {
            if (str_contains($normalizedTitle, $month)) {
                return true;
            }
        }

        return false;
    }

    private function getMonthsInPortuguese(): array
    {
        return array_map(function ($monthNumber) {
            return Carbon::createFromDate(null, $monthNumber, 1)->locale('pt_BR')->isoFormat('MMMM');
        }, range(1, 12));
    }
}
