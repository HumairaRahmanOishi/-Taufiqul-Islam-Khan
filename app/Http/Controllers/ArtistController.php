<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;
use Carbon\Carbon;
use Session;
use Auth;
use Storage;

class ArtistController extends Controller
{
   
   public function showPlayer(Request $request)
    {
       return view('backend.artist_player');
    }  
    public function showAlbumList(Request $request)
    {
       $query=Album::where('status','!=',0)
                        ->where('artistId',Auth::guard('artist')->user()->id);

       if(isset($request->searchKey) && !is_null($request->searchKey))
         $query->where('name','like','%'.$request->searchKey.'%');

      $dataList=$query->paginate(30);

      return view('backend.artist_album_list',compact('dataList'));
    }
    public function addAlbumInfo(Request $request)
    {
       dd("okay");
    }
    public function updateAlbumInfo(Request $request)
    {
       $dataInfo=Album::find($request->searchKey);

       if(!empty($dataInfo)) {
       
         $dataInfo->name=$request->name;

         $dataInfo->genre=$request->genre;

         // $dataInfo->artistId=$request->artistId;

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
       $query=Song::with('albumInfo','albumInfo.artistInfo')
                     ->where('status','!=',0)
                        ->where('artistId',Auth::guard('artist')->user()->id);

       if(isset($request->searchKey) && !is_null($request->searchKey)){
          $query->where(function($q) use($request){
               $q->where('name','like','%'.$request->searchKey."%")
                        ->orWhere('albumId',$request->searchKey);
          });
       }
        

      $dataList=$query->paginate(30);

      return view('backend.artist_song_list',compact('dataList'));
    }
    public function addSongInfo(Request $request)
    {
       if($request->hasFile('song')){

         $song=$request->file('song');

           $songName = uniqid(). "." . $song->getClientOriginalExtension();

          if (!Storage::disk('public')->exists('songs')) {
              Storage::disk('public')->makeDirectory('songs');
          }

          $path=Storage::disk('public')->put('songs' , $song);

          // dd($path);

          // $path = $songName;

          $dataInfo=new Song();

          $dataInfo->name=$request->name;

          $dataInfo->description=$request->description;

          $dataInfo->length=$request->length;

          $dataInfo->musicUrl=$path;

          $dataInfo->albumId=$request->albumId;

          $dataInfo->artistId =Auth::guard('artist')->user()->id;

          $dataInfo->created_at=Carbon::now();

          if ($dataInfo->save()) {
             Session::flash("successMsg","A Song Added Successfully.");
          }
          else{
            Session::flash("warningMsg","Failed To Add Song.Please Try Again.");
          } 
       }
       else{
         Session::flash("errMsg","Choose A Song To Upload First.");
       }
       return redirect()->back();
    }
    public function updateSongInfo(Request $request)
    {
       dd("okay");
    }
    public function deleteSongInfo(Request $request)
    {
       dd("okay");
    }

    public function updateProfile(Request $request)
    {
       $profileInfo=Artist::find(Auth::guard('artist')->user()->id);

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
       $profileInfo=Artist::find(Auth::guard('artist')->user()->id);

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
