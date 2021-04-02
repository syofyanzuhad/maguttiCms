<?php


namespace App\maguttiCms\Domain\Store;




use App\maguttiCms\Definition\Definition;
use App\maguttiCms\Website\Facades\StoreHelper;

trait CartStepTrait
{


    function hasStep()
    {
        if($this->isEmpty()) return false;
        $step = $this->getLastSegment();
        if ($step === Definition::CART_STEP_PAYMENT) {
            if (!$this->shipping_address_id) return false;
        }
        if ($step === Definition::CART_STEP_RESUME) {

            if (!$this->shipping_address_id || !$this->payment_method_id || !$this->payment_method_id) return false;
        }
        return $step;

    }

    function getLastSegment():string
    {
        return collect(request()->segments())->last();
    }

    /**
     * @return bool
     */
    function displayShippingCost(): bool
    {

        if(!StoreHelper::isShippingEnabled()) return false;
        return ($this->getLastSegment() === Definition::CART_STEP_RESUME);
    }

    /**
     * @return false|float|int
     */
    function displayTotal()
    {
        if($this->displayShippingCost()) return $this->cartGrandTotal();
        return $this->getTotalProductsWithDiscount();
    }

}