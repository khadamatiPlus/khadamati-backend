<?php

namespace App\Domains\Auth\Models\Traits\Method;

use App\Domains\Auth\Models\User;
use Illuminate\Support\Collection;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        return $this->id === 1;
    }

    /**
     * @return mixed
     */
    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isMerchantAdmin(): bool
    {
        return $this->hasRole(2);
    }

    /**
     * @return bool
     */
    public function isMerchantBranchAdmin(): bool
    {
        return $this->hasRole(4);
    }

    /**
     * @return bool
     */
    public function isCaptain(): bool
    {
        return $this->hasRole(3);
    }

    /**
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->hasRole(5);
    }

    /**
     * @return bool
     */
    public function isDeliveryAdmin():bool
    {
        return $this->hasRole(6);
    }

    /**
     * @return string
     */
    public function getUserType():string
    {
    if ($this->isCaptain()){

                return 'captain';
            }
                elseif($this->isMerchantAdmin()){
                return 'merchant_admin';
            }
//        if($this->isType(User::TYPE_ADMIN)){
//            if($this->isMerchantAdmin()){
//                return 'merchant_admin';
//            }
//            elseif ($this->isMerchantBranchAdmin()){
//                return 'merchant_branch_admin';
//            }
//            elseif ($this->isCaptain()){
//                echo 'ee';exit();
//                return 'captain';
//            }
//            else{
//                return 'admin';
//            }
//        }
        else{
            return 'customer';
        }
    }

    /**
     * @return mixed
     */
    public function isUser(): bool
    {
        return $this->type === self::TYPE_USER;
    }

    /**
     * @return mixed
     */
    public function hasAllAccess(): bool
    {
        return $this->isAdmin() && $this->hasRole(config('boilerplate.access.role.admin'));
    }

    /**
     * @param $type
     * @return bool
     */
    public function isType($type): bool
    {
        return $this->type === $type;
    }

    /**
     * @return mixed
     */
    public function canChangeEmail(): bool
    {
        return config('boilerplate.access.user.change_email');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function isSocial(): bool
    {
        return $this->provider && $this->provider_id;
    }

    /**
     * @return Collection
     */
    public function getPermissionDescriptions(): Collection
    {
        return $this->permissions->pluck('description');
    }

    /**
     * @param  bool  $size
     * @return mixed|string
     *
     * @throws \Creativeorange\Gravatar\Exceptions\InvalidEmailException
     */
    public function getAvatar($size = null)
    {
        return 'https://gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s='.config('boilerplate.avatar.size', $size).'&d=mp';
    }
}
