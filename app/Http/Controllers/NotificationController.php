<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    //Fonction pour marquer qu'une notification a été lue
    public function markAsRead($id){
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    //Fonction pour afficher toutes les notifications
    public function showAll(){
        $title = "Mon profil";
        $url='profileExpert';
        $user = Auth::user();
  
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('expert.notifications', compact('notifications', 'title', 'url', 'user'));
    }
}
