<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visa;
use App\Country;
use App\Images;
use App\Contact;
use App\NewsLetter;
use App\Airlines;
use App\Packages;
use App\Agents;
use App\AgentType;
use App\Visitor;
use App\Embassy;
use App\AgentCity;
use Session;
use \Validator;
use Carbon\Carbon;
use Mail;
use DB;
use Input;
class GeneralController extends Controller
{
    public $filePath = 'storage/uploads/images';
    public function home()
    {
        $data['total_visa'] = Visa::count();
        $data['contact'] = Contact::count();
        $data['packages'] = Packages::count();
        $data['airlines'] = Airlines::count();
        $data['embassies'] = Embassy::count();
        $data['agent_types'] = AgentType::all();
        $data['newsletter'] = NewsLetter::count();

        $data['sasti_ticket_visitors'] = Visitor::where('type', 'sasti_tickets')->count();
        $data['umrah_tickets_visitors'] = Visitor::where('type', 'umrah_tickets')->count();

        $totals = Visitor::select('type', DB::raw('COUNT(*) as total'))
            ->whereIn('type', [
                'job',
                'agent_job',
                'foreign_job',
                'sasti_tickets',
                'umrah_tickets'
            ])->distinct()
            ->groupBy('type')
            ->pluck('total', 'type');

        $data['job_visitors'] = $totals['job'] ?? 0;
        $data['agent_job_visitors'] = $totals['agent_job'] ?? 0;
        $data['foreign_job_visitors'] = $totals['foreign_job'] ?? 0;
        $data['sasti_ticket_visitors'] = $totals['sasti_tickets'] ?? 0;
        $data['umrah_tickets_visitors'] = $totals['umrah_tickets'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | TODAY COUNTS
        |--------------------------------------------------------------------------
        */

        $todayTotals = Visitor::select('type', DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', today())
            ->whereIn('type', [
                'job',
                'agent_job',
                'foreign_job',
                'sasti_tickets',
                'umrah_tickets'
            ])->distinct()
            ->groupBy('type')
            ->pluck('total', 'type');

        $data['today_job_visitors'] = $todayTotals['job'] ?? 0;
        $data['today_agent_job_visitors'] = $todayTotals['agent_job'] ?? 0;
        $data['today_foreign_job_visitors'] = $todayTotals['foreign_job'] ?? 0;
        $data['today_sasti_ticket_visitors'] = $todayTotals['sasti_tickets'] ?? 0;
        $data['today_umrah_tickets_visitors'] = $todayTotals['umrah_tickets'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | LAST 7 DAYS TOTAL COUNTS
        |--------------------------------------------------------------------------
        */

        $weekTotals = Visitor::select('type', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereIn('type', [
                'job',
                'agent_job',
                'foreign_job',
                'sasti_tickets',
                'umrah_tickets'
            ])->distinct()
            ->groupBy('type')
            ->pluck('total', 'type');

        $data['week_job_visitors'] = $weekTotals['job'] ?? 0;
        $data['week_agent_job_visitors'] = $weekTotals['agent_job'] ?? 0;
        $data['week_foreign_job_visitors'] = $weekTotals['foreign_job'] ?? 0;
        $data['week_sasti_ticket_visitors'] = $weekTotals['sasti_tickets'] ?? 0;
        $data['week_umrah_tickets_visitors'] = $weekTotals['umrah_tickets'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | UNIQUE VISITORS (OVERALL)
        |--------------------------------------------------------------------------
        */

        $otherTotal = Visitor::whereNotNull('type')
            ->where('type', '<>', 'agent')
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        $agentTotal = Visitor::where('type', 'agent')
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        $data['visitors'] = $otherTotal + $agentTotal;


        /*
        |--------------------------------------------------------------------------
        | UNIQUE VISITORS (TODAY)
        |--------------------------------------------------------------------------
        */

        $otherToday = Visitor::whereNotNull('type')
            ->where('type', '<>', 'agent')
            ->whereDate('created_at', today())
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        $agentToday = Visitor::where('type', 'agent')
            ->whereDate('created_at', today())
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        $data['today_visitors'] = $otherToday + $agentToday;


        /*
        |--------------------------------------------------------------------------
        | UNIQUE VISITORS (LAST 7 DAYS)
        |--------------------------------------------------------------------------
        */

        // $otherWeek = Visitor::whereNotNull('type')
        //     ->where('type', '<>', 'agent')
        //     ->where('created_at', '>=', Carbon::now()->subDays(7))
        //     ->whereNotNull('ip')
        //     ->distinct('ip')
        //     ->count('ip');

        $data['week_visitors'] = Visitor::where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        // $data['week_visitors'] = $otherWeek + $agentWeek;


        /*
        |--------------------------------------------------------------------------
        | DAILY STATS FOR LAST 7 DAYS
        |--------------------------------------------------------------------------
        */

        $dailyStats = Visitor::select(
            DB::raw('DATE(created_at) as date'),
            'type',
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->whereDate('created_at', '<', Carbon::today())
            ->whereIn('type', [
                'job',
                'agent_job',
                'foreign_job',
                'sasti_tickets',
                'umrah_tickets'
            ])
            ->groupBy(DB::raw('DATE(created_at)'), 'type')
            ->orderBy(DB::raw('DATE(created_at)'), 'DESC')
            ->get();

        $data['daily_chart'] = [];

     for ($i = 1; $i <= 6; $i++) {

    $date = Carbon::now()->subDays($i)->format('Y-m-d');

    $data['daily_chart']['job'][$date] = 0;
    $data['daily_chart']['agent_job'][$date] = 0;
    $data['daily_chart']['foreign_job'][$date] = 0;
    $data['daily_chart']['sasti_tickets'][$date] = 0;
    $data['daily_chart']['umrah_tickets'][$date] = 0;
}
        foreach ($dailyStats as $row) {
            $data['daily_chart'][$row->type][$row->date] = $row->total;
        }
  

      
        $data['agent'] = Agents::count();
        $data['verified_agent'] = Agents::where('verified', 1)->count();
        $data['non_verified_agent'] = Agents::where('verified', 0)->count();
        $data['agent_cities'] = AgentCity::withCount('agents')
            ->whereHas('agents')
            ->orderByDesc('agents_count')
            ->get();
        return view("admin.home", $data);
    }
    public function manageHomeSidebar()
    {
        $data['list'] = Visa::whereNotNull('id')->get(['id', 'title', 'is_home']);

        return view("admin.pages.manage-home-sidebar", $data);
    }

    public function saveHomeSidebar(Request $req)
    {
        $visa = Visa::where('id', $req->id)->first();
        $visa->is_home = $req->is_home;
        $isSave = $visa->save();
        if ($isSave) {
            return response()->json(["notify" => true, "msg" => "Success"]);
        } else {
            return response()->json(["notify" => false, "msg" => "Fail"]);
        }
    }
    public function saveHomecountries(Request $req)
    {
        $visa = Country::where('id', $req->id)->first();
        $visa->is_home = $req->is_home;
        $isSave = $visa->save();
        if ($isSave) {
            return response()->json(["notify" => true, "msg" => "Success"]);
        } else {
            return response()->json(["notify" => false, "msg" => "Fail"]);
        }
    }
    public function newsLetter()
    {
        $data['newsletter'] = Newsletter::orderBy('id', 'DESC')->paginate(10);

        return view("admin.pages.newsletter", $data);
    }
    public function contact()
    {
        $data['contact'] = Contact::orderBy('id', 'DESC')->paginate(10);

        return view("admin.pages.contact", $data);
    }

    public function deleteContact($id)
    {
        $data['contact'] = Contact::all();
        $delete = Contact::where('id', $id)->delete();
        if ($delete) {
            Session::flash("success-msg", "Request Deleted Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }
        return redirect()->to('admin/contact');
    }
    public function sendReply()
    {
        $validator = Validator::make(Input::all(), [
            'reply' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash("error-msg", "Missing required field");
            return redirect()->back();
        }
        $id = Input::has("id") ? Input::get("id") : "";
        $email = Input::has("email") ? Input::get("email") : "";
        $reply = Input::has("reply") ? Input::get("reply") : "";

        $contact = Contact::where('id', $id)->first();
        $contact->reply = $reply;
        $saved = $contact->save();

        $subject = $contact->subject;
        if ($saved) {

            $data = [
                "subject" => $subject,
                "msg" => $reply,
            ];

            $myemail = $email;

            Mail::send('emails.reply', $data, function ($message) use ($myemail, $subject) {
                $message->subject($subject);
                $message->from(config('mail.from.address', 'noreply@agents.com.pk'), config('mail.from.name', 'Agents PK'));
                $message->to($myemail, 'Inquiry Response');
            });


            Session::flash("success-msg", "Completed Successfully.");
            return redirect()->to('admin/contact');
        } else {

            Session::flash("error-msg", "Something went wrong. Try again.");
            return redirect()->back();

        }
    }
    public function getImages()
    {
        $data['images'] = Images::all();

        return view("admin.pages.manage-images", $data);
    } //

    public function addImages()
    {
        return view("admin.pages.add-image");
    } //
    public function editImages($id)
    {

        $data['detail'] = Images::where('id', $id)->first();
        return view("admin.pages.add-image", $data);
    } //
    public function saveImages(Request $req)
    {
        if (empty($req->id)) {
            $validator = Validator::make(Input::all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Session::flash("error-msg", $validator->messages()->first());
                return redirect()->back()->withInput(Input::all());
            }
        }
        if (is_null($req->id)) {
            $image = new Images;
        } else {
            $image = Images::where('id', $req->id)->first();
        }

        if (!empty($req->image)) {
            $filename = Input::file('image')->getClientOriginalName();
            $value = $fileNewName = Guid() . "-" . preg_replace('/\s/', '-', $filename);
            Input::file('image')->move($this->filePath, $fileNewName);

            $image->image = $fileNewName;
        }
        $image->image_alt = $req->image_alt;
        $isSave = $image->save();

        if ($isSave) {
            Session::flash("success-msg", "Completed Successfully.");
        } else {
            Session::flash("error-msg", "Something went wrong. Try again.");
        }

        return redirect()->route('admin.images');
    }
    public function reply($id)
    {

        $data['detail'] = Contact::where('id', $id)->first();
        return view("admin.pages.reply", $data);
    }
}
