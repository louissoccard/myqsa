<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QsaRecord extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }

    public function nights_away(): HasMany
    {
        return $this->hasMany(NightsAwayEvent::class);
    }

    public function icv_activities(): HasMany
    {
        return $this->hasMany(IcvActivity::class);
    }

    public function percentages(): array
    {
        return [
            'membership' => $this->membership_percentage(),
            'nights_away' => $this->nights_away_percentage(),
            'icv_list' => $this->icv_list_percentage(),
            'dofe' => $this->dofe_percentage(),
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

    private function membership_percentage(): int
    {
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

        return floor(min(100, (($explorerMonths + $networkMonths) / 18) * 100));
    }

    private function nights_away_percentage(): int
    {
        $camping = $this->nights_away->where('type', 'Camping')->sum('number_of_nights');
        $indoors = min(6, $this->nights_away->where('type', 'Indoors')->sum('number_of_nights'));

        return floor(min(100, (($camping + $indoors) / 18) * 100));
    }

    private function icv_list_percentage(): int
    {
        $international = min(2, $this->icv_activities->where('category', 'International')->count());
        $community = min(2, $this->icv_activities->where('category', 'Community')->count());
        $values = min(2, $this->icv_activities->where('category', 'Values')->count());
        $total = $international + $community + $values;

        $from_qsa_list = 4 + min(2, $this->icv_activities->where('part_of_csa', false)->count());
        $total = min($total, $from_qsa_list);

        return floor(min(100, ($total / 6) * 100));
    }

    private function dofe_percentage(): int
    {
        if ($this->dofe_completion !== null) return 100;

        $total = 0;

        foreach ([$this->dofe_volunteering, $this->dofe_physical, $this->dofe_skills, $this->dofe_expedition, $this->dofe_residential] as $value) {
            if ($value === 'In Progress') $total += 5;
            else if ($value === 'Complete') $total += 15;
        }

        return 35;
    }
}
