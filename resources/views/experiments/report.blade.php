@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>General Info</h3>
                    <label>Name</label>
                    <p style="font-size: 15px">{{ $data['experiment']->name }}</p>
                    <label>Tags</label>
                    <p style="font-size: 15px">{{ $data['experiment']->tags }}</p>
                </div>
                <div class="col-md-6">
                    <h3 style="color: #FFFFFF">Blank</h3>
                    <label>Phase</label>
                    <p style="font-size: 15px">{{ $data['selects']['phases'][$data['experiment']->phase] }}</p>
                    <label>Due Date</label>
                    <p style="font-size: 15px">{{ $data['experiment']->due_date }}</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Brainstorm</h3>
                    <label>What is the success metric?</label>
                    <small style="display: block; margin-bottom: 5px;">What is the experiment's success metric? Ex: Number of visits, sign-up conversion rate...</small>
                    <p style="font-size: 15px">{{ $data['experiment']->bs_metric }}</p>
                    <label>What is your goal?</label>
                    <small style="display: block; margin-bottom: 5px;">What is your experiment's goal? Ex: From 10% to 15%, from $12 to $14...</small>
                    <p style="font-size: 15px">{{ $data['experiment']->bs_goal }}</p>
                    <label>What is the impact on your user base?</label>
                    <small style="display: block; margin-bottom: 5px;">The % of your user base that'll be affected by the improvement.</small>
                    <p style="font-size: 15px">{{ $data['selects']['percentages'][$data['experiment']->bs_impact] }}</p>
                </div>
                <div class="col-md-6">
                    <h3 style="color: #FFFFFF">Blank</h3>
                    <label>What's the confidence rate?</label>
                    <small style="display: block; margin-bottom: 5px;">Based on previous experiments and acquired knowledge, roughly estimate the probability of your test being successful.</small>
                    <p style="font-size: 15px">{{ $data['selects']['percentages'][$data['experiment']->bs_confidence] }}</p>
                    <label>How much effort will it take?</label>
                    <small style="display: block; margin-bottom: 5px;">How much effort will it take to ship this test and run it.</small>
                    <p style="font-size: 15px">{{ $data['selects']['efforts'][$data['experiment']->bs_effort] }}</p>
                    <label>How will you measure the results?</label>
                    <small style="display: block; margin-bottom: 5px;">Describe how you plan to run the test and measure the results.</small>
                    <p style="font-size: 15px">{!! nl2br(e($data['experiment']->bs_results)) !!}</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Prioritize</h3>
                    <label>Priority</label>
                    <p style="font-size: 15px">{{ $data['selects']['priorities'][$data['experiment']->pr_priority] }}</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Build</h3>
                    <label>Build Start Date</label>
                    <p style="font-size: 15px">{{ $data['experiment']->bl_startdate }}</p>
                    <label>Build End Data</label>
                    <p style="font-size: 15px">{{ $data['experiment']->bl_enddate }}</p>
                </div>
                <div class="col-md-6">
                    <h3 style="color: #FFFFFF">Blank</h3>
                    <label>Assignees</label>
                    <p style="font-size: 15px">{{ $data['experiment']->bl_assignees }}</p>
                    <label>Instructions</label>
                    <p style="font-size: 15px">{!! nl2br(e($data['experiment']->bl_instructions)) !!}</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Test</h3>
                    <label>Test Start Date</label>
                    <p style="font-size: 15px">{{ $data['experiment']->ts_startdate }}</p>
                </div>
                <div class="col-md-6">
                    <h3 style="color: #FFFFFF">Blank</h3>
                    <label>Test End Date</label>
                    <p style="font-size: 15px">{{ $data['experiment']->ts_enddate }}</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Analyze</h3>
                    <label>How much % of improve or decrease?</label>
                    <small style="display: block; margin-bottom: 5px;">Be quantitative! Compare the results of your baseline KPI (the point you started from on Brainstorm > What was your goal).</small>
                    <p style="font-size: 15px">{!! count($data['experiment']->al_results_quantitative) > 1 ? $data['experiment']->al_results_quantitative : "N/A" !!}</p>
                    <label>Did the test achieve its goals?</label>
                    <small style="display: block; margin-bottom: 5px;">Check on "Brainstorm"> "What is the goal?"</small>
                    <p style="font-size: 15px">{!! $data['experiment']->al_goal_achieved == 0 ? "NO" : "YES" !!}</p>
                </div>
                <div class="col-md-6">
                    <h3 style="color: #FFFFFF">Blank</h3>
                    <label>What were the results of the experiment?</label>
                    <small style="display: block; margin-bottom: 5px;">How close to your initial hypothesis? Why did you get the result that you did?</small>
                    <p style="font-size: 15px">{!! count($data['experiment']->al_results) > 1 ? $data['experiment']->al_results : "N/A"  !!}</p>
                    <label>What did you learn from this experiment?</label>
                    <small style="display: block; margin-bottom: 5px;">Share here your hits, misses and important things you've learned...</small>
                    <p style="font-size: 15px">{!! count($data['experiment']->al_learnings) > 1 ? $data['experiment']->al_learnings : "N/A" !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
