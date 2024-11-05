@props(['href' => '#', 'permission' => false])

<x-utils.link :href="$href" class="btn btn-success btn-sm" icon="fas fa-search" :text="__('View Wallet')" permission="{{ $permission }}" />
