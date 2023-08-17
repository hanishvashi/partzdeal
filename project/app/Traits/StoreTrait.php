<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Stores;

trait StoreTrait {

  public function getStoreCode($store_id)
  {
     $store = Stores::where('id',$store_id)->first();
     return $store['store_code'];
  }

  public function getStoreDetail($store_id)
  {
    $store = Stores::where('id',$store_id)->first();
    return $store;
  }

  public function getCurrentStoreLocation($ip)
  {
    if($_SERVER['SERVER_NAME']=='localhost')
    {
      return $this->getStoreDetail(3); // Set default to India on LocalHost server
    }else{
      $currentUserInfo = Location::get($ip);
      if($currentUserInfo->countryName=='India')
      {
        return $this->getStoreDetail(1);
      }elseif($currentUserInfo->countryName=='Australia')
      {
        return $this->getStoreDetail(2);
      }elseif($currentUserInfo->countryName=='United States')
      {
        return $this->getStoreDetail(3);
      }else{
        return $this->getStoreDetail(3);
      }
      
    }

  }

}
