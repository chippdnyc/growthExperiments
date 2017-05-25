<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Experiment;

use App\Http\Requests\ExperienceFormRequest;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class ExperimentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiments = Experiment::where('archived', '=', false)
                                    ->orderBy('pr_priority', 'asc')
                                    ->orderBy('phase', 'asc')
                                    ->orderBy('due_date', 'asc')
                                    ->paginate(7);

        return view('experiments/list')->with('experiments', $experiments);
    }

    /**
     * Display a listing of the resource (reports).
     *
     * @return \Illuminate\Http\Response
     */
    public function reports()
    {
        $params = str_replace("?", '#', \Request::getQueryString());
        $params = str_replace("&", '#', $params);
        $params = str_replace("=", '#', $params);
        $params = explode('#', $params);

        $date       = \Request::get('date');
        $phase      = \Request::get('phase');
        $priority   = \Request::get('priority');
        $startdate  = null;
        $enddate    = null;
        $url        = null;

        if (count($params) > 1) {
            foreach ($params as $key => $param) {
                if ($key == 0) {
                    $url = '?'.$param.'=';
                } else if ($key == 2) {
                    $url = $url.'&'.$param.'=';
                } else if ($key == 4) {
                    $url = $url.'&'.$param.'=';
                } else {
                    $url = $url.$param.'&';
                }
            }
        } else {
            $url = '?';
        }

        switch ($date) {
            case 'last3months':
                $startdate  = new Carbon('first day of 3 months ago 00:00:00');
                $enddate    = new Carbon('last day of this month 23:59:59');
                break;
            case 'lastmonth':
                $startdate  = new Carbon('first day of last month 00:00:00');
                $enddate    = new Carbon('last day of last month 23:59:59');
                break;
            case 'thismonth':
                $startdate  = new Carbon('first day of this month 00:00:00');
                $enddate    = new Carbon('last day of this month 23:59:59');
                break;
            case 'lastweek':
                $startdate  = new Carbon('monday last week 00:00:00');
                $enddate    = new Carbon('sunday last week 23:59:59');
                break;
            case 'thisweek':
                $startdate  = new Carbon('monday this week 00:00:00');
                $enddate    = new Carbon('sunday this week 23:59:59');
                break;
            default:
                $date = null;
                break;
        }

        if ($date && $priority && $phase) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->whereBetween('created_at', [$startdate, $enddate])
                                        ->where('pr_priority', $priority)
                                        ->where('phase', $phase)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($date && $priority) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->whereBetween('created_at', [$startdate, $enddate])
                                        ->where('pr_priority', $priority)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($date && $phase) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->whereBetween('created_at', [$startdate, $enddate])
                                        ->where('phase', $phase)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($date) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->whereBetween('created_at', [$startdate, $enddate])
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($priority && $phase) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->where('pr_priority', $priority)
                                        ->where('phase', $phase)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($priority) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->where('pr_priority', $priority)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else if ($phase) {
            $experiments = Experiment::where('archived', '=', false)
                                        ->where('phase', $phase)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        } else {
            $experiments = Experiment::where('archived', '=', false)
                                        ->orderBy('pr_priority', 'asc')
                                        ->orderBy('phase', 'asc')
                                        ->orderBy('due_date', 'asc')
                                        ->paginate(7);
        }

        return view('experiments/reports')->with(['experiments' => $experiments, 'params' => $url]);
    }

    /**
     * Display a listing of the resource (search).
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $search = \Request::get('search');

        $experiments = Experiment::where('name', 'like', '%'.$search.'%')
                                    ->orWhere('tags', 'like', '%'.$search.'%')
                                    ->orderBy('pr_priority', 'asc')
                                    ->orderBy('phase', 'asc')
                                    ->orderBy('due_date', 'asc')
                                    ->paginate(7);

        return view('experiments/search')->with('experiments', $experiments);
    }

    /**
     * Display a listing of the resource (archived).
     *
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $experiments = Experiment::where('archived', '=', true)
                                 ->orderBy('pr_priority', 'desc')
                                 ->orderBy('phase', 'asc')
                                 ->orderBy('due_date', 'asc')
                                 ->paginate(7);

        return view('experiments/archived')->with('experiments', $experiments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('experiments/create')->with('selects', array(   'phases' => Experiment::getPhases(),
                                                                    'percentages' => Experiment::getPercentages(),
                                                                    'efforts' => Experiment::getEfforts(),
                                                                    'priorities' => Experiment::getPriorities()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExperienceFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperienceFormRequest $request)
    {
        $inputs = $request->all();
        $inputs['creator_id'] = Auth::id();

        Experiment::create($inputs);

        return \Redirect::route('experiments')->with('message', 'Experiment added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $experiment = Experiment::find($id);

        return view('experiments/edit')->with('data', array(    'experiment' => $experiment,
                                                                'selects' => array('phases' => Experiment::getPhases(),
                                                                                   'percentages' => Experiment::getPercentages(),
                                                                                    'efforts' => Experiment::getEfforts(),
                                                                                    'priorities' => Experiment::getPriorities())));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExperienceFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExperienceFormRequest $request, $id)
    {
        $experiment = Experiment::find($id);
        $experiment->update($request->all());

        return \Redirect::route('experiments')->with('message', 'Experiment updated successfully!');
    }

    /**
     * Update the specified resource in storage to archived.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $experiment = Experiment::find($id);
        $experiment->archived = true;
        $experiment->save();

        return \Redirect::route('experiments.archived')->with('message', 'Experiment archived successfully!');
    }

    /**
     * Update the specified resource in storage to unarchived.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unarchive($id)
    {
        $experiment = Experiment::find($id);
        $experiment->archived = false;
        $experiment->save();

        return \Redirect::route('experiments')->with('message', 'Experiment unarchived successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Experiment::destroy($id);

        return \Redirect::route('experiments')->with('message', 'Experiment deleted successfully!');
    }

    /**
     * Get Report from Experiment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report($id)
    {
        $experiment = Experiment::find($id);

        return view('experiments/report')->with('data', array('experiment' => $experiment,
                                                            'selects' => array('phases' => Experiment::getPhases(),
                                                                               'percentages' => Experiment::getPercentages(),
                                                                                'efforts' => Experiment::getEfforts(),
                                                                                'priorities' => Experiment::getPriorities())));
    }
}
