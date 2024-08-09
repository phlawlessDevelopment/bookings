<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Chalet;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Bookings extends Component
{
    public $seperate = false;
    public $fromDate;
    public $toDate;
    public $futureFrom;
    public $futureTo;
    public $nCats = 1;
    public $nChalets = 1;
    public $available_chalets = [];
    public $message;
    public $valid = false;
    public $showFutureBtn = false;
    public $maxChalets = 0;


    public function render()
    {
        return view('livewire.bookings');
    }

    public function mount()
    {
        $this->fromDate = Carbon::now()->toDateString();
        $this->toDate = Carbon::now()->addDay()->toDateString();
        $this->maxChalets = Chalet::all()->count();
        $this->checkAvailability();
    }

    public function findNextAvailableTimeSlot($daysRequired)
    {
        $date = Carbon::today();
        while (true) {
            $availableChalets = Chalet::availableBetween($date, $date->copy()->addDays($daysRequired))->count();
            $endDate = $date->copy()->addDays($daysRequired);
            if ($availableChalets >= $this->nChalets) {
                return [$date->toFormattedDateString(), $date->toDateString(), $endDate->toDateString()];
            }

            $date->addDay();
        }
    }
    private function checkAvailability()
    {

        $startDate = Carbon::parse($this->fromDate);
        $endDate =  Carbon::parse($this->toDate);

        $this->available_chalets = Chalet::availableBetween($startDate, $endDate)->get()->toArray();
        $n_avail_chalets = count($this->available_chalets);

        if ($n_avail_chalets < $this->nChalets) {
            $this->valid = false;
            $nDays = $startDate->diffInDays($endDate);
            [$s, $sd, $ed] =  $this->findNextAvailableTimeSlot($nDays);
            $this->futureFrom = $sd;
            $this->futureTo = $ed;
            $this->message = "We have " . ($n_avail_chalets === 0 ? "no" : $n_avail_chalets) . " chalets available for that date range. The Next available timeslot begins on "  . $s;
            $this->showFutureBtn = true;
        } else {
            $this->valid = true;
            $this->message = "";
            $this->showFutureBtn = false;
        }
    }

    #[Computed]
    public function fromDateFormatted()
    {
        return Carbon::parse($this->fromDate)->toFormattedDateString();
    }

    public function updatedFromDate()
    {
        $startDate = Carbon::parse($this->fromDate);
        $endDate =  Carbon::parse($this->toDate);

        if ($startDate > $endDate) {
            $this->message = "Please input a valid date";
            $this->valid = false;
        } else {
            $this->checkAvailability();
        }
    }

    public function updatedToDate()
    {
        $startDate = Carbon::parse($this->fromDate);
        $endDate =  Carbon::parse($this->toDate);

        if ($startDate > $endDate) {
            $this->message = "Please input a valid date";
            $this->valid = false;
        } else {
            $this->checkAvailability();
        }
    }

    public function updatedNChalets()
    {
        if ($this->nChalets > $this->maxChalets) {
            $this->message = "Our cattery only has " . $this->maxChalets . " chalets.";
            $this->valid = false;
        } elseif ($this->nChalets > $this->nCats) {
            $this->message = "Number of chalets must be less than or equal to the number of cats";
            $this->valid = false;
        } else {
            $this->checkAvailability();
        }
    }

    public function updatedNCats()
    {
        if ($this->nCats > $this->nChalets * 3) {
            $this->message = "Our chalets can accomidate a maximum of 3 cats each";
            $this->valid = false;
        } else {
            $this->checkAvailability();
        }
    }

    public function book()
    {
        Booking::factory()->createOne([
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'user_id' => 1,
        ])->chalets()->attach(array_map(fn ($c) => $c["id"], array_slice($this->available_chalets, 0, $this->nChalets)));
        $this->available_chalets = [];
        $this->nCats = 1;
        $this->nChalets = 1;
        $this->fromDate = Carbon::now()->toDateString();
        $this->toDate = Carbon::now()->addDay()->toDateString();
    }

    public function setFutureDate()
    {
        $this->fromDate = $this->futureFrom;
        $this->toDate = $this->futureTo;
        $this->checkAvailability();
    }
}
