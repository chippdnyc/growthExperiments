@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left" style="width: 10%">Dates</h3>
                    <a href="/experiments/reports{{ $params }}date=last3months" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Last 3 Months</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}date=lastmonth" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Last Month</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}date=thismonth" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">This Month</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}date=lastweek" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Last Week</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}date=thisweek" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">This Week</button>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left" style="width: 10%">Phase</h3>
                    <a href="/experiments/reports{{ $params }}phase=1" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Brainstorm</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=2" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Prioritize</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=3" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Build</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=4" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Test</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=5" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Analyze</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=6" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Winner</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}phase=7" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Loser</button>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left" style="width: 10%">Priority</h3>
                    <a href="/experiments/reports{{ $params }}priority=1" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Critical</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}priority=2" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">High Priority</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}priority=3" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Neutral</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}priority=4" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Low priority</button>
                    </a>
                    <a href="/experiments/reports{{ $params }}priority=5" />
                        <button class="btn btn-primary btn-sm" style="margin-left: 10px">Unknown</button>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left" style="width: 20%; color: #FFFFFF">Reset Filters</h3>
                    <a href="/experiments/reports" />
                        <button class="btn btn-success btn-sm pull-right" style="margin-left: 10px">Reset</button>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left">Reports</h3>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    @if (count($experiments))
                    <table class="table">
                        <thead class="thead-default">
                            <tr>
                                <th>Name</th>
                                <th>Phase</th>
                                <th>Priority</th>
                                <th>Creator</th>
                                <th>Due Date</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($experiments as $experiment)
                            <tr>
                                <td>
                                    <a href="/experiments/report/{{ $experiment->id }}" />{{ $experiment->name }}</a>
                                </td>
                                <td>{{ $experiment->getPhase($experiment->phase) }}</td>
                                <td><span class="label label-{{ $experiment->getPriorityLabel($experiment->pr_priority) }}">{{ $experiment->getPriority($experiment->pr_priority) }}</span></td>
                                <td>{{ $experiment->creator->name }}</td>
                                <td>{{ $experiment->due_date }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-{{ $experiment->getPhaseProgressColor($experiment->phase) }}" role="progressbar" aria-valuenow="{{ $experiment->getPhaseProgress($experiment->phase) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $experiment->getPhaseProgress($experiment->phase) }}%"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a title="Report" href="/experiments/report/{{ $experiment->id }}">
                                        <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No experiments found!</p>
                    @endif
                </div>
            </div>

            {{ $experiments->links() }}
        </div>
    </div>
</div>
@endsection
