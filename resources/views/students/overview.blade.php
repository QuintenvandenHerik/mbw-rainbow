@extends('layouts.app') 

@section('content')
<?php
$totalHour = 0;
$totalHoursPercentage = 0;
?>

<div class="container">

    <a href="/" class="btn btn-outline-secondary">Terug</a>
    <a href="/changepassword" class="btn btn-outline-primary row-fix">Wachtwoord veranderen</a>

    <br><br>

    <div class="card border-secondary mb-3" style="max-width: 100%;">
            <div class="card-header"><h5>{{$student->name}}</h5></div>
            <div class="progress totalProgress">
                @foreach ($student->projectUsers as $projectUser)
                    <?php
                    $totalHour = $totalHour + $projectUser->totalHours();
                    $totalHoursPercentage = $projectUser->totalHoursPercentage($totalHour);
                    ?>
                @endforeach
                <span class="MainProgress-type">{{ $totalHoursPercentage['percentage'] }}%</span>
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="
                    @if($totalHoursPercentage == 0)
                        width:0%
                    @elseif($totalHoursPercentage != 0)
                        width:{{ $totalHoursPercentage['percentage'] }}%
                    @endif; max-width: 100%">
                </div>
                <h5 id="totalProgressTekst">{{ $totalHour }} / {{ $totalHoursPercentage['totalHours'] }}</h5>
            </div>
            <div class="card-body text-secondary">
                <h5 class="card-title">Projecten: <span class="badge badge-primary">{{count($student->projects)}}</span>
                </h5>
                   <ul class="list-group list-group">
                        @if(!count($student->projects))
                           <li class="list-group-item">Student is nog niet toegevoegd aan project</li>
                        @endif

                        @foreach ($student->projectUsers as $projectUser)
                            <li class="list-group-item">
                                <a href="{{ $projectUser->id }}/hours">{{ $projectUser->ProjectName() }}</a>
                                <br>
                                <div class="hours">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $projectUser->HoursPercentage() }}%; max-width: 100%;">
                                            <span class="sr-only">{{ $projectUser->HoursPercentage() }}% Complete</span>
                                        </div>
                                        <span class="progress-type">Uren</span>
                                        <span class="progress-completed">{{ $projectUser->HoursPercentage() }}%</span>
                                    </div>
                                    {!! Form::open(['id' => 'form-container' . $projectUser->id, 'action' => ['HoursController@requestHoursToProject', $student->id, $projectUser->id], 'method' => 'POST']) !!} 
                                    @csrf
                                    <div class="hoursInputButton">
                                        {{Form::number('hours', null,['class' => 'hoursInput', 'placeholder' => 'Uren', 'required' => 'autofocus'])}}
                                        <div class="ui-group-buttons">
                                        @method('PUT')
                                        {{Form::submit('Aanpassen', ['class' =>'btn btn-success'])}}
                                        </div>
                                    </div>
                                    {!! Form::close() !!} 
                                </div>
                            </li>
                       @endforeach
                  </ul>
              <hr>
              <small>Geschreven op {{$student->created_at}}</small>
              <hr>
            </div>
    </div>
</div>
@endsection

