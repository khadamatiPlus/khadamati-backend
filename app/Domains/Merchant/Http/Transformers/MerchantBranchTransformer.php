<?php

namespace App\Domains\Merchant\Http\Transformers;

use App\Domains\Auth\Http\Transformers\UserTransformer;
use App\Domains\Merchant\Models\MerchantBranch;
use App\Domains\VibesVirtualWallet\Http\Transformers\VibesVirtualWalletTransformer;
use App\Enums\Core\MerchantBranchStatuses;
use App\Enums\Core\StoragePaths;
use Carbon\Carbon;

/**
 * Created by Amer
 * Author: Vibes Solutions
 * On: 3/8/2022
 * Class: MerchantBranchTransformer.php
 */
class MerchantBranchTransformer
{


    public function transform(MerchantBranch $merchantBranch): array
    {
        return [
            'id' => $merchantBranch->id,
            'name' => $merchantBranch->getAttributeValue('name') ?? '',
            'name_ar' => $merchantBranch->name_ar ?? '',
            'contact_email' => $merchantBranch->contact_email ?? '',
            'contact_phone_number' => $merchantBranch->contact_phone_number ?? '',
            'complex_number' => $merchantBranch->complex_number ?? '',
            'street_name' => $merchantBranch->street_name ?? '',
            'floor' => $merchantBranch->floor ?? '',
            'address_info' => $merchantBranch->address_info ?? '',
            'latitude' => $merchantBranch->latitude ?? '',
            'longitude' => $merchantBranch->longitude ?? '',
            'city_id' => $merchantBranch->city->id,
            'city_name' => $merchantBranch->city->name,
            'place_id' => $merchantBranch->place_id ?? '',
            'marker_image' => !empty($merchantBranch->marker_image)?storageBaseLink(StoragePaths::MERCHANT_BRANCH_MARKER_IMAGE.$merchantBranch->marker_image):'',
            'merchant_id' => $merchantBranch->merchant_id,
            'logo' => !empty($merchantBranch->merchant->logo)?storageBaseLink(StoragePaths::MERCHANT_LOGO.$merchantBranch->merchant->logo):'',
            'status' => $merchantBranch->status,
            'wallet' => (new VibesVirtualWalletTransformer)->transform($merchantBranch->wallet),
            'branch_access_list' => $merchantBranch->users->transform(function ($user){
                return (new UserTransformer)->transform($user);
            }),
            'working_hours' => $merchantBranch->merchantBranchHours->transform(function ($hour){
                return [
                    'id' => $hour->id,
                    'day' => $hour->day,
                    'from' => $hour->from_time,
                    'to' => $hour->to_time
                ];
            }),
            'merchant_branch_menu_images' => $merchantBranch->merchantBranchMenuImages->transform(function ($menuImage) {
                $image = !empty($menuImage->image) ? storageBaseLink(StoragePaths::MERCHANT_BRANCH_MENUS . $menuImage->image) : '';
                return $image;
            })->toArray(),
        ];
    }

    /**
     * @param MerchantBranch $merchantBranch
     * @return array
     */
    public function transformForMerchantBranchCashOut(MerchantBranch $merchantBranch): array
    {
        return [
            'id' => $merchantBranch->id,
            'branch'=>$merchantBranch->name,
            'merchant'=>$merchantBranch->merchant->business_name,
            'merchant_id'=>$merchantBranch->merchant->id,
            'out_standing_revenue'=>$merchantBranch->orders()->where('is_merchant_cashed_out','=','0')->where('status','=','5')->sum('merchant_revenue')
        ];
    }

    /**
     * @param MerchantBranch $merchantBranch
     * @return array
     */
    public function transformForCustomer(MerchantBranch $merchantBranch): array
    {
        if (!\Auth::id()) {
            return [
                'id' => $merchantBranch->id,
                'name' => $merchantBranch->name,
                'status' => $merchantBranch->availability,
                'latitude' => $merchantBranch->latitude,
                'longitude' => $merchantBranch->longitude,
                'status_name' => MerchantBranchStatuses::getLocalizedName($merchantBranch->availability),
                'distance' => $merchantBranch->distance,
                'number_of_coupons' => $merchantBranch->items->filter(function ($item) {
                    return $item->is_offer === 2 && $item->status === '1' && $item->itemVariations->isNotEmpty() && $item->itemVariations[0]->in_stock !=0 ;
                })->count(),
            'contact_phone_number' => $merchantBranch->contact_phone_number ?? '',
                'merchant_branch_menu_images' => $merchantBranch->merchantBranchMenuImages->transform(function ($menuImage) {
                    $image = !empty($menuImage->image) ? storageBaseLink(StoragePaths::MERCHANT_BRANCH_MENUS . $menuImage->image) : '';
                    return $image;
                })->toArray(),
            ];
        }
        else{
            return [
                'id' => $merchantBranch->id,
                'name' => $merchantBranch->name,
                'status' => $merchantBranch->availability,
                'latitude' => $merchantBranch->latitude,
                'longitude' => $merchantBranch->longitude,
                'status_name' => MerchantBranchStatuses::getLocalizedName($merchantBranch->availability),
                'distance' => $merchantBranch->distance,
                'number_of_coupons' => $merchantBranch->items->filter(function ($item) {
                    return $item->is_offer === 2 && $item->status === '1' && $item->itemVariations->isNotEmpty() && $item->itemVariations[0]->in_stock !=0;
                })->count(),
                'contact_phone_number' => $merchantBranch->contact_phone_number ?? '',
                'merchant_branch_menu_images' => $merchantBranch->merchantBranchMenuImages->transform(function ($menuImage) {
                    $image = !empty($menuImage->image) ? storageBaseLink(StoragePaths::MERCHANT_BRANCH_MENUS . $menuImage->image) : '';
                    return $image;
                })->toArray(),



            ];
        }
    }

}
