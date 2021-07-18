<?php

namespace App\Services\Lot;

use App\Http\Requests\StoreLotRequest;
use App\Models\Lot;
use App\Models\LotImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreService
{
    public function __construct(StoreLotRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Store a new lot.
     */
    public function storeLot()
    {
        $lot = new Lot;
        $lot->user_id = Auth::id();
        $this->saveLot($lot);
        $this->saveImages($lot->id);
    }

    /**
     * Update an existing lot.
     * @param int $id
     */
    public function updateLot(int $id)
    {
        $lot = Lot::findOrFail($id);

        Gate::authorize('edit-lot', $lot);

        $this->saveLot($lot);
        $this->saveImages($lot->id);
    }

    /**
     * Save lot in the storage.
     * @param Lot $lot
     */
    private function saveLot(Lot $lot)
    {
        $lot->name = $this->request->title;
        $lot->description = $this->request->description;
        $lot->start_price = $this->request->price;
        $lot->save();
    }

    /**
     * Save images for the lot.
     * @param int $lotId
     */
    private function saveImages(int $lotId)
    {
        if (!empty($this->request->image)) {
            foreach ($this->request->image as $image) {
                $lotImage = new LotImage;
                $lotImage->path = $image->store('lots', 'public');
                $lotImage->lot_id = $lotId;
                $lotImage->save();
            }
        }
    }
}
