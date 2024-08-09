<div class="min-h-screen bg-gray-100 p-0 sm:p-12">
  <div class="mx-auto max-w-md px-6 py-12 bg-white border-0 shadow-lg sm:rounded-3xl">
    <h1 class="text-2xl font-bold mb-8">Book a chalet</h1>

<div class="flex flex-row space-x-4">
        <div class="relative z-0 w-full mb-5">
          <input
            type="date"
            name="from-date"
            wire:model.change="fromDate"
            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
          />
          <label for="from-date" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">From</label>
          <span class="text-sm text-red-600 hidden" id="error">From is required</span>
        </div>
        <div class="relative z-0 w-full mb-5">
          <input
            type="date"
            name="to-date"
            wire:model.change="toDate"
            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
          />
          <label for="to-date" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">To</label>
          <span class="text-sm text-red-600 hidden" id="error">From is required</span>
        </div>
        </div>

      <div class="relative z-0 w-full mb-5">
        <input
          type="number"
          name="nCats"
          wire:model.change="nCats"
          class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
        />
        <label for="nCats" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Number of cats</label>
      </div>
        <div class="z-0 w-full mb-5 flex flex-row items-center gap-6">
        <input
          type="checkbox"
          name="seperate"
          value="seperate"
          wire:model.live="seperate"
        />
        <span class="text-gray-500">Seperate chalets?</span>
      </div>
@if($seperate)
<div class="relative z-0 w-full mb-5">
        <input
          type="number"
          name="n-chalets"
          wire:model.change="nChalets"
          class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
        />
        <label for="n-chalets" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Number of chalets</label>
      </div>

@endif
<h2 class="text-xl font-bold mb-8">{{$message}} </h2>
@if($valid)
      <button
        id="btn"
        wire:click="book"
        class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-pink-500 hover:bg-pink-600 hover:shadow-lg focus:outline-none"
      >
      Book {{$nChalets}} {{ $nChalets > 1 ? "chalets" : "chalet"}} for {{ $this->fromDateFormatted }}
      </button>
@endif
@if($showFutureBtn)
      <button
        id="f-btn"
        wire:click="setFutureDate"
        class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-blue-500 hover:bg-blue-600 hover:shadow-lg focus:outline-none"
      >
      See Timeslot
      </button>
@endif

  </div>
</div>


