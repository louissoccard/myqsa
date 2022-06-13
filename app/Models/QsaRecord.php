<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QsaRecord extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }

    public function percentages(): array {
        return [
            'membership' => $this->membership_percentage(),
            'nights_away' => 0,
            'icv_list' => 0,
            'dofe' => 0,
            'presentation' => 0,
        ];
    }

    private function calculate_difference_between_dates_in_months(\DateTime $date1, \DateTime $date2): int
    {
        $months = 0;
        $editableDate = new \DateTime($date2->format('Y-m-d'));

        while ($date1 < $editableDate) {
            $months += 1;
            $editableDate->modify('-1 month');
        }

        return max(0, $months - 1);
    }

    private function membership_percentage(): int {
        $explorerMonths = 0;
        $networkMonths = 0;

        $sixteenthBirthday = (new \DateTime($this->date_of_birth))->modify('16 years');
        $eighteenthBirthday = (new \DateTime($this->date_of_birth))->modify('18 years');
        $twentyFifthBirthday = (new \DateTime($this->date_of_birth))->modify('25 years');

        if ($this->explorers_start !== null) {
            $startDate = max($sixteenthBirthday, new \DateTime($this->explorers_start));
            $endDate = $this->explorers_end !== null ? new \DateTime($this->explorers_end) : new \DateTime();
            $endDate = min($eighteenthBirthday, $endDate);

            $explorerMonths = $this->calculate_difference_between_dates_in_months($startDate, $endDate);
        }

        if ($this->network_start !== null) {
            $startDate = max($eighteenthBirthday, new \DateTime($this->network_start));
            $endDate = $this->network_end !== null ? new \DateTime($this->network_end) : new \DateTime();
            $endDate = min($twentyFifthBirthday, $endDate);

            $networkMonths = $this->calculate_difference_between_dates_in_months($startDate, $endDate);
        }

        return min(100, (($explorerMonths + $networkMonths) / 18) * 100);
    }
}
