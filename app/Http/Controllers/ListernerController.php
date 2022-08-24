<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayList;
use App\Models\Song;
use App\Models\Listerner;
use App\Models\Package;
use App\Models\PurchaseHistory;
use App\Models\PlayListSong;
use Carbon\Carbon;
use Auth;
use Session;
use Hash;

class ListernerController extends Controller
{
   public function logout(Request $request)
   {
      Auth::guard('listerner')->logout();

      return redirect()->route('loginPage');
   }
   public function showPackagePurchaseHistory (Request $request)
   {
      $query=PurchaseHistory::with('packageInfo','listernerInfo')
                              ->where('status','!=',0)
                                 ->where('listernerId',Auth::guard('listerner')->user()->id);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('tranxId','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.listerner_package_purchase_history',compact('dataList'));
   }

   public function showSongList(Request $request)
   {
      $query=Song::with('albumInfo','albumInfo.artistInfo')->where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey)){
          $query->where(function($q) use($request){
               $q->where('name','like','%'.$request->searchKey."%")
                        ->orWhere('albumId',$request->searchKey);
          });
       }
        

      $dataList=$query->paginate(30);

      return view('backend.listerner_song_list',compact('dataList'));
   }
    public function showPlayer(Request $request)
    {
       return view('backend.listerner_player');
    }    
    
    public function addPlayList(Request $request)
    {
       dd("okay");
    }
    public function showPlaylistList(Request $request)
    {
      $query=PlayList::where('status','!=',0)
                        ->where('listernerId',Auth::guard('listerner')->user()->id);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('name','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.listerner_playlist_list',compact('dataList'));
    }
    public function addSongToPlayList(Request $request)
    {
       $dataInfo=new PlayListSong();

       $dataInfo->playlistId=$request->playlistId;

       $dataInfo->songId=$request->songId;

       $dataInfo->created_at=Carbon::now();

       if($dataInfo->save())
         Session::flash('successMsg',"Song Added To Play List.");
      else
         Session::flash('warningMsg','Failed To Add Song To Play List.');

      return redirect()->back();


    }
    public function removeSongFromPlayList(Request $request)
    {
       dd("okay");
    }
    public function deletePlayList(Request $request)
    {
       dd("okay");
    }
    public function showPackages(Request $request)
    {
       $query=Package::where('status','!=',0);;

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('title','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.listerner_package_list',compact('dataList'));
    }
    public function buyPackage(Request $request)
    {
       dd("okay");
    }
    public function packagePurchaseHistory(Request $request)
    {
       $query=PurchaseHistory::with('packageInfo','listernerInfo')
                                 ->where('status','!=',0)
                                    ->where('listernerId',Auth::guard('listerner')->user()->id);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('tranxId','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.listerner_package_purchase_history',compact('dataList'));
    }
    
   public function updateProfile(Request $request)
    {
       $profileInfo=Listerner::find(Auth::guard('listerner')->user()->id);

       if(!empty($profileInfo)) {
       
         $profileInfo->name=$request->name;

         $profileInfo->email=strtolower(trim($request->email));

         $profileInfo->phone=$request->phone;

         $profileInfo->updated_at=Carbon::now();

         if($profileInfo->save()){
            Session::flash('successMsg','Profile Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Profile.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }     
       return redirect()->back();  
    }
    public function changePassword(Request $request)
    {
       $profileInfo=Listerner::find(Auth::guard('listerner')->user()->id);

       if(!empty($profileInfo)) {
       
         if($request->password==$request->conPassword){

            $profileInfo->password=Hash::make($request->password);

            $profileInfo->updated_at=Carbon::now();

            if($profileInfo->save()){
               Session::flash('successMsg','Password Changed Successfully.');
            }
            else{
               Session::flash('warningMsg','Failed To Change Password.Please Try Again.');
            }
         }
         else{
            Session::flash('warningMsg','Confirm Password First.');
         }

         
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       } 
     return redirect()->back();  
    }


    public function updateProfileForm()
    {
       return view('backend.profile_update_form');
    }

    public function changePasswordForm()
    {
       return view('backend.change_password_form');
    }
}
