<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Don;
use App\Models\User;
use App\Models\demande;


class ChartController extends Controller
{
    public function Chartjs(){
        $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aout', 'Sep', 'Oct', 'Nov', 'Dec');
        $dons = Don::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');

        // $dons = DB::table('dons')
        //             ->whereYear('created_at', date('Y'))
        //             ->whereMonth('created_at', '=', 01)
        //             ->groupBy(\DB::raw("Month(created_at)"))
        //             ->count();
        
        // $dons = DB::table('dons')
        //           ->select('age', DB::raw('count(*) as total'))
        //           ->groupBy('age')
        //           ->pluck('total', 'age')->all();
         $users  = User::select(\DB::raw("COUNT(*) as count"))
         ->whereYear('created_at', date('Y'))
         ->groupBy(\DB::raw("Month(created_at)"))
         ->pluck('count');
         $demandes  = demande::select(\DB::raw("COUNT(*) as count"))
         ->whereYear('created_at', date('Y'))
         ->groupBy(\DB::raw("Month(created_at)"))
         ->pluck('count');
        return view('chartjs',['Months' => $month, 'Data' => $dons, 'Data1' => $users, 'Data2' => $demandes]);
      }
}
