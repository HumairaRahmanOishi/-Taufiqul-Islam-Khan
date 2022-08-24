<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayList;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Admin;
use App\Models\Listerner;
use App\Models\Package;
use App\Models\PurchaseHistory;
use App\Models\Role;
use Carbon\Carbon;
use Toastr;
use Session;
use Auth;
use Hash;

class AdminController extends Controller
{
   public function logout(Request $request)
   {
      Auth::guard('admin')->logout();

      return redirect()->route('loginPage');
   }
   public function showPackagePurchaseHistory (Request $request)
   {
      $query=PurchaseHistory::with('packageInfo','listernerInfo')->where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('tranxId','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.admin_package_purchase_history',compact('dataList'));
   }
    public function showPlayer(Request $request)
    {
       return view('backend.admin_player');
    }
    public function showPackageList(Request $request)
    {
       $query=Package::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('title','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.admin_package_list',compact('dataList'));
    }
    public function addPackageInfo(Request $request)
    {
      
      $dataInfo=new Package();

      $dataInfo->title=$request->title;

      $dataInfo->description=$request->description;

      $dataInfo->price=$request->price;

      $dataInfo->validate=$request->validate;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updatePackageInfo(Request $request)
    {
       $dataInfo=Package::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->title=$request->title;

         $dataInfo->description=$request->description;

         $dataInfo->price=$request->price;

         $dataInfo->validate=$request->validate;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deletePackageInfo(Request $request)
    {
       $dataInfo=Package::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Package Info Deleted Successfully.");

       return redirect()->back();
    }




    public function showAdminList(Request $request)
    {
       $query=Admin::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey)){
         $query->where(function($q) use($request){
            $query->where('name','like','%'.$request->searchKey.'%')
                     ->orWhere('email','like','%'.$request->searchKey.'%');
         });
       }

      $dataList=$query->paginate(30);

      return view('backend.admin_list',compact('dataList'));
    }
    public function addAdminInfo(Request $request)
    {
         $dataInfo=new Admin();

         $dataInfo->name=$request->name;

         $dataInfo->email=strtolower(trim($request->email));

         $dataInfo->phone=$request->phone;

         $dataInfo->created_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Saved Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
         };

         return redirect()->back();
    }
    public function updateAdminInfo(Request $request)
    {
       $dataInfo=Admin::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->email=strtolower(trim($request->email));

         $dataInfo->phone=$request->phone;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteAdminInfo(Request $request)
    {
       $dataInfo=Admin::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Admin Info Deleted Successfully.");

       return redirect()->back();
    }



    public function showArtistList(Request $request)
    {
       $query=Artist::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey)){
         $query->where(function($q) use($request){
            $query->where('name','like','%'.$request->searchKey.'%')
                     ->orWhere('email','like','%'.$request->searchKey.'%');
         });
       }

      $dataList=$query->paginate(30);

      return view('backend.admin_artist_list',compact('dataList'));
    }
    public function addArtistInfo(Request $request)
    {
       $dataInfo=new Artist();

      $dataInfo->name=$request->name;

      $dataInfo->email=strtolower(trim($request->email));

      $dataInfo->phone=$request->phone;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updateArtistInfo(Request $request)
    {
      $dataInfo=Artist::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->email=strtolower(trim($request->email));

         $dataInfo->phone=$request->phone;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteArtistInfo(Request $request)
    {
       $dataInfo=Artist::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Artist Info Deleted Successfully.");

       return redirect()->back();
    }



    public function showListernerList(Request $request)
    {
       $query=Listerner::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey)){
         $query->where(function($q) use($request){
            $query->where('name','like','%'.$request->searchKey.'%')
                     ->orWhere('email','like','%'.$request->searchKey.'%');
         });
       }

      $dataList=$query->paginate(30);

      return view('backend.admin_listerner_list',compact('dataList'));
    }
    public function addListernerInfo(Request $request)
    {
       $dataInfo=new Listerner();

      $dataInfo->name=$request->name;

      $dataInfo->email=strtolower(trim($request->email));

      $dataInfo->phone=$request->phone;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updateListernerInfo(Request $request)
    {
      $dataInfo=Listerner::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->email=strtolower(trim($request->email));

         $dataInfo->phone=$request->phone;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteListernerInfo(Request $request)
    {
       $dataInfo=Listerner::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Listerner Info Deleted Successfully.");

       return redirect()->back();
    }


    public function showAlbumList(Request $request)
    {
       $query=Album::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('name','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.admin_album_list',compact('dataList'));
    }
    public function addAlbumInfo(Request $request)
    {
      $dataInfo=new Album();

      $dataInfo->name=$request->name;

      $dataInfo->genre=$request->genre;

      $dataInfo->artistId=$request->artistId;

      $dataInfo->releaseDate=$request->releaseDate;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updateAlbumInfo(Request $request)
    {
       $dataInfo=Album::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->genre=$request->genre;

         $dataInfo->artistId=$request->artistId;

         $dataInfo->releaseDate=$request->releaseDate;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteAlbumInfo(Request $request)
    {
       $dataInfo=Album::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();
       
       // Toastr::info('Album Deleted Successfully.', 'Deleted', ["positionClass" => "toast-top-center"]);

       Session::flash('errMsg',"Album Deleted Successfully.");

       return redirect()->back();
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

      return view('backend.admin_song_list',compact('dataList'));
    }
    public function addSongInfo(Request $request)
    {
      $dataInfo=new Song();

      $dataInfo->name=$request->name;

      $dataInfo->description=$request->description;

      $dataInfo->length=$request->length;

      $dataInfo->musicUrl=$request->musicUrl;

      $dataInfo->albumId=$request->albumId;

      $dataInfo->artistId=$request->artistId;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updateSongInfo(Request $request)
    {
       $dataInfo=Song::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->description=$request->description;

         $dataInfo->length=$request->length;

         $dataInfo->musicUrl=$request->musicUrl;

         $dataInfo->albumId=$request->albumId;

         $dataInfo->artistId=$request->artistId;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteSongInfo(Request $request)
    {
       $dataInfo=Song::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Song Deleted Successfully.");

       return redirect()->back();
    }

    public function showPlaylistList(Request $request)
    {
       $query=PlayList::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('name','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.admin_playlist_list',compact('dataList'));
    }
    public function addPlaylistInfo(Request $request)
    {
      $dataInfo=new PlayList();

      $dataInfo->name=$request->name;

      $dataInfo->listernerId=$request->listernerId;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updatePlaylistInfo(Request $request)
    {
      $dataInfo=PlayList::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->listernerId=$request->listernerId;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deletePlaylistInfo(Request $request)
    {
       $dataInfo=PlayList::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Data Deleted Successfully.");

       return redirect()->back();
    }

    public function showRoleList(Request $request)
    {
       $query=Role::where('status','!=',0);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('roleName','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.admin_role_list',compact('dataList'));
    }
    public function addRoleInfo(Request $request)
    {
       $dataInfo=new PlayList();

      $dataInfo->roleName=$request->roleName;

      $dataInfo->created_at=Carbon::now();

      if($dataInfo->save()){
         Session::flash('successMsg','Data Saved Successfully.');
      }
      else{
         Session::flash('warningMsg','Failed To Save Data.Please Try Again.');
      };

      return redirect()->back();
    }
    public function updateRoleInfo(Request $request)
    {
       $dataInfo=Role::find($request->searchKey);

       if(!empty($dataInfo)) {

         $dataInfo->roleName=$request->roleName;

         $dataInfo->updated_at=Carbon::now();

         if($dataInfo->save()){
            Session::flash('successMsg','Data Updated Successfully.');
         }
         else{
            Session::flash('warningMsg','Failed To Update Data.Please Try Again.');
         }
       }
       else{
         Session::flash('warningMsg','Request Data Not Found.Please Try Again.');
       }       
       return redirect()->back();
    }
    public function deleteRoleInfo(Request $request)
    {
       $dataInfo=Admin::find($request->searchKey);
       
       $dataInfo->status=0;

       $dataInfo->deleted_at=Carbon::now();

       $dataInfo->save();

       Session::flash('errMsg',"Role Info Deleted Successfully.");

       return redirect()->back();
    }
    public function setPermission(Request $request)
    {
       dd("okay");
    }

    public function updateProfile(Request $request)
    {
       $profileInfo=Admin::find(Auth::guard('admin')->user()->id);

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
       $profileInfo=Admin::find(Auth::guard('admin')->user()->id);

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
